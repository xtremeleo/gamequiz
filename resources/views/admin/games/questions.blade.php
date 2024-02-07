@extends('layouts.admin')
@section('page_title', $page->title )
@section('content')
@include('admin.components.overview',['view' => 'quiz'])

<div class="container">
	<div class="col-md-4 col-sm-12 mb-3">
		<h3>{{$page->title}}</h3>
	</div>
	
	<div class="col-12">
		
		<form class="form" method="post" action="{{route('admin.games.action')}}">
			@csrf
			<input type="hidden" name="action" value="{{$page->action}}" required />
			<input type="hidden" name="_id" value="{{$_id}}" required />
			
			<div id="items" >
<!--
					<button type="button" class="btn warn-blue-bg" onclick="remove_this_item(this)" ><i class="bi bi-trash"></i> Remove Item</button>
					
-->
				@foreach($fields as $key => $field)
				<div class="mt-2 item">
					<div class="col-12 bluish-grey-bg p-2 ">
						<div class="form-group">
							<label class="form-label ql" for="{{$key}}"> Question #{{$key + 1}}</label>
							<input type="text" class="form-control" name="data[{{$key}}][question]" value="{{$field->question ?? '' }}" required />
							<div class="row p-1">
								@foreach($field->options as $option_key => $value)
									<div class="col-md-3 col-sm-12">
										<label class="form-label" for="{{$key}}"> Option {{$option_key}}:</label>
										<input type="text" class="form-control" name="data[{{$key}}][options][{{$option_key}}]" value="{{$value ?? '' }}" required />
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				@endforeach
			
			</div>
			<div class="col-12 mt-2">
				<button type="submit" class="btn btn-success" >Save</button>
				<button type="button" class="btn warn-blue-bg" onclick="add_item()" ><i class="bi bi-plug-lg"></i> Add New Item</button>
			</div>
		</form>
		
		
		
		
		
		
	</div>
</div>

@endsection

@push('scripts')      
<script>
	function add_item()
	{
		var items = document.getElementById('items');
		var original = document.getElementsByClassName('item');
		var clone = original[0].cloneNode(true);
		
		var rmovbtn =  document.createElement('button');
		rmovbtn.setAttribute("class", "btn warn-blue-bg");
		rmovbtn.setAttribute("type", "button");
		rmovbtn.setAttribute("onclick", "remove_this_item(this)");
		rmovbtn.innerHTML = "<i class='bi bi-trash'></i> Remove Item";
		clone.appendChild(rmovbtn);
		
		var newClone =  document.createElement('div');
		newClone.setAttribute("class", "mt-2 item");
		
		cloneContent = clone.innerHTML;
		var newNum = original.length + 1;
		cloneNewContent = cloneContent.replaceAll("data[0]", "data["+ newNum +"]");
		newClone.innerHTML = cloneNewContent;
		items.appendChild(newClone);
		renumber_question_label();
		
	}
	
	function remove_this_item(e)
	{
		 e.parentElement.remove();
		 renumber_question_label();
	}
	
	function renumber_question_label()
	{
		var qls = document.getElementsByClassName('ql');
		
		for (let i = 0; i < qls.length; i++)
		{
			var n = i+1;
			qls[i].innerHTML = "Question #"+ n;
		}
		
	}
	
</script>
@endpush
