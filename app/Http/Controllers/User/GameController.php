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
use App\Question;

class GameController extends Controller
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
        $this->middleware(['auth','user.active']);
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
		
		$quizzes = Quiz::where("start_datetime",">",$today)->orderBy("id","desc")->paginate(15);
		$quizzes->each(function($item, $key){
			
			$today = date("Y-m-d H:i:s");
			$item->minutes = $this->system->total_minutes($item->start_datetime, $today);
			
			if ( in_array($item->id, $this->user_entries()) )
			{
				if ($item->minutes > 1 )
				{
					$item->action = "already";
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
				
			}
			else
			{
				if ($item->minutes > 30 )
				{
					$item->action = "can_join";
				}
				else
				{
					$item->action = "cant_join";
				}
				
			}
		});
		
        return view('user.game.index',['quizzes' => $quizzes]);
        
        //~ return redirect()->route('dashboard')->withErrors("No quiz was selected, please selected a quiz!");
    }
    
    public function past()
    {	
		$today = date_create();
		
		$quizzes = Quiz::where("start_datetime",">",$today)->orderBy("id","desc")->paginate(15);
		$quizzes->each(function($item, $key){
					
			if ( in_array($item->id, $this->user_entries()) )
			{
				$item->score = $this->game->score($item);
				$item->position = $this->game->position($item);	
			}
			else
			{
				$item->score = "No Score";
				$item->position = "No Entry"	;
				
			}
		});
		
        return view('user.game.past',['quizzes' => $quizzes]);
        
        //~ return redirect()->route('dashboard')->withErrors("No quiz was selected, please selected a quiz!");
    }
    
    public function start_game($id)
    {	
		$user_id = Auth::user()->id;
		
		if (empty($id))
		{
			return redirect()->route('dashboard')->withErrors("No quiz was selected, please selected a quiz!");
		}
		else
		{
			$query = array("user_id" =>$user_id, "quiz_id" => $id, );
			$entry = Entry::where($query)->get()->first();
			
			if (empty($entry->id))
			{
				return redirect()->route('dashboard')->withErrors("You can not participate in the selected quiz!");
			}
			else
			{
				$quiz = Quiz::find($id);
				$today = date_create();
				$end_time = date_create($quiz->end_datetime);
				
				if ( $today > $end_time )
				{
					$entry->position = $this->game->position($quiz);
					return view('user.game.result',['entry' => $entry, 'quiz' => $quiz ]);
				}
				if ($entry->answers == "NONE" && $entry->score  == 0 )
				{
					$selected_questions = json_decode($quiz->questions,true);
					$questions = Question::whereIn('id', $selected_questions)->get();
					return view('user.game.board',['entry' => $entry, 'quiz' => $quiz, 'questions' => $questions]);
				}
				else
				{
					$entry->position = $this->game->position($quiz);
					return view('user.game.result',['entry' => $entry, 'quiz' => $quiz ]);
				}
				
				
			}
		}
        
    }

    public function ended_game($id)
    {	
		$user_id = Auth::user()->id;
		
		if (empty($id))
		{
			return redirect()->route('dashboard')->withErrors("No quiz was selected, please selected a quiz!");
		}
		else
		{
			$query = array("user_id" =>$user_id, "quiz_id" => $id, );
			$entry = Entry::where($query)->get()->first();
			
			if (empty($entry->id))
			{
				return redirect()->route('dashboard')->withErrors("You can not participate in the selected quiz!");
			}
			else
			{
				$quiz = Quiz::find($id);
				$entry->position = $this->game->position($quiz);
				return view('user.game.result',['entry' => $entry, 'quiz' => $quiz ]);
							
			}
		}
        
    }

	public function submit($id, Request $request)
	{
		$user_id = Auth::user()->id;
		
		if (empty($id))
		{
			return redirect()->route('dashboard')->withErrors("No quiz was selected, please selected a quiz!");
		}
		else
		{
			$query = array("user_id" =>$user_id, "quiz_id" => $id, "answers" => "NONE", "score" => 0);
			$entry = Entry::where($query)->get()->first();
			
			if (empty($entry->id))
			{
				return redirect()->route('dashboard')->withErrors("You can not participate in the selected quiz!");
			}
			else
			{
				$quiz = Quiz::find($id);
				$selected_questions = json_decode($quiz->questions,true);
				$questions = Question::whereIn('id', $selected_questions)->get();
				
				$answers = $request['answers'];
				$results = array(); 
				
				foreach($answers as $key => $answer)
				{
					if (in_array($key, $selected_questions))
					{
						$question = $questions->where('id', $key);
						$question = $question->all();
						$question = array_values($question);
						
						if ($question[0]['answer'] == $answer)
						{
							$results[] = $key;
						}
						
					}
				}
				
				$entry = Entry::find($entry->id);
				$entry->answers = $answers;
				$entry->score = count($results);
				$entry->status = 0;
				$entry->save();
				$entry->position = $this->game->position($quiz);
				
				return view('user.game.result',['entry' => $entry, 'quiz' => $quiz ]);
			}
		}
		
		
	}
	
	
	
	public function user_entries()
	{
		$user_id = Auth::user()->id;
		$entries = Entry::where("user_id",$user_id)->orderBy('id', 'DESC')->get();
		$quiz_ids = array_column($entries->toArray(), 'quiz_id');
		return $quiz_ids;
	}
	
}
