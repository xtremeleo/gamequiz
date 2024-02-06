@extends('layouts.admin')
@section('page_title', $page->title )
@section('content')
@include('admin.components.overview',['view' => 'users'])

<div class="container">
	@if ($users->count() > 0)
		<table class="table">
			<thead class="thead-light">
				<tr >
					<th class="" scope="col">User</th>
					<th class=" d-none d-sm-none d-md-table-cell" scope="col">Mobile</th>
					<th class=" d-none d-sm-none d-md-table-cell" scope="col">Email</th>
					<th class="d-none d-sm-none d-md-table-cell" scope="col">Wallet</th>
					<th class="d-none d-sm-none d-md-table-cell" scope="col">Game</th>
					<th class="d-none d-sm-none d-md-table-cell" scope="col"></th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $key => $user)
					<tr class="">
						<td class="">
							<strong>(#{{$key + $users->firstItem()}}) {{$user->name}}</strong>
							<div class="col-12 p-0 d-md-none d-sm-block">
								<table class="table">
									<tr>
										<th>Mobile</th>
										<td>{{$user->mobile ?? ""}}</td>
									</tr>
									<tr>
										<th>Email</th>
										<td>{{$user->email ?? ""}}</td>
									</tr>
									<tr>
										<th>Wallet</th>
										<td>₦{{number_format($user->prize) ?? "0"}}</td>
									</tr>
									<tr>
										<th>Game</th>
										<td>0 (<span class="green">0</span> | <span class="red">0</span>)</td>
									</tr>
									<tr>
										<td colspan="2">
											<a class="btn btn-danger" href="#">Deactivate</a>
										</td>
									</tr>
								</table>
							</div>
						</td>
						<td class=" d-none d-sm-none d-md-table-cell">{{$user->mobile ?? ""}}</td>
						<td class=" d-none d-sm-none d-md-table-cell">{{$user->email ?? ""}}</td>
						<td class="d-none d-sm-none d-md-table-cell">₦{{number_format($user->prize) ?? "0"}}</td>
						<td class="d-none d-sm-none d-md-table-cell">0 (<span class="green">0</span> | <span class="red">0</span>)</td>
						<td class="d-none d-sm-none d-md-table-cell">
							<a class="btn btn-danger" href="#">Deactivate</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@else
		<div class="col-12 mb-4">
			<p>You have not joined any quiz yet.</p>
		</div>
	@endif
						
</div>

@endsection
