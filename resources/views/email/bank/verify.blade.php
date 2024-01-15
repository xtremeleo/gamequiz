<div style="background-color:#FFFFFF;">
	<center><img src="{{url('assets/img/brand/logo.png') }}" width="100px"/></center>
	<center><h2>Hi {{$user->name}}!</h2></center>
	<center><p>There is a request to add this bank details to your account on {{ config('app.name', 'Laravel') }}.</p></center>
	<center><strong>{{$account->bank->name}} / {{$account->name}} / {{$account->number}}</strong></center>
	<center><p>Please <a href="{{route('verify.bank',['id' => $user->id, 'account' => $account->id, 'code' => $verificationLink, 'res' => 'a' ])}}"><u>click here</u></a> to verify this action.</p></center>
	<center><p>Or you can reject and delete by <a style="color: red;" href="{{route('verify.bank',['id' => $user->id, 'account' => $account->id, 'code' => $verificationLink, 'res' => 'd' ])}}">clicking here</a>.</p></center>
	<br/>
	<center>Thank you</center>
</div>
