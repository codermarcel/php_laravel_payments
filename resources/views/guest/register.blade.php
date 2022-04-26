@extends('guest.base')

@section('content')

			<div class=" card-box">
				<div class="panel-heading">
					<h3 class="text-center"> Sign Up to <strong class="text-custom">@lang('global.appname')</strong> </h3>
				</div>

				<div class="panel-body">
					<form class="form-horizontal m-t-20" action="{{ route('guest.register') }}" method="post">
					
						{{ csrf_field() }}
						
						@if ($errors->any())
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
									×
								</button>
								{{ $errors->first() }}
							</div>
						@endif

						<div class="form-group ">
							<div class="col-xs-12">
								<input class="form-control" value="{{ old('email') }}" name="email" type="email" required="" placeholder="@lang('global.email')">
							</div>
						</div>

						<div class="form-group ">
							<div class="col-xs-12">
								<input class="form-control" value="{{ old('username') }}" name="username" type="text" required="" placeholder="@lang('global.username')">
							</div>
						</div>

						<div class="form-group">
							<div class="col-xs-12">
								<input class="form-control" name="password" type="password" required="" placeholder="@lang('global.password')">
							</div>
						</div>

						<div class="form-group">
							<div class="col-xs-12">
								<div class="checkbox checkbox-primary">
									<input id="checkbox-signup" type="checkbox" checked>
									<label name="agree" for="checkbox-signup">I accept <a href="#">Terms and Conditions</a></label>
								</div>
							</div>
						</div>

						<div class="form-group text-center m-t-40">
							<div class="col-xs-12">
								<button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">
									Register
								</button>
							</div>
						</div>

					</form>

				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 text-center">
					<p>
						Already have account?<a href="{{ route('guest.login') }}" class="text-primary m-l-5"><b>Sign In</b></a>
					</p>
				</div>
			</div>

@endsection



			