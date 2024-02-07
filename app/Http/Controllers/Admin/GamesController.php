<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Lib\Game;
use App\Lib\System;
use App\User;
use App\Quiz;
use App\Question;
use App\Transaction;
use App\Entry;

class GamesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    protected $game;
    protected $system;
    protected $pagination;
    
    public function __construct()
    {
        $this->middleware(['auth','only.admin']);
        $this->game = new Game;
		$this->system = new System; 
		$this->pagination = 10; 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		
		$quizzes = Quiz::orderBy("id", "DESC")->paginate($this->pagination);
		$page = collect();
		$page->title = "Quizzes";
		
        return view('admin.games.index',compact('page','quizzes'));
    }
    
    public function create()
    {
		$page = collect();
		$page->title = "Create New Quiz";
		$page->action = "add-quiz";
		$fields = $this->get_quiz_fields();
		$_id = 0;
		
		return view('admin.games.edit', compact('fields', 'page', '_id'));
	}
	
    public function edit(Request $request)
    {
		$page = collect();
		$page->title = "Edit Quiz";
		$page->action = "update-quiz";
		$fields = $this->get_quiz_updated_fields($request->_id);
		$_id = $request->_id;
		
		return view('admin.games.edit', compact('fields', 'page', '_id'));
	}
	    
    public function questions(Request $request)
    {
		if (empty($request->_id))
		{
			return redirect()->route("admin.games.new");
		}
		else
		{
			$quiz = Quiz::find($request->_id);
			
			if (empty($quiz->id))
			{
				return redirect()->route("admin.games.new");
			}
		
			$page = collect();
			$page->title = "Quiz Questions";
			$page->action = "add-questions";
			$fields = $this->get_quiz_questions_updated_fields($quiz->id);
			$_id = $request->_id;
			
			return view('admin.games.questions', compact('fields', 'page', '_id'));
		}
		
	}

	public function get_quiz_fields()
	{
		$time_options = get_time_options();
		
		$fields = array(
							array("name" => "winning_percent", "type" => "number","display_name" => "Percent for allocation of prize", "value" => "", "required" => "required", "valid" => "required|string"),
							array("name" => "start_date", "type" => "date","display_name" => "Start date", "value" => "", "required" => "required", "valid" => "required|string"),
							array("name" => "start_time", "type" => "select","display_name" => "Start time", "value" => "", "options" => $time_options, "required" => "required", "valid" => "required|string"),
							array("name" => "end_date", "type" => "date","display_name" => "End date", "value" => "", "required" => "required", "valid" => "required|string"),
							array("name" => "end_time", "type" => "select","display_name" => "End time", "value" => "", "options" => $time_options, "required" => "required", "valid" => "required|string"),
							//~ array("name" => "questions", "type" => "number","display_name" => "How many questions should be allocated?", "value" => "", "required" => "required", "valid" => "required|string"),
							array("name" => "prize", "type" => "number","display_name" => "Prize", "value" => "", "required" => "required", "valid" => "required|string"),
						);
		
		return json_decode(json_encode($fields));
	}
	
	public function get_quiz_updated_fields($quiz_id)
	{
		$quiz = Quiz::find($quiz_id);
		
		$fields = $this->get_quiz_fields();
		
		foreach($fields as $key => $field)
		{
			if ($field->name == "questions" )
			{
				$question_count = $quiz->questions();
				$field->value = count($question_count);
			}
			else
			{
				$field->value = "123";
			}
			
		}
		
		return $fields;
	}
	
	
	public function get_quiz_questions_fields()
	{
		$fields = array(
							array(
									"question" => "", 
									"options" => array( "a" => "", "b" => "", "c" => "", "d" => ""),
								),
							
						);
		
		return json_decode(json_encode($fields));
	}
	
	public function get_quiz_questions_updated_fields($quiz_id)
	{
		$quiz = Quiz::find($quiz_id);
		
		$fields = $this->get_quiz_questions_fields();
		$questions = json_decode($quiz->questions);
		
		if (empty($questions))
		{
			return $fields;
		}
		else
		{
			return $questions;
		}
		
	}
	
	
	public function get_quiz_fields_validation()
	{
		$fields = $this->get_quiz_fields();
		
		$validate = array();
		
		foreach($fields as $field)
		{
			//~ $validate[] = array($field->name => $field->required);
			$validate[$field->name] = $field->valid;
		}
		
		return $validate;
	}
	
	public function action(Request $request)
	{
		if ($request->action == "add-quiz")
		{
			$valids = $this->get_quiz_fields_validation();
			//~ $valids["_id"] = "required|exists:expenses,id";
			
			//~ return $valids;
			$validator = Validator::make($request->all(), $valids);

			if ($validator->fails()) 
			{
				$request->flash();
				return back()->withErrors($validator)->withInput();
			}
			else
			{
				$start_datetime = date("Y-m-d H:i:s", strtotime($request->start_date." ". $request->start_time) );
				$end_datetime = date("Y-m-d H:i:s", strtotime($request->end_date." ". $request->end_time) );
				
				//~ return $start_datetime;
				
				$questions = array();
				
				$new_quiz = new Quiz;
				$new_quiz->winning_percent = $request->winning_percent;
				$new_quiz->start_datetime = $start_datetime;
				$new_quiz->end_datetime = $end_datetime;
				$new_quiz->prize = $request->prize;
				$new_quiz->questions = json_encode($questions);
				$new_quiz->save();
				
				return redirect()->route("admin.games.questions", ["_id" => $new_quiz->id ]);
			}
		
		}
		
		if ($request->action == "add-questions")
		{
			$valids["_id"] = "required|exists:quizzes,id";
			
			//~ return $valids;
			$validator = Validator::make($request->all(), $valids);

			if ($validator->fails()) 
			{
				return redirect()->route("admin.games");
			}
			else
			{
				$questions = $request->data;
				
				$quiz = Quiz::find($request->_id);
				$quiz->questions = json_encode($questions);
				$quiz->save();
				
				return redirect()->route("admin.games");
			}
		}
	}
}
