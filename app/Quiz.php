<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    //
    public function start($format)
    {
		$date = date_create($this->start_datetime);
		return $date->format($format);
	}
	
    public function end($format)
    {
		$date = date_create($this->end_datetime);
		return $date->format($format);
	}
	
    public function entries()
    {
		return $this->hasMany('App\Entry');
	}
	
    public function startGame()
    {
		$now = date_create();
		$start_date = date_create($this->start_datetime);
		$end_date = date_create($this->end_datetime);
		$diff_time = date_diff($now, $start_date);
		
		if ($start_date->format("d-m-Y") == $now->format("d-m-Y") )
		{
			$start_date_year = $start_date->format("Y"); 
			$start_date_mon = $start_date->format("n");
			$start_date_day = $start_date->format("j");
			$start_date_hour = $start_date->format("H");
			$start_date_min = $start_date->format("i");
			$start_date_sec = $start_date->format("s");
			
			$start_time = mktime($start_date_hour,$start_date_min,$start_date_sec, $start_date_mon, $start_date_day, $start_date_year); 
			
			$end_date_year = $end_date->format("Y"); 
			$end_date_mon = $end_date->format("n");
			$end_date_day = $end_date->format("j");
			$end_date_hour = $end_date->format("H");
			$end_date_min = $end_date->format("i");
			$end_date_sec = $end_date->format("s");
			
			$end_time = mktime($end_date_hour,$end_date_min,$end_date_sec, $end_date_mon, $end_date_day, $end_date_year); 
			
			if(time() > $start_time && time() < $end_time)
			{
				return true;
			}
			
		}
		
		return false;
	}
	
	public function startGameTitle()
	{
		if ($this->startGame())
		{
			return "START QUIZ";
		}
		else
		{
			return "NOT YET";
		}
		
	}
	
	public function questions()
	{
		$questions = $this->questions;
		return json_decode($questions, true);
		
	}

}

