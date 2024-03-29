<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Lib\Game;
use App\Lib\System;
use App\User;
use App\Quiz;
use App\Transaction;
use App\Entry;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    protected $game;
    protected $system;
    
    public function __construct()
    {
        $this->middleware(['auth','only.user','user.active']);
        $this->game = new Game;
		$this->system = new System; 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$today = date_create("yesterday");
		$user_id = Auth::user()->id;
		
		$query = array("user_id" => $user_id);
		$transactions = Transaction::where($query)->orderBy("id","desc")->limit(10)->get();
		
		$entries = Entry::where("user_id",$user_id)->orderBy('id', 'DESC')->get();
		$quiz_ids = array_column($entries->toArray(), 'quiz_id');
		
		$quizzes = Quiz::whereIn("id",$quiz_ids)->where("start_datetime",">",$today)->get();
		$quizzes->each(function($item, $key){
			
			$today = date("Y-m-d H:i:s");
			$item->minutes = $this->system->total_minutes($item->start_datetime, $today);
			
			if ($item->minutes > 61 )
			{
				$item->action = "soon";
			}
			elseif ($item->minutes > 21 )
			{
				$item->action = "very_soon";
			}
			else
			{
				$end = $this->system->total_minutes($item->end_datetime, $today);
				if ($end < 0 )
				{
					$item->action = "closed";
				}
				else
				{
					$item->action = "start";
				}
				
			}
		});
		
		
        return view('user.dashboard',['entries' => $entries, 'transactions' => $transactions, 'quizzes' => $quizzes]);
    }
}
