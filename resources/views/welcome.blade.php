@extends('layouts.front')
@section('page_title', 'Welcome')
@section('page_description', 'NerdQuiz is an online quiz platform that rewards its winners financially for being smart and intelligent.')
@section('content')
		<section class="main-color-bg welcome-banner">
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 d-flex flex-column justify-content-center align-items-center message">
				<h2>Are you smart enough?</h2>
				<a class="btn btn-success" href="{{ route('test.quiz') }}">Test your might!</a>
			</div>
<!--
			<div class="cover"><img src="{{asset('assets/img/theme/bg.png') }}" /></div>
-->
		</section>
		<section id="upcoming_quizzes" class="container mt-2 p-0">
			<div class="col-12 my-4">
				<h2 class="">Upcoming Quizzes</h2>
				<p style="font-size: 16px;">All quizzes, comprises of questions from the following subjects: English, Mathematics, Biology, Government, Economics, Civil Education.</p>
			</div>
			
			<div class="col-xl-10 col-lg-9 col-md-9 col-sm-12 p-0 quizzes">
				@foreach($quizzes as $quiz)
					<div class="col-12 quiz py-1" style="border-bottom: 2px solid #ddd;">
						<div class="col-12 p-0 mb-1">
							<div class="row p-0">
								<div class="col-9"><h5 class="title"><span class="warm-red">#{{$quiz->id}}</span> starts at {{$quiz->start('h:ia, jS M Y')}} ends at {{$quiz->end('h:ia, jS M Y')}} | CASH PRIZE <span class="warm-red">₦{{number_format($quiz->prize)}}</span></h5></div>
								<div class="col-3">
									@if($quiz->minutes > 61)
										<a href="{{route('join',['id' =>$quiz->id])}}" class="join btn green-bg">Click to Join</a>
									@else
										<a href="{{route('join.closed',['id' =>$quiz->id])}}" class="join btn wine-red-bg">Closed</a>
										<p class="wine-red">Quiz starts in {{$quiz->minutes}} minutes</p>
									@endif
								</div>
							</div>
						</div>
						
						<div class="col-12 entries" style="height: 50px;">
							@foreach( $quiz->entries as $entry)
								<div style="width: 35px; height: 35px; float: left; margin-right: 2px;" title="{{$entry->user->name}}">
									<img src="{{$entry->user->avatar}}" width="100%" />
								</div>
							@endforeach
<!--
							@if ($quiz->entries->count() > 0)
								<strong>Entries:</strong> {{$quiz->entries->count() }} / {{$quiz->entry_nos}}
							@else
								No entry yet
							@endif
-->
						</div>

					</div>
				@endforeach
			</div>
		</section>
		
@endsection

