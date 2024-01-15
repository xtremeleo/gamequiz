<?php

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
