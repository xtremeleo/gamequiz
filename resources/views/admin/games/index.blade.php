@extends('layouts.admin')
@section('page_title', $page->title )
@section('content')
@include('admin.components.overview',['view' => 'quiz'])

<div class="container">
	<div class="col-12 mt-3 mb-3">
		<a class="btn btn-sm wine-red-bg" href="{{route('admin.games.new')}}"><i class="bi bi-plus-circle-fill"></i> add new</a>
	</div>
	
	@if ($quizzes->count() > 0)
		<table class="table">
			<thead class="thead-light">
				<tr >
					<th class="" scope="col">#</th>
					<th class=" d-none d-sm-none d-md-table-cell" scope="col">Start on</th>
					<th class="d-none d-sm-none d-md-table-cell" scope="col">End on</th>
					<th class=" d-none d-sm-none d-md-table-cell" scope="col">Percent for allocation of prize</th>
					<th class="d-none d-sm-none d-md-table-cell" scope="col">Questions</th>
					<th class="d-none d-sm-none d-md-table-cell" scope="col">Prize</th>
					<th class="d-none d-sm-none d-md-table-cell" scope="col">Entries</th>
					<th class="d-none d-sm-none d-md-table-cell" scope="col">Created Date | Time</th>
					<th class="d-none d-sm-none d-md-table-cell" scope="col"></th>
				</tr>
			</thead>
			<tbody>
				@foreach($quizzes as $key => $quiz)
					<tr class="">
						<td class="">
							<strong>(#{{$key + $quizzes->firstItem()}}) {{$quiz->name}}</strong>
							<div class="col-12 p-0 d-md-none d-sm-block">
								<table class="table">
									<tr>
										<th>Start Date|Time</th>
										<td>{{$quiz->start_datetime ?? ""}}</td>
									</tr>
									<tr>
										<th>End Date|Time</th>
										<td>{{$quiz->end_datetime ?? ""}}</td>
									</tr>
									<tr>
										<th>Percent for allocation of prize</th>
										<td>{{$quiz->winning_percent ?? ""}}</td>
									</tr>
									<tr>
										<th>Questions</th>
										<td><a href="{{route('admin.games.questions', ['_id' => $quiz->id ])}}">{{ count($quiz->questions()) ?? "0"}}</a></td>
									</tr>
									<tr>
										<th>Prize</th>
										<td>₦{{number_format($quiz->prize) ?? "0"}}</td>
									</tr>
									<tr>
										<th>Entries</th>
										<td>{{$quiz->entries->count() ?? ""}}</td>
									</tr>
									<tr>
										<th>Created Date | Time</th>
										<td>{{$quiz->created_at->format('d FY h:i:s')}}</td>
									</tr>
									<tr>
										<td colspan="2">
											<a class="btn btn-danger" href="{{route('admin.games.edit',['_id' => $quiz->id ])}}">EDIT</a>
										</td>
									</tr>
								</table>
							</div>
						</td>
						<td class=" d-none d-sm-none d-md-table-cell">{{$quiz->start_datetime ?? ""}}</td>
						<td class=" d-none d-sm-none d-md-table-cell">{{$quiz->end_datetime ?? ""}}</td>
						<td class=" d-none d-sm-none d-md-table-cell">{{$quiz->winning_percent ?? ""}}</td>
						<td class=" d-none d-sm-none d-md-table-cell"><a href="{{route('admin.games.questions', ['_id' => $quiz->id ])}}">{{count($quiz->questions()) }}</a></td>
						<td class="d-none d-sm-none d-md-table-cell">₦{{number_format($quiz->prize) ?? "0"}}</td>
						<td class="d-none d-sm-none d-md-table-cell">{{$quiz->entries->count() ?? ""}}</td>
						<td class="d-none d-sm-none d-md-table-cell">{{$quiz->created_at->format('d FY h:i:s')}}</td>
						<td class="d-none d-sm-none d-md-table-cell">
							<a class="btn btn-danger" href="{{route('admin.games.edit',['_id' => $quiz->id ])}}">Edit</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		
		<div class="col-12">
			{{$quizzes->links()}}
		</div>
	@else
		<div class="col-12 mb-4">
			<p>You have not joined any quiz yet.</p>
		</div>
	@endif
						
</div>

@endsection
