@extends('layouts.app')
@section('page_title', 'Account')
@section('content')
@include('user.components.overview',['view' => 'account'])
<div class="container">
	<div class="col-12 p-0 py-2 d-flex justify-content-between">
		<h3>Activities</h3>
	</div>
	<div class="col-12">
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
	<div class="col-12">
		{{$activities->links()}}
	</div>
</div>
      
  
@endsection
