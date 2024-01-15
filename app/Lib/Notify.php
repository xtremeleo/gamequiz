<?php
namespace App\Lib;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Notify as NFY;

class Notify
{
	//~ protected $public_key;
    //~ protected $secret_key;
    
    public function __construct()
    {
		//~ $this->public_key = config('paystack.public_key');
		//~ $this->secret_key = config('paystack.secret_key');
    }

	public function get()
	{
		$user = Auth::user();
		$query = array("user_id" => $user->id,);
		$activities = NFY::where($query)->orderBy("id","desc")->paginate('10');
		
		return $activities;
	}

	public function put($data)
	{
		$user = Auth::user();
		
		$activity = new NFY;
		$activity->message = $data['message'];
		$activity->details = json_encode($this->ip_details()); 
		$activity->user_id = $user->id; 
		$activity->save(); 
		
		if (!empty($data['flash']))
		{
			session()->flash('message', $data['flash']);
		}
		
	}
	
	public function ip_details()
	{
		$details = array("ip_address" => request()->ip() ?? 0, "device" => request()->server('HTTP_USER_AGENT')." FROM: ".request()->url());
		return $details;
	}
	
}
