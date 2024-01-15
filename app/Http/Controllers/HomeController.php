<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib\System;
use App\Quiz;
use App\Question;
use App\Visitor;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $system;
    
    public function __construct()
    {
        //~ $this->middleware('auth');
       $this->system = new System; 
       
       $visitor = new Visitor;
		//~ $visitor->ip_address = request()->server('SERVER_ADDR');
		//~ $visitor->ip_address = request()->server('REMOTE_ADDR') ?? 0;
		$visitor->ip_address = request()->ip() ?? 0;
		$visitor->page = $request->redirect ?? url()->full();
		$visitor->details = "SYSTEM: ".request()->server('HTTP_USER_AGENT')." FROM: ".request()->server('HTTP_REFERER');
		$visitor->save();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$today = date_create();
		
		$quizzes = Quiz::where('start_datetime', '>' ,$today)->get();
		
		$quizzes->each(function($item, $key){
			
			$today = date("Y-m-d H:i:s");
			$item->minutes = $this->system->total_minutes($item->start_datetime, $today);
			
		});
        
        //~ return $quizzes;
        return view('welcome', ['quizzes'=> $quizzes ]);
    }
    
    public function promote($person)
    {
		return redirect()->route('home');
	}
    
    public function about()
    {
		return view('about');
    }
    
    public function contact()
    {
		return view('contact');
    }
    
    public function blackops2($subject)
    {
		$subjects = array("english","mathematics","biology","government","economics","civiledu");
		$return = array();
		
		//~ foreach($subjects as $subject)
		//~ {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://questions.aloc.com.ng/api/v2/m?subject=".$subject,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					//~ "Authorization: Bearer ".config('paystack.secret_key'),
					"Cache-Control: no-cache",
					"Accept: application/json",
					"Content-Type: application/json",
					"AccessToken: ALOC-6c71ad42b9f65129630c",
				),

			));
			  
			$raw_response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			  
			if ($err) 
			{
				$return[] = $err;
			} 
			else 
			{
				$response = json_decode($raw_response, true); 
				
				if ($response['status'] != 200)
				{
					return $response; 
				}
				
				//~ return $response['data'];
				
				foreach($response['data'] as $raw_question)
				{
					$question = new Question;
					$question->question = $raw_question['question'];
					$question->options = json_encode($raw_question['option']);
					$question->subject = $response['subject'];
					$question->answer = $raw_question['answer'];
					$question->section = $raw_question['section'];
					$question->image = $raw_question['image'];
					$question->examtype = $raw_question['examtype'];
					$question->examyear = $raw_question['examyear'];
					$question->raw = json_encode($raw_question);
					$question->save();
					
				}
				
				$return[] = "Done";
			}
			
		//~ }
		
		return $return;
    }
    
    public function blackops()
    {
		$questions = Question::limit(100)->inRandomOrder()->get(); 
		$question_ids = array_column($questions->toArray(), 'id');
		return $question_ids;
	}
    
}
