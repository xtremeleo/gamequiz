@extends('layouts.app')
@section('page_title', 'Edit Details')
@section('content')
@include('user.components.overview',['view' => 'account'])
<div class="container">
	<div class="col-12 p-0 py-2 d-flex justify-content-between">
		<h3>Edit Profile</h3> 
	</div>
	 <div class="row">
		 <div class="col-md-6 col-lg-6 col-sm-12">
			<form method="post" action="{{route('account.action')}}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="action" value="save_details">
				
				<div class="form-group">
					<input type="hidden" id="image" name="image" value="{{old('image')}}"/>
					<label class="font-weight-bolder green" for="image_uploader">
						<img id="image_placeholder" src="{{ $user->avatar ?? asset('auth/img/placeholder.png')}}" width="150px" />
					</label>
					<input id="image_uploader" type="file" class="form-control d-none" onchange="getImage(event, 'image_placeholder', 'image')" />
				</div>
				
<!--
				<div class="form-group">
					<label for="avatar" class="control-label"><img src="{{$user->avatar}}" width="130px"/></label>
					<input type="file" id="avatar"  name="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*"  value="{{old('avatar')}}" />
				
					@error('avatar')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>
-->
				
				<div class="form-group">
					<label class="control-label">Name</label>
					<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" value="{{ $user->name ?? old('name') }}" required autocomplete="name" autofocus>
					@error('name')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>
				
				<div class="form-group">
					<label class="control-label">Mobile</label>
					<input id="mobile" type="tel" class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile" name="mobile" value="{{ $user->mobile ?? old('mobile') }}" required autocomplete="mobile" autofocus>
					@error('mobile')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>
				
				<div class="form-group btn-container">
					<button class="btn btn-primary btn-block text-sm">SAVE</button>
				</div>
				
			</form>
		</div>
	</div>
</div>

<script>
	function getImage(event, id, input) 
	{	
		var slice_size = 1000 * 1024;
		let n = event.target.name; // FileList object
		let f = event.target.files; // FileList object
		
		//console.log(f);
		if (id !== "")
		{
			document.getElementById(id).src = URL.createObjectURL(f[0]);
		}
		
		var reader = new FileReader();
		
		let start = 0;
		let next_slice = start + slice_size + 1;
		let blob = f[0].slice( start, next_slice );
		
		reader.onloadend = function (event) 
		{
			 if ( event.target.readyState !== FileReader.DONE ) 
			 {
					return;
			}
			//~ console.log(reader.result);
			document.getElementById(input).value = reader.result;
			
		}
		
		reader.readAsDataURL( blob );			
		
	}
	
	
</script>


  
@endsection
