

<div class="main-color-2-bg">
	<div class="container">	
		<div class="row pt-2">
			<div class="col-lg-4 col-md-4 col-sm-12  {{ ($view == 'users' ? '' : '  d-none d-sm-none d-md-block') }}">
				<p class="black"><i class="bi bi-people-fill"></i> Users</p>
				<h3 class="black pb-2">{{get_users_count()}}</h3>
				
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12 {{ ($view == 'quiz' ? '' : '  d-none d-sm-none d-md-block') }}" style="border-right: 1px solid; border-left: 1px solid;">
				<p class="black"><i class="bi bi-controller"></i> Quizzes</p>
				
				<div class="row p-0">
					<div class="col d-flex justify-content-start align-items-center">
						
						<h3 class="black p-0">{{Auth::user()->entries->count()}} <small>PLAYED</small></h3>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12{{ ($view == 'account' ? 'text-start' : '  text-start d-none d-sm-none d-md-block') }}">
				<p class="black"><i class="bi bi-person-fill"></i> Account</p>
				<h3 class="black">{{Auth::user()->name}}</h3>
			</div>
			
		</div>
	</div>
</div>
<div class="main-color-bg mb-3" style="box-shadow: 0px 29px 147.5px 102.5px rgba(0, 0, 0, 0.05), 0px 29px 95px 0px rgba(0, 0, 0, 0.16);">
	<div class="container">
		<div class="row p-0">
			<div class="col-lg-4 col-md-4 col-sm-12 {{ ($view == 'users' ? '' : ' d-none d-sm-none d-md-block') }}">
				<div class="row p-0 ">
					<ul class="nav justify-content-between">
						<li class="nav-item">
							<a class="nav-link black" href="{{route('admin.users')}}"><i class="bi bi-people-fill"></i><span class="d-inline d-md-none d-lg-inline"> Users</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link black" href="{{route('wallet')}}"><i class="bi bi-list-ol"></i><span class="d-inline d-md-none d-lg-inline"> Transactions</span></a>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12  {{ ($view == 'quiz' ? '' : ' d-none d-sm-none d-md-block') }}">
				<div class="row p-0 ">
					<ul class="nav justify-content-between">
					 <li class="nav-item">
						<a class="nav-link black" href="{{route('admin.games')}}"><i class="bi bi-hourglass-top"></i><span class="d-inline d-md-none d-lg-inline"> Quizzes</span></a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link black" href="{{route('admin.games.questions')}}"><i class="bi bi-hourglass-bottom"></i><span class="d-inline d-md-none d-lg-inline"> Questions</span></a>
					  </li>
					</ul>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12 {{ ($view == 'account' ? '' : ' d-none d-sm-none d-md-block') }}">
				<div class="row p-0 ">
					<ul class="nav justify-content-between">
					  <li class="nav-item">
						<a class="nav-link black" href="{{route('account')}}"><i class="bi bi-person-circle"></i><span class="d-inline d-md-none d-lg-inline"> Profile</span></a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link black" href="{{route('account.bank')}}"><i class="bi bi-shield-shaded"></i><span class="d-inline d-md-none d-lg-inline"> Security</span></a>
					  </li>
					</ul>
				</div>
			</div>
			
		</div>
	
	</div>
</div>
