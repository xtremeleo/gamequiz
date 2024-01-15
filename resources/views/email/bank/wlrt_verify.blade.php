<div style="background-color:#FFFFFF;">
	<center><img src="{{url('assets/img/brand/logo.png') }}" width="100px"/></center>
	<center><h2>Hi {{$user->name}}!</h2></center>
	<center><p>There is a request to withdraw the sum of ₦{{number_format($wlrt->amount)}} from your account on {{ config('app.name', 'Laravel') }} to:.</p></center>
	<center><strong>{{$wlrt->account->bank->name}} / {{$wlrt->account->name}} / {{$wlrt->account->number}}</strong></center>
	<center><p>Please <a href="{{route('verify.withdraw',['user_id' => $user->id, 'wlrt_id' => $wlrt->id, 'code' => $verificationLink, 'res' => 'a' ])}}"><u>click here</u></a> to approve this action.</p></center>
	<center><p>Or you can decline by <a style="color: red;" href="{{route('verify.withdraw',['user_id' => $user->id, 'wlrt_id' => $wlrt->id, 'code' => $verificationLink, 'res' => 'd' ])}}">clicking here</a>.</p></center>
	<br/>
	<center>Thank you</center>
</div>
