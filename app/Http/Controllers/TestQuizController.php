<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Lib\Wallet;
use App\Lib\Notify;
use App\Lib\System;
use App\User;
use App\Quiz;
use App\Question;
use App\Entry;

class TestQuizController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $wallet;
    protected $notify;
    protected $system;
    
    public function __construct()
    {
     	//~ $this->wallet = new Wallet;
        $this->notify = new Notify;
		$this->system = new System; 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$today = date_create();
		$test_id = rand(100, 9000)*time();
		$questions = Question::limit('50')->inRandomOrder()->get();
		return view('testquiz.board',[ 'test_id' => $test_id, 'questions' => $questions]);
    }
    
    public function closed($id)
    {
		$today = strtotime("now");
		
		$quiz = Quiz::find($id);
		$quiz_start_date = strtotime($quiz->start_datetime);
		$quiz->minutes = $this->system->total_minutes($quiz_start_date, $today);
		
		//~ if ($today > $quiz_start_date)
		if ($quiz->minutes < 60)
		{
			//~ $diff=date_diff($today,$quiz_start_date);
			//~ return $diff->format("%R%h");
			
			return view('join.closed', ['quiz'=> $quiz ]);
		}
		else
		{
			return redirect()->route('join', ['id' => $id ]);
		}
		
        
    }
    
    public function success($id)
    {
		$quiz = Quiz::find($id);
        $user_id = Auth::user()->id;
		$entry = Entry::where([ ["user_id",$user_id],["quiz_id",$id] ])->get()->first();
		
		if (empty($entry->id))
		{
			return redirect()->route('join', ['id' => $id ]);
		}
		
        return view('join.success', ['quiz'=> $quiz , 'entry' => $entry]);
    }
    
    public function action($id, Request $request)
    {
		$user = Auth::user();
        $validator = Validator::make($request->all(), ['*' =>'required','avatar' =>'nullable', ] );

        if ($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
		{
			if ($request->action == "joinquiz")
			{
				$quiz = Quiz::find($id);
				
				if ($this->wallet->balance() < $quiz->entry_fee)
				{
					$errors = array("Your wallet balance is low, please fund your wallet and try again");
					return redirect()->route("wallet.fund")->withErrors($errors);
				}
				
				$debit_data = array( "amount" => $quiz->entry_fee, "method" => "QUIZ GAME", "desc" => "#".$quiz->id." Quiz Entry Fee", "details" => "Quiz Game", );
				$this->wallet->debit($debit_data);
				
								
				$entry = new Entry;
				$entry->quiz_id = $id ;
				$entry->user_id = $user->id;
				$entry->memo = "Pay with wallet";
				$entry->answers = "NONE";
				$entry->score = 0;
				$entry->status = 1;
				$entry->save();
				  
				//Notify
				$info = array("message" => "You have successfully enrolled for Quiz #".$id, "flash" => "You have successfully joined Quiz #".$id);
				$this->notify->put($info);
				
				return redirect()->route('join.success', ['id' => $id ]);
			}
			
		}
	}
}
