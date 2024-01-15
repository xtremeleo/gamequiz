<div>
	<center><img src="{{url('assets/img/brand/logo.png') }}" width="100px"/></center>
	<center><h2>Hi {{$user->name}}!</h2></center>
	<center><p>Thank you for registering with {{ config('app.name', 'Laravel') }}.</p></center>
	<center><p>Please <a href="{{url('verify/'.$user->id.'/'.$verificationLink)}}"><u>click here</u></a> to verify you email.</p></center>
	<br/>
	<center>Thank you</center>
</div>
