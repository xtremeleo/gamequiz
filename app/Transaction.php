<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    
    public function trans_date($format)
    {
		$trans_date = date_create($this->trans_date);
		
		return $trans_date->format($format);
	}
	
	public function user()
	{
		return $this->belongsTo("App\User");
	}

}
