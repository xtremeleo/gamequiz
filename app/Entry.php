<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
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
    
    public function quiz()
    {
		return $this->belongsTo('App\Quiz');
	}
    
    public function user()
    {
		return $this->belongsTo('App\User');
	}
	
}
