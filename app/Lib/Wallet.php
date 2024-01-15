<?php
namespace App\Lib;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Transaction;

class Wallet
{
	protected $public_key;
    protected $secret_key;
    
    public function __construct()
    {
		$this->public_key = config('paystack.public_key');
		$this->secret_key = config('paystack.secret_key');
    }

	public function balance()
	{
		$user = Auth::user();
		$query = array("user_id" => $user->id, "status" => "APPROVED");
		$transactions = Transaction::where($query)->get();
		
		return $transactions->sum("amount");
	}

	public function debit($data)
	{
		$user = Auth::user();
		
		$debit = new Transaction;
		$debit->amount = "-".$data['amount'];
		$debit->type = "DEBIT"; 
		$debit->method = $data['method'];
		$debit->description = $data['desc']; 
		$debit->details = $data['details']; 
		$debit->user_id = $user->id; 
		$debit->trans_date = date("Y-m-d"); 
		$debit->status = "APPROVED"; 
		$debit->save(); 
		
	}
	
	public function transfer_to_bank($data)
	{
		$url = "https://api.paystack.co/transfer";
		$fields = ['source' => "balance",'amount' => $data['amount'],"reference" => $data['reference'], 'recipient' => $data['recipient'], 'reason' => $data['reason'] ];
		
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
		return $result;
	}
	
}
