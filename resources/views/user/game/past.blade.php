@extends('layouts.app')
@section('page_title', 'Past Quizzes')
@section('content')
@include('user.components.overview',['view' => 'quiz'])

<div class="container">
	<div class="col-12 mt-3">
		<h3>Past Quizzes</h3>
	</div>
	<table class="table">
		<thead class="thead-light">
			<tr >
				<th class="" scope="col">Quiz</th>
				<th class=" d-none d-sm-none d-md-table-cell" scope="col">Entry Fee</th>
				<th class=" d-none d-sm-none d-md-table-cell" scope="col">Starts</th>
				<th class=" d-none d-sm-none d-md-table-cell" scope="col">Ends</th>
				<th class="d-none d-sm-none d-md-table-cell" scope="col">Prize</th>
				<th class="d-none d-sm-none d-md-table-cell" scope="col">Position (Score)</th>
			</tr>
		</thead>
		<tbody>
			@foreach($quizzes as $quiz)
				<tr class="">
					<td class="">
						<strong>#{{$quiz->id}}</strong>
						<div class="col-12 p-0 d-md-none d-sm-block">
							<table class="table">
								<tr>
									<th>Prize</th>
									<td>₦{{number_format($quiz->prize)}} <i>(entry fee ₦{{number_format($quiz->entry_fee)}})</i></td>
								</tr>
								<tr>
									<th>Start</th>
									<td>{{$quiz->start('jS M Y, h:ia')}}</td>
								</tr>
								<tr>
									<th>End</th>
									<td>{{$quiz->end('jS M Y, h:ia')}}</td>
								</tr>
								<tr>
									<th>Position (Score)</th>
									<td>
										{{$quiz->position}} ({{$quiz->score}})
									</td>
								</tr>
							</table>
						</div>
					</td>
					<td class=" d-none d-sm-none d-md-table-cell">₦{{number_format($quiz->entry_fee)}}</td>
					<td class=" d-none d-sm-none d-md-table-cell">{{$quiz->start('jS M Y, h:ia')}}</td>
					<td class=" d-none d-sm-none d-md-table-cell">{{$quiz->end('jS M Y, h:ia')}}</td>
					<td class="d-none d-sm-none d-md-table-cell">₦{{number_format($quiz->prize)}}</td>
					<td class="d-none d-sm-none d-md-table-cell">{{$quiz->position}} ({{$quiz->score}})</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6">{{ $quizzes->links() }}</td>
			</tr>
		</tfoot>
	</table>
					
</div>

@endsection
