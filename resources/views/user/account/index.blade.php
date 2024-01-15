@extends('layouts.app')
@section('page_title', 'Account')
@section('content')
@include('user.components.overview',['view' => 'account'])
<div class="container">
	<div class="col-12 p-0 py-2 d-flex justify-content-between">
		<h3>Profile</h3> <a href="{{route('account.details.edit')}}" class="btn btn-link"><strong>edit</strong></a>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-12">
			<img src="{{$user->avatar}}" width="100px"/>
		</div>
		<div class="col-md-9 col-sm-12">
			<table class="table">
				<tr>
					<th>Name</th>
					<td>{{$user->name}}</td>
				</tr>
				<tr>
					<th>Mobile</th>
					<td>{{$user->mobile}}</td>
				</tr>
				<tr>
					<th>Email</th>
					<td>{{$user->email}}</td>
				</tr>
			</table>
		</div>
	</div>
	
	<div class="col-12 p-0 py-2 d-flex justify-content-between">
		<h3>Activities</h3> <a href="{{route('account.activities')}}" class="btn btn-link"><strong>all</strong></a>
	</div>
	<div class="row">
		<table class="table">
			<colgroup>
				<col width="20%" />
				<col width="80%" />
			</colgroup>
			<thead>
				<tr>
					<th>Date | Time</th>
					<th>Activity</th>
				</tr>
			</thead>
			<tbody>
				@foreach($activities as $activity)
					<tr>
						<td>{{$activity->created_at}}</td>
						<td>{{$activity->message}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

</div>
      
  
@endsection
