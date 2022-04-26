@extends('user.base')

@section('top')

<link href="{{ asset('assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/select2/select2.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />

<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/core.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/components.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/pages.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />

<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

<script src="{{ asset('assets/js/modernizr.min.js') }}"></script>


@endsection

@section('content')
					
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

						@if ($errors->any())
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
                        
                        <div class="row">

							<div class="col-lg-6">
								<div class="card-box">
									<h4 class="m-t-0 header-title"><b>Edit User</b></h4>
									<p class="text-muted font-13 m-b-30">
	                                    Change user details here
	                                </p>
									
									{!! Form::open(array('method' => 'PATCH', 'route' => array('admin.users.update', $user->id))) !!}
   
										{{ csrf_field() }}
									
										<div class="form-group">
											<label for="userName">User Name</label>
											<input type="text" value="{{ $user->username }}" name="username" parsley-trigger="change" required placeholder="Enter user name" class="form-control" id="username">
										</div>
										
										<div class="form-group">
											<label for="emailAddress">Email address</label>
											<input type="email" value="{{ $user->email }}" name="email" parsley-trigger="change" required placeholder="Enter email" class="form-control" id="emailAddress">
										</div>
										
										<div class="form-group">
											<label for="pass1">New Password</label>
											<input name="password" type="password" placeholder="New Password" class="form-control">
										</div>	
										
										<div class="form-group">
											<label for="pass1">Confirm Password </label>
											<input name="password_confirmation" type="password" placeholder="New Password" class="form-control">
										</div>
										
										<label for="pass1">User Roles</label>
										<select name="roles[]" class="select2 select2-multiple" multiple data-placeholder="Choose ...">
										
											@foreach ($user_roles as $key => $role)
												<option SELECTED value="{{ $role->id }}">{{ $role->type()->getDisplayName() }}</option>
											@endforeach	
											
											@foreach ($all_roles as $key => $role)
												@if ( ! isset($user_roles[$key]))
													<option value="{{ $role->id }}">{{ $role->type()->getDisplayName() }}</option>
												@endif
											@endforeach
											
										</select>

										</br>
										</br>


										<div class="form-group text-right m-b-0">
											<button type="submit" name="action" value="update" class="btn btn-purple waves-effect waves-light">Update User</button>	
											<button type="submit" name="action" value="delete" class="btn btn-primary waves-effect waves-light">Delete User</button>									
										</div>

									</form>										

								</div>
							</div>
							
                        </div>

                        
                        
                        

                    </div> <!-- container -->
                               
                </div> <!-- content -->

            </div>

            
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->

@endsection

	
@section('bot')

<script>
	var resizefunc = [];
</script>
		

<!-- jQuery  -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/detect.js') }}"></script>
<script src="{{ asset('assets/js/fastclick.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
<script src="{{ asset('assets/js/waves.js') }}"></script>
<script src="{{ asset('assets/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>

<script src="{{ asset('assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/plugins/switchery/dist/switchery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/multiselect/js/jquery.multi-select.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-quicksearch/jquery.quicksearch.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/js/jquery.core.js') }}"></script>
<script src="{{ asset('assets/js/jquery.app.js') }}"></script>


<script>
	jQuery(document).ready(function() {
		// Select2
		$(".select2").select2();
		
		$(".select2-limiting").select2({
		  maximumSelectionLength: 2
		});
		
	   $('.selectpicker').selectpicker();
		$(":file").filestyle({input: false});
		});
   
</script>

@endsection
