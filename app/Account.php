<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    public function bank()
    {
		return $this->belongsTo('App\Bank');
	}
}
