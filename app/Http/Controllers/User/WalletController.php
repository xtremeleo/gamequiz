<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Lib\Notify;
use App\User;
use App\Account;
use App\Transaction;

class WalletController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    protected $public_key;
    protected $secret_key;
    protected $notify;
    
    public function __construct()
    {
        $this->middleware(['auth','only.user','user.active']);
        $this->public_key = config('paystack.public_key');
		$this->secret_key = config('paystack.secret_key');
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
		$query = array(
							'user_id' => $user->id,
							//~ 'status' => "APPROVED",
						);
						
		$transactions = Transaction::where($query)->paginate(10);
		
        return view('user.wallet.index',['user' => $user, 'transactions' =>$transactions ]);
    }
    
    public function fund()
    {
		$user = Auth::user();
        return view('user.wallet.fund',['user' => $user, 'public_key' => $this->public_key, ]);
	}
	
    public function action(Request $request)
    {
		$user = Auth::user();
		
		if ($request->action == "fund")
		{
			$validator = Validator::make($request->all(), [
				'amount' => 'required|integer|min:100',
			]);
			 if ($validator->fails()) 
			{
				return redirect()->back()->withErrors($validator)->withInput();
			}
			else
			{
				$transaction = new Transaction; 
				//~ $transaction->id = rand(100000,900000); 
				$transaction->amount = $request->amount; 
				$transaction->type = "CREDIT"; 
				$transaction->method = "PAYSTACK"; 
				$transaction->description = "Funding wallet"; 
				$transaction->details = ""; 
				$transaction->user_id = $user->id; 
				$transaction->trans_date = date("Y-m-d"); 
				$transaction->status = "PENDING"; 
				$transaction->save(); 
				
				$url = "https://api.paystack.co/transaction/initialize";
				$fields = [ 'email' => $user->email, 'amount' => $request->amount * 100, 'order_id' => $transaction->id, 'callback_url' => route('wallet.verify.transaction',["id" => $transaction->id])];
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
				$raw_result = curl_exec($ch);
				$result = json_decode($raw_result);
				//~ $result = json_decode($raw_result, true);
				//~ return $result;
				$transaction = Transaction::find($transaction->id); 
				
				if ($result->status)
				{
					$transaction->details = $raw_result; 
					$transaction->save(); 
					
					return redirect($result->data->authorization_url);
				}
				else
				{
					
					$transaction->details = $raw_result; 
					$transaction->status = "FAILED"; 
					$transaction->save(); 
					
					$error = array("Transaction Error, Please try again!");
					return redirect()->back()->withErrors($error)->withInput();
				}
				
				//~ session()->flash('e', 'Your wallet was funded successfully');
				//~ return redirect()->route('wallet');
			}
		}
		        	
	}
    
    public function verify($id, Request $request)
    {	
		$user = Auth::user();
		$query = array("user_id" => $user->id, "id" => $id, "status" => "PENDING");
		$transaction = Transaction::where($query)->get()->first();
		
		if (empty($transaction->id))
		{
			$error = array("Transaction verification Error, Please try again!");
			return redirect()->route('wallet')->withErrors($error);
		}
		
        //~ return $request;
         $curl = curl_init();
        
         curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$request->reference,
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
			//~ return "cURL Error #:" . $err;
			$error = array("Transaction verification Error, Please try again!","txn: ".$request->reference);
			$transaction->details = json_encode($error);
			$transaction->status = "FAILED"; 
			$transaction->save();
			
			return redirect()->route('wallet')->withErrors($error);
		} 
		else 
		{
			//~ return $raw_response;
			$response = json_decode($raw_response);
			
			if ($response->status)
			{
				//~ return $raw_response;
				
				if ($response->data->status == "success" )
				{
					$previous_details = json_decode($transaction->details);
					
					if (strcmp($previous_details->data->reference, $response->data->reference) == 0 )
					{
						$transaction->details = $raw_response;
						$transaction->status = "APPROVED"; 
						$transaction->save();
						
						
						//Notify
						$info = array("message" => "You have successfully funded your wallet with ₦".number_format($transaction->amount).". ", "flash" => "Your wallet was funded successfully");
						$this->notify->put($info);
				
						return redirect()->route('wallet');
					}
					else
					{
						$error = array("Transaction verification Error, Please try again!","txn: ".$request->reference);
						$transaction->details = $raw_response;
						$transaction->status = "FAILED"; 
						$transaction->save();

						return redirect()->route('wallet')->withErrors($error);
					}	
					
				}
				else
				{
					$error = array("Transaction verification Error, Please try again!","txn: ".$request->reference);
					$transaction->details = $raw_response;
					$transaction->status = "FAILED"; 
					$transaction->save();

					return redirect()->route('wallet')->withErrors($error);
				}
			}
			else
			{
				$error = array("Transaction verification Error, Please try again!","txn: ".$request->reference);
				$transaction->details = json_encode($error);
				$transaction->status = "FAILED"; 
				$transaction->save();

				return redirect()->route('wallet')->withErrors($error);
			}
		}
    }
    
    public function bank_edit()
    {	
		$user = Auth::user();
		$banks = array("Access Bank", "Fidelity Bank", "First City Monument Bank","First Bank","Guaranty Trust Bank","Union Bank","United Bank for Africa","Zenith Bank","Citibank Nigeria", "Ecobank", "  Heritage Bank", "Keystone Bank", "Polaris Bank","Stanbic IBTC Bank", "Standard Chartered Bank"," Sterling Bank","Unity Bank","Wema Bank","SunTrust Bank","Providus Bank", "Jaiz Bank Plc");
		$account = Account::where('user_id', $user->id)->get()->first();
		
        return view('user.account.bank_edit',['user' => $user, 'account' =>$account, 'banks' => $banks ]);
    }
}
