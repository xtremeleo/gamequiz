@extends('layouts.app')
@section('page_title', 'Bank Accounts')
@section('content')
@include('user.components.overview',['view' => 'account'])
<div class="container">
	<div class="col-12 p-0 py-2 d-flex justify-content-between">
		<h3>Bank Account </h3> <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addBankModal"><strong>add new</strong></button>
	</div>
		@if ($accounts->count() > 0)
			<div class="col-sm-12">
				<table class="table">
					<thead class="thead-light">
						<tr >
							<th class="d-none d-sm-none d-md-table-cell" scope="col">#</th>
							<th class="d-none d-sm-none d-md-table-cell" scope="col">Bank</th>
							<th class="d-none d-sm-none d-md-table-cell" scope="col">Name</th>
							<th class="d-none d-sm-none d-md-table-cell" scope="col">Number</th>
							<th class="d-none d-sm-none d-md-table-cell" scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($accounts as $account)
							<tr class="">
								<td class=" d-none d-sm-none d-md-table-cell">{{$account->id}}</td>
								<td class="">
									{{$account->bank->name}}									
									<div class="d-sm-block d-md-none">
										{{$account->name}}<br/>
										{{$account->number}}
										
										<div class="col-12 p-0 m-0 d-flex justify-content-between align-items-center">
											<button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#withdrawBank{{$account->id}}Modal">
												<i class="bi bi-wallet2"></i> withdraw
											</button>
										</div>
									</div>
								</td>
								<td class=" d-none d-sm-none d-md-table-cell">
									{{$account->name}}
									<span class="d-block" style="font-size: 11px;">Added on the {{$account->created_at->format('jS F,Y')}}</span>
								</td>
								<td class=" d-none d-sm-none d-md-table-cell">{{$account->number}}</td>
								<td class="d-none d-sm-none d-md-table-cell">
									@if ($account->status == "PENDING")
										<strong class="btn btn-sm btn-secondary">PENDING APPROVAL</strong>
									@elseif ($account->status == "DECLINED")
										<strong class="btn btn-sm btn-danger">DECLINED</strong>
									@elseif ($account->status == "APPROVED")
										<button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#withdrawBank{{$account->id}}Modal">
											<i class="bi bi-wallet2"></i> withdraw
										</button>
									@endif
									
								</td>
							</tr>
							<!-- Modal -->
							<div class="modal fade" id="withdrawBank{{$account->id}}Modal" tabindex="-1" aria-labelledby="withdrawBank{{$account->id}}ModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header main-color-bg">
											<h5 class="modal-title" id="withdrawBank{{$account->id}}ModalLabel">Make Withdraw</h5>
							<!--
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							-->
										</div>
										<form method="post" action="{{route('account.action')}}"> 
											@csrf
											<input type="hidden" name="action" value="withdraw" required />
											<input type="hidden" name="bank_account" value="{{$account->id}}" required />
											
											<div class="modal-body">
												<div class="form-group mb-2">
													<p>
														You are about to withdraw your funds into 
														<br/>{{$account->bank->name}}<br/>{{$account->name}}<br/>{{$account->number}}
													</p>
												</div>
												<div class="form-group mb-2">
													<label for="amount">Amount</label>
													<input type="text" id="amount" name="withdraw_amount" class="form-control p-2" placeholder="How much do you wish to withdraw"  required />
												</div>
											</div>
											<div class="modal-footer main-color-bg d-flex justify-content-between">
												<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary">Send</button>
											</div>
										</form>
									</div>
								</div>
							</div>

						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="4"></td>
						</tr>
					</tfoot>
				</table>
			</div>
		@else
			<div class="col-sm-12 d-flex justify-content-center align-items-center" style="height: 50vh;">
				<div class="col-md-4 col-sm-10">
					<p>You have no bank account at the moment, would you like to <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addBankModal"><strong>add new</strong></button></p>
				</div>
			</div>
		@endif
	
</div>
      

<!-- Modal -->
<div class="modal fade" id="addBankModal" tabindex="-1" aria-labelledby="addBankModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header main-color-bg">
				<h5 class="modal-title" id="addBankModalLabel">Add Bank Account</h5>
<!--
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
-->
			</div>
			<form method="post" action="{{route('account.action')}}"> 
				@csrf
				<input type="hidden" name="action" value="add_bank" required />
				
				<div class="modal-body">
					<div class="form-group mb-2">
						<label for="banks">Bank Name</label>
						<select id="banks" name="bank" class="form-control p-2" required >
							<option value="">Select your bank</option>
							@php
							$banks = getBanks();
							@endphp
							@foreach( $banks as $bank)
								<option value="{{$bank->id}}">{{$bank->name}}</option>
							@endforeach
						</select>
					</div>
<!--
					<div class="form-group mb-2">
						<label for="acct_name">Account Name</label>
						<input type="text" id="acct_name" name="acct_name" class="form-control p-2" placeholder="Type in the account name"  required />
					</div>
-->
					
					<div class="form-group mb-2">
						<label for="acct_number">Account Number</label>
						<input type="text" id="acct_number" name="acct_number" class="form-control p-2" placeholder="Type in the account number"  required />
					</div>
				</div>
				<div class="modal-footer main-color-bg d-flex justify-content-between">
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>

  
@endsection
