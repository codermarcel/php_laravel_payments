@extends('guest.base')

@section('content')

        	<div class=" card-box">
            <div class="panel-heading"> 
                <h3 class="text-center"> Sign In to <strong class="text-custom">@lang('global.appname')</strong> </h3>
            </div>


            <div class="panel-body">
            <form class="form-horizontal m-t-20" action="{{ route('guest.login') }}" method="post">
			
				{{ csrf_field() }}
				
				@if (isset($errors) && $errors->any())
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
							×
						</button>
						{{ $errors->first() }}
					</div>
				@endif
				
				@if (Session::has('success'))
					<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
							×
						</button>
						{{ Session::get('success') }}
					</div>
				@endif
                
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" value="{{ old('email') }}" name="email" type="email" required="" placeholder="@lang('global.email')">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" name="password" type="password" required="" placeholder="@lang('global.password')">
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                            <input name="remember" id="checkbox-signup" type="checkbox" value="true">
                            <label for="checkbox-signup" >
                                Remember me
                            </label>
                        </div>
                        
                    </div>
                </div>
                
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                    </div>
                </div>

                <div class="form-group m-t-30 m-b-0">
                    <div class="col-sm-12">
                        <a href="{{ route('guest.recover') }}" class="text-dark"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                    </div>
                </div>
            </form> 
            
            </div>   
            </div>                              
            <div class="row">
            	<div class="col-sm-12 text-center">
					<p>Don't have an account? <a href="{{ route('guest.register') }}" class="text-primary m-l-5"><b>Sign Up</b></a></p>
                </div>
            </div>

@endsection
