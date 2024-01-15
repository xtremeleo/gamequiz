@extends('layouts.app')
@section('page_title', 'Wallet')
@section('content')
@include('user.components.overview',['view' => 'wallet'])

	<div class="container">
	<div class="col-12">
		<h3>Wallet</h3>
	</div>
	
	<table class="table">
		<thead class="thead-light">
			<tr >
				<th class=" d-none d-sm-none d-md-table-cell" scope="col">#</th>
				<th class="" scope="col">Amount</th>
				<th class=" d-none d-sm-none d-md-table-cell" scope="col">Purpose</th>
				<th class=" d-none d-sm-none d-md-table-cell" scope="col">Method</th>
				<th class="" scope="col">Memo</th>
				<th class="" scope="col">Date</th>
			</tr>
		</thead>
		<tbody>
			@foreach($transactions as $transaction)
				<tr class="">
					<td class=" d-none d-sm-none d-md-table-cell">{{$transaction->id}}</td>
					<td class="{{$transaction->type}}">₦{{number_format($transaction->amount)}} </td>
					<td class=" d-none d-sm-none d-md-table-cell">{{$transaction->type}}</td>
					<td class=" d-none d-sm-none d-md-table-cell">{{$transaction->method}}</td>
					<td class="">{{$transaction->description}}</td>
					<td class="">{{$transaction->trans_date('jS F,Y')}}</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6">{{ $transactions->links() }}</td>
			</tr>
		</tfoot>
	</table>
					
</div>


      
  
@endsection
