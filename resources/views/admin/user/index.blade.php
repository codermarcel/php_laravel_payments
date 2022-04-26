@extends('user.base')

@section('top')
<link href="{{ asset('assets/plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet">

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
                        	<div class="col-lg-8">
                        		<div class="card-box">
                        			<div class="row">
			                        	<div class="col-sm-8">
			                        		<form role="form">
			                                    <div class="form-group contact-search m-b-30">
			                                    	<input type="text" id="search" class="form-control" placeholder="Search...">
			                                        <!-- <button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button> -->
			                                    </div> <!-- form-group -->
			                                </form>
			                        	</div>
			                        	<div class="col-sm-4">
			                        		 <a href="#custom-modal" class="btn btn-default btn-md waves-effect waves-light m-b-30" data-animation="fadein" data-plugin="custommodal" 
			                                 data-overlaySpeed="1" data-overlayColor="#36404a"><i class="md md-add"></i> Create User</a>
			                        	</div>
			                        </div>
			                        
                        			<div class="table-responsive">
                                        <table class="table table-hover mails m-0 table table-actions-bar">
                                        	<thead>
												<tr>
													<th>#</th>
													<th>Username</th>
													<th>Email</th>
													<th>Join Date</th>
													<th>Action</th>
												</tr>
											</thead>
                                            <tbody>
											

											
											@foreach ($users as $index => $user)
                                                <tr>
													<td>{{ $index + 1 }}</td> <!-- arrays start at index 0, so we want to add 1-->
                                                    <td>{{ $user->username }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->created_at->diffForHumans() }}</td>
													<td>
														<a href="{{ route('admin.users.edit', ['id' => $user->id]) }}" class="table-action-btn"><i class="md md-edit"></i></a>
													</td>
                                                </tr>
											@endforeach
											
                                            </tbody>
                                        </table>
                                    </div>
                        		</div>
                                
                            </div> <!-- end col -->
                            
                            <div class="col-lg-4">
                            	<div class="card-box">
                        			<div class="">
                        				<div class="p-20">
                        					<h4 class="m-b-20 header-title"><b>Activities</b></h4>
                        					<div class="nicescroll p-l-r-10" style="max-height: 555px;">
	                        				<div class="timeline-2">

											@foreach ($users_new as $index => $user)
			                                    <div class="time-item">
			                                        <div class="item-info">
			                                            <div class="text-muted"><small>{{ $user->created_at->diffForHumans() }}</small></div>
			                                            <p><a href="" class="text-info">{{ $user->username }}</a> has registered.</p>
			                                        </div>
			                                    </div>
											@endforeach
			                                    
			                                </div>
	                        			</div>
	                        			</div>
                        			</div>
                            	</div>
                            </div>
                            
                        </div>

                        
                        
                        

                    </div> <!-- container -->
                               
                </div> <!-- content -->

            </div>
            
            
            <!-- Modal -->
			<div id="custom-modal" class="modal-demo">
			    <button type="button" class="close" onclick="Custombox.close();">
			        <span>&times;</span><span class="sr-only">Close</span>
			    </button>
			    <h4 class="custom-modal-title">Create User</h4>
			    <div class="custom-modal-text text-left">
			        <form role="form" method="post" action="{{ route('admin.users.store') }}">
					
						{{ csrf_field() }}
						
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" value="{{ old('email') }}" class="form-control" name="email" placeholder="Enter email">
                        </div>
						
						<div class="form-group">
                            <label for="name">Username</label>
                            <input type="text" value="{{ old('username') }}" class="form-control" name="username" placeholder="Enter Username">
                        </div>
                        
                        <div class="form-group">
                            <label for="position">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter Password">
                        </div>
                        
                        <button type="submit" class="btn btn-default waves-effect waves-light">Save</button>
                    </form>
			    </div>
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


<script src="{{ asset('assets/js/jquery.core.js') }}"></script>
<script src="{{ asset('assets/js/jquery.app.js') }}"></script>

<!-- Modal-Effect -->
<script src="{{ asset('assets/plugins/custombox/dist/custombox.min.js') }}"></script>
<script src="{{ asset('assets/plugins/custombox/dist/legacy.min.js') }}"></script>
@endsection
	

