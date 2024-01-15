@extends('layouts.game')
@section('page_title', 'Quizzes for today')
@section('content')
<section class="game-content">
	<div class="logo">
<!--
		<h1>Welcome</h1>
-->
		<img src="{{asset('assets/img/brand/logo.png')}}" width="200px">
	</div>
	<div class="board">
		<h4 class="text-center">Game #{{$quiz->id}} <br/><small>Questions</small></h4>
		<form id="q{{$quiz->id}}" method="post" action="{{route('game.submit',['id' => $quiz->id])}}">
			@csrf
			<div class="game-for">
				
				@for ($i = 0; $i < $questions->count(); $i++)
					@php
						$next = next($questions);
						$options = json_decode($questions[$i]->options, true);
					@endphp
					<div id="q{{$i}}" @if($i > 0)style="display:none;" @endif  >
						<div class="form-group">
							<label class="control-label">
								<span class="wine-red">{{$questions[$i]->section}}</span><br/>
								{!!$questions[$i]->question!!}
							</label>
							
							<div class="mt-3">
								<strong>Answers:</strong>
								@foreach($options as $key => $value)
									<div class="form-check">
										<label class="form-check-label p-1" for="answer_{{$questions[$i]->id}}_{{$key}}">
											<input class="form-check-input" type="radio" name="answers[{{$questions[$i]->id}}]" id="answer_{{$questions[$i]->id}}_{{$key}}" value="{{$key}}" >
											({{$key}}) {{$value}}
										</label>
									</div>
								@endforeach
							</div>
						</div>
						<div class="col-12 mt-4 p-0 d-flex justify-content-between">
							@if ($i > 0)
								<a class="btn wine-red-bg" onclick="display_question('q{{$i - 1}}', 'q{{$i}}')"><< PREV</a>
							@endif
							
							@if ($i < $questions->count() - 1)
								<a class="btn green-bg" onclick="display_question('q{{$i + 1}}', 'q{{$i}}')" >NEXT >></a>
							@else
								<button class="btn green-bg" type="button" name=""  onclick="game_check('q{{$quiz->id}}')" >Submit</button>
							@endif
						</div>
					</div>
					
				@endfor
			
				
				<div class="col-12 p-0 mt-2">
					<div class="utility">
						<p class="semibold-text mb-2">
							<a href="{{route('dashboard')}}">Dashboard</a>
						</p>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>

   
                
    
@endsection
@push('scripts')
	<script>
		function game_check(fid)
		{
			let text;
			if (confirm("Are you sure you want to submit your answer?") == true) {
			  
			 var f = document.getElementById(fid).submit();
			  
			}
			else {
			 
			}
		}
		
		function display_question(show, hide)
		{
			var s = document.getElementById(show).style.display = "block";
			var h = document.getElementById(hide).style.display = "none";
		}
	</script>
@endpush
