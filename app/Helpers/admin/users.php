<?php

use App\User;

function get_users_count()
{
	$users = User::where("type","User")->get();
	
	return $users->count();
}

