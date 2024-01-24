<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewBank;
use App\Mail\WithdrawalRequest as WLRTMail;
use App\Lib\Wallet;
use App\Lib\System;
use App\Lib\Notify;
use App\User;
use App\Account;
use App\Bank;
use App\Transaction;
use App\WithdrawalRequest;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    protected $public_key;
    protected $secret_key;
    protected $wallet;
    protected $system;
    protected $notify;
    protected $minimum_amount = 500;
    
    public function __construct()
    {
        $this->middleware(['auth','only.user','user.active']);
        $this->public_key = config('paystack.public_key');
		$this->secret_key = config('paystack.secret_key');
		$this->wallet = new Wallet;
        $this->system = new System;
        $this->notify = new Notify;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {	
		$user = Auth::user();
		$account = Account::where('user_id', $user->id)->get()->first();
		$activities = $this->notify->get();
		
        return view('user.account.index',['user' => $user, 'account' =>$account, 'activities' => $activities ]);
    }
    
    public function activities()
    {	
		$user = Auth::user();
		$activities = $this->notify->get();
		
        return view('user.account.activities',['user' => $user, 'activities' => $activities ]);
    }
        
    public function bank()
    {	
		$user = Auth::user();
		$accounts = Account::where('user_id', $user->id)->get();
        return view('user.account.bank',['user' => $user, 'accounts' =>$accounts ]);
    }
    
    public function action(Request $request)
    {
		$user = Auth::user();
		if ($request->action == "save_details")
		{
			$validator = Validator::make($request->all(), [
				'*' => 'required',
				'image' => 'nullable',
			], $this->error_messages() );

			if ($validator->fails()) 
			{
				return redirect()->back()->withErrors($validator)->withInput();
			}
			else
			{
				$user_info = User::find($user->id);
				$user_info->name = $request->name ?? $user->name;
				$user_info->mobile = $request->mobile ?? $user->mobile;
				$user_info->avatar = (empty($request->image) ? $user_info->avatar : $this->system->decode_chunk($request->image) );
				$user_info->save();
				
				//Notify
				$info = array("message" => "You made some changes to your profile details which was saved sucessfully", "flash" => "Your details has been saved");
				$this->notify->put($info);
				
				return redirect()->route('account');
			
			}
		}	
		
		if ($request->action == "add_bank")
		{
			$validator = Validator::make($request->all(), [
				'bank' =>'required|exists:banks,id',
				//~ 'acct_name' =>'required', 
				'acct_number' =>'required|min:10|max:10',//'|unique:accounts,number', 
			], $this->error_messages() );

			if ($validator->fails()) 
			{
				return redirect()->back()->withErrors($validator)->withInput();
			}
			else
			{
				$bank = Bank::find($request->bank);
				
				$data = array("bank_code"=> $bank->code, "number" => $request->acct_number);
				
				$response = $this->verify_bank_account($data);
				
				if ($response->status)
				{
					$data = array("name" => $response->data->account_name, "code"=> $bank->code, "number" => $request->acct_number);
					
					$transfer_code = $this->initial_transfer_code($data);
					//~ return print_r($transfer_code);
					
					if (!$transfer_code->status && empty($transfer_code->data->recipient_code) )
					{
						$errors = array("Bank Account Verification Error, please check your details and try again");
						return redirect()->back()->withErrors($errors)->withInput();
					}
					
					$acct = new Account;
					$acct->name = $response->data->account_name;
					$acct->number = $request->acct_number;
					$acct->bank_id = $bank->id;
					$acct->data = json_encode($transfer_code->data);
					$acct->user_id = $user->id;
					$acct->save();
					
					Mail::to($user->email)->send(new NewBank($user, $acct));
					
					//Notify
					$info = array("message" => "You added a new bank account, it is awaiting approval", "flash" => "Your bank account was added, awaiting approval");
					$this->notify->put($info);
				}
				else
				{
					$errors = array("Bank Account Verification Error, please check your details and try again");
					return redirect()->back()->withErrors($errors)->withInput();
				}
				
				return redirect()->route('account.bank');
			
			}
		}	
		
		if ($request->action == "withdraw")
		{
			$amount = $this->wallet->balance();
			$minimum_amount = $this->minimum_amount;
			
			$validator = Validator::make($request->all(), [
				'bank_account' =>'required|exists:accounts,id',
				'withdraw_amount' =>'required|gte:'.$minimum_amount.'|lte:'.$amount, 
			], $this->error_messages() );

			if ($validator->fails()) 
			{
				return redirect()->back()->withErrors($validator);
			}
			else
			{
				$detail = array("ip_address" => request()->ip() ?? 0, "device" => request()->server('HTTP_USER_AGENT')." FROM: ".request()->url());
				
				$wlrt = new WithdrawalRequest;
				$wlrt->amount = $request->withdraw_amount;
				$wlrt->account_id = $request->bank_account;
				$wlrt->details = json_encode($detail);
				$wlrt->user_id = $user->id;
				$wlrt->save();
				
				Mail::to($user->email)->send(new WLRTMail($user, $wlrt));
				
				//Notify
				$info = array("message" => "Your withdrawal request was saved, it is awaiting verification from you", "flash" => "Your withdrawal request has been saved, please verify your request from the verification email sent to you");
				$this->notify->put($info);
				
				return redirect()->route('account.bank');
			}
		}
	
	}
    
    public function details_edit()
    {	
		$user = Auth::user();
		
        return view('user.account.details_edit',['user' => $user, ]);
    }
    
    public function get_banks()
    {
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.paystack.co/bank?country=nigeria",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			  "Authorization: Bearer ".$this->secret_key,
			  "Cache-Control: no-cache",
			),

		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		$banks = json_decode($response);
		
		foreach($banks->data as $bank)
		{
			$bk = new Bank;
			$bk->id = $bank->id;
			$bk->name = $bank->name;
			$bk->slug = $bank->slug;
			$bk->code = $bank->code;
			$bk->data = json_encode($bank);
			$bk->save();
		}
	
	}
	
	public function verify_bank_account($data)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.paystack.co/bank/resolve?account_number=".$data['number']."&bank_code=".$data['bank_code'],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			  "Authorization: Bearer ".$this->secret_key,
			  "Cache-Control: no-cache",
			),
		));
		
		$raw_response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) 
		{
			return false;
		} 
		else 
		{
			//~ return $raw_response;
			$response = json_decode($raw_response);
			return $response;
		}
		
	}

	public function initial_transfer_code($data)
	{
		$url = "https://api.paystack.co/transferrecipient";
		$fields = [
			'type' => "nuban",
			'name' => $data['name'],
			'account_number' => $data['number'],
			'bank_code' => $data['code'],
			'currency' => "NGN"
		];
		
		$fields_string = http_build_query($fields);
		
		//open connection
		$ch = curl_init();
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Bearer ".$this->secret_key,
			"Cache-Control: no-cache",
		));
		
		//So that curl_exec returns the contents of the cURL; rather than echoing it
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
		
		//execute post
		$result = curl_exec($ch);
		return json_decode($result);
	}
	
	public function error_messages()
	{
		$messages = array(
								"acct_number.unique" => "The account number has already been added.",
								"withdraw_amount.lte" => "The amount you wish to withdraw can not be greater than your wallet balance, which is ₦".$this->wallet->balance().",",
								"withdraw_amount.gte" => "Minimum amount for withdrawal is ₦".$this->minimum_amount.",",
							);
		return $messages;
	} 
	
}
