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
		<h4 class="text-center">Test Quiz<br/><small>Questions</small></h4>
		<form id="{{$test_id}}" method="post" action="{{route('test.action')}}">
			@csrf
			<div class="game-for">
				
				@for($i = 0; $i < count($questions); $i++)
					
					<div id="q{{$i}}" @if($i > 0) style="display:none;" @endif  >
						<div class="form-group">
							<label class="control-label">
								{!!$questions[$i]['question']!!}
							</label>
							
							<div class="mt-3">
								<strong>Answers:</strong>
								@foreach($questions[$i]['options'] as $key => $value)
									<div class="form-check">
										<label class="form-check-label p-1" for="answer_questions_{{$key}}">
											<input class="form-check-input" type="radio" name="answers[{{$key}}]" id="answer_questions_{{$key}}" value="{{$key}}" >
											{{$value}}
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
								<button class="btn green-bg" type="button" name=""  onclick="game_check('{{$test_id}}')" >Submit</button>
							@endif
						</div>
					</div>
					
				@endfor
			
				
				<div class="col-12 p-0 mt-2">
					<div class="utility">
						<p class="semibold-text mb-2">
							<a href="{{route('register')}}">Signup</a>
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
