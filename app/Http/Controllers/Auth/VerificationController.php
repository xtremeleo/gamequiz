<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewUser;
use App\Mail\NewBank;
use App\Mail\WithdrawalRequest;
use App\Lib\Wallet;
use App\User;
use App\Account;
use App\WithdrawalRequest as WLRT;

class VerificationController extends Controller
{
    //
    
    public function index($id, $code)
    {
		$user = User::find($id);
		
		if (empty($user))
		{
			return view('register.notverified');
		}
		else
		{
			$confirmEmail = sha1($user->email);
			
			if (!empty($user->email_verified_at))
			{
				return redirect()->route('dashboard');
			}
			else
			{
				if ($confirmEmail == $code)
				{
					$user->email_verified_at = date("Y-m-d H:i:s");
					$user->status = "ACTIVE";
					$user->save();
					return view('auth.verified', ['user' => $user]);
				}
				else
				{
					return view('auth.notverified');
				}
			}
			
		}
		
	}
	
    public function bank_account($id, $account, $code, $res)
    {
		$user = Auth::user();
		
		if ($user->id != $id)
		{
			return redirect()->route('account');
		}
		else
		{
			$account = Account::where(['id' => $account, 'user_id' => $user->id])->get()->first();
			
			if (empty($account->id))
			{
				$errors = array("This bank account does not exist.");				
				return redirect()->route('account.bank')->withErrors($errors);
			}
			else
			{
				if ($account->status == "PENDING")
				{
					$confirmNumber = sha1($account->number);
					
					if ($confirmNumber == $code)
					{
						if ($res == "a")
						{
							$account->status = "APPROVED";
							$account->save();
							session()->flash('message', 'Your bank account has been approved');
						}
						elseif ($res == "d")
						{
							$account->delete();
							session()->flash('message', 'Your bank account has been rejected and deleted.');
						}
						
						
						return redirect()->route('account.bank');
					}
					else
					{
						return redirect()->route('account.bank');
					}
				}
				else
				{
					session()->flash('message', 'Your bank account has been approved already.');
					return redirect()->route('account.bank');
				}
			}
			
		}
		
	}
		
    public function withdraw($user_id, $wlrt_id, $code, $res)
    {
		$user = Auth::user();
		$user_wallet = new Wallet;
		
		if ($user->id != $user_id)
		{
			return redirect()->route('account');
		}
		else
		{
			$wlrt = WLRT::where(['id' => $wlrt_id, 'user_id' => $user->id])->get()->first();
			
			if (empty($wlrt->id))
			{
				$errors = array("This withdrawal request does not exist.");				
				return redirect()->route('account.bank')->withErrors($errors);
			}
			else
			{
				if ($wlrt->status == "PENDING")
				{
					$confirmNumber = sha1($wlrt->id);
					
					if ($confirmNumber == $code)
					{
						if ($res == "a" && $user_wallet->balance() >= $wlrt->amount )
						{
							$recipient_details = json_decode($wlrt->account->data);
							
							$data = array(
													"amount" => $wlrt->amount,
													"reference" => mt_rand(1000,9000)*$wlrt->id,
													"reason" => "Withdrawing Winnings",
													"recipient" => $recipient_details->recipient_code,
													"recipient_data" => $wlrt->account->data,
												);
												
							//return $user_wallet->transfer_to_bank($data);
							$tr_raw_response = $user_wallet->transfer_to_bank($data);
							$tr_response = json_decode($tr_raw_response);
							
							if ($tr_response->status)
							{
								if ($tr_response->data->status == "success")
								{
									$wlrt->status = "APPROVED";
									$wlrt->details = $tr_raw_response;
									$wlrt->save();
									
									$debit_data = array( "amount" => $wlrt->amount, "method" => "PAYSTACK", "desc" => "Fund withdrawal", "details" => json_encode($tr_response->data), );
									$user_wallet->debit($debit_data);
									
									session()->flash('message', 'Your withdrawal request has been approved and funds has been sent..');
								}
								else
								{
									$wlrt->status = "APPROVED";
									$wlrt->details = $tr_raw_response;
									$wlrt->save();
									session()->flash('message', 'Your withdrawal request has been approved but there was an issue with fund transfer, customer care has been notified.');
								}
							}
							else
							{
								$wlrt->status = "APPROVED";
								$wlrt->details = $tr_raw_response;
								$wlrt->save();
								session()->flash('message', 'Your withdrawal request has been approved but there was an issue with fund transfer, customer care has been notified.');
							}
							
						}
						elseif ($res == "d")
						{
							$wlrt->status = "DECLINED";
							$wlrt->save();
							session()->flash('message', 'Your withdrawal request has been declined.');
						}
						
						
						return redirect()->route('wallet');
					}
					else
					{
						return redirect()->route('account.bank');
					}
				}
				else
				{
					session()->flash('message', 'This withdrawal request has been '.strtolower($wlrt->status).' already.');
					return redirect()->route('account.bank');
				}
			}
			
		}
		
	}
	
	public function needed()
	{
		return view('auth.notverified');
	}
	
	public function send()
	{
		$user = Auth::user();
		Mail::to($user->email)->send(new NewUser($user));
		
		session()->flash('message', 'Your verification link has been sent');
		return redirect()->route('verify.needed');
	}
}
