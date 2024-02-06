@extends('layouts.admin')
@section('page_title', $page->title )
@section('content')
@include('admin.components.overview',['view' => 'quiz'])

<div class="container">
	<div class="col-md-4 col-sm-12 mb-3">
		<h3>{{$page->title}}</h3>
	</div>
	
	<div class="col-md-4 col-sm-12">
		<form class="form" method="post" action="{{route('admin.games.action')}}">
			@csrf
			<input type="hidden" name="action" value="{{$page->action}}" required />
			<input type="hidden" name="_id" value="{{$_id}}" required />
			
			@foreach($fields as $field)
			<div class="form-group">
				<label class="form-label" for="{{$field->name}}">{{$field->display_name}}</label>
				@if($field->type == "text")
					<input type="text" class="form-control p-2" name="{{$field->name}}" value="{{ $field->value ?? old($field->name)}}" {{$field->required}} />
				@elseif($field->type == "date")
					<input type="date" class="form-control p-2" name="{{$field->name}}" value="{{ $field->value ?? old($field->name)}}" {{$field->required}} />
				@elseif($field->type == "number")
					<input type="number" class="form-control p-2" name="{{$field->name}}" value="{{ $field->value ?? old($field->name)}}" {{$field->required}} />
				@elseif($field->type == "textarea")
					<textarea class="form-control p-2 rows="10" name="{{$field->name}}" {{$field->required}} />{{ $field->value ?? old($field->name)}}</textarea>
				@elseif($field->type == "select")
					<select class="form-control p-2" id="{{$field->name}}" name="{{$field->name}}" {{$field->required}} >
						<option value="">Select</option>
						@foreach($field->options as $option)
							<option value="{{$option}}">{{$option}}</option>
						@endforeach
					</select>
				@endif
			</div>
			@endforeach
			
			<button type="submit" class="btn btn-success" >Save</button>
		</form>
	</div>
</div>

@endsection
