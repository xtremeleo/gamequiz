<?php
namespace App\Lib;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Quiz;
use App\Entry;

class Game
{
	//~ protected $public_key;
    //~ protected $secret_key;
    
    public function __construct()
    {
		//~ $this->public_key = config('paystack.public_key');
		//~ $this->secret_key = config('paystack.secret_key');
    }

	public function position(Quiz $quiz)
	{
		$user = Auth::user();
		
		$query = array("quiz_id" => $quiz->id, array("score",">","0") );
		$entries = Entry::where($query)->orderBy("score","DESC")->limit(30)->get();
		$scores = array();
		
		foreach($entries as $key => $entry)
		{
			$scores[$entry->user_id] = $key + 1;
		}
		
		
		
		if (empty($scores[$user->id]))
		{
			return "FAILED";
		}
		else
		{
			$position = $scores[$user->id];
			return $this->ordinal($position);
		}
		
		//~ return json_encode($scores);
				
	}

	public function score(Quiz $quiz)
	{
		$user = Auth::user();
		
		$query = array("quiz_id" => $quiz->id, "user_id" => $user->id);
		$entry = Entry::where($query)->get()->first();
		
		return $entry->score;
	
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
	
	public function ordinal($number) 
	{
		$ends = array('th','st','nd','rd','th','th','th','th','th','th');
		
		if ((($number % 100) >= 11) && (($number%100) <= 13))
		{
			return $number. 'th';
		}
		else
		{
			return $number. $ends[$number % 10];
			
		}
	}
	
}
