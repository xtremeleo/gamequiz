<?php

include_once('admin/loader.php');

function getLongId( int $id)
{
	return $id * 9000;
}

function walletBalance()
{
	$user = Auth::user();
	$query = array(
						'user_id' => $user->id,
						'status' => "APPROVED",
					);
	$transactions = \App\Transaction::where($query)->get();
	
	return number_format($transactions->sum('amount'));
}

function getBanks()
{
	$banks = \App\Bank::all();
	
	return $banks;
}

function get_time_options()
{ 
	$start=new DateTime( date( DATE_ATOM, strtotime('8am') ) );
	$end=new DateTime( date( DATE_ATOM, strtotime('6pm') ) );
	$interval=new DateInterval('PT30M');

	/* ensure the initial time is part of the output */
	$start->sub( $interval );
	$slots=array();
	
	
	while( $start->add( $interval ) <= $end ) $slots[] = $start->format('h:ia');
	//~ printf('<select name="times"><option>%s</select>', implode( '<option>', $slots ) )
	return $slots;
}
