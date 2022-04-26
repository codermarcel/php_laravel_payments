@extends('guest.base')

@section('content')

        	<div class=" card-box">
				<div class="panel-heading">
					<h3 class="text-center"> Reset Password </h3>
				</div>

				<div class="panel-body">
					<form method="post" action="{{ route('guest.recover') }}" role="form" class="text-center">
					
						{{ csrf_field() }}
						
						<div class="alert alert-info alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
								×
							</button>
							Enter your <b>Email</b> and instructions will be sent to you!
						</div>
						
						<div class="form-group m-b-0">
							<div class="input-group">
								<input name="email" type="email" class="form-control" placeholder="@lang('global.email')" required="">
								<span class="input-group-btn">
									<button type="submit" class="btn btn-pink w-sm waves-effect waves-light">
										Reset
									</button> 
								</span>
							</div>
						</div>

					</form>
				</div>
			</div>
			
			<div class="row">
            	<div class="col-sm-12 text-center">
					<p>Are you looking for the login page?<a href="{{ route('guest.login') }}" class="text-primary m-l-5"><b>Click here</b></a></p>
                </div>
            </div>

@endsection
