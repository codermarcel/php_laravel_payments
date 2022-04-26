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
                        	<div class="col-lg-12">
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
			                                                    	data-overlaySpeed="1" data-overlayColor="#36404a"><i class="md md-add"></i> Create Role</a>
			                        	</div>
			                        </div>
			                        
                        			<div class="table-responsive">
                                        <table class="table table-hover mails m-0 table table-actions-bar">
                                        	<thead>
												<tr>
													<th>#</th>
													<th>Name</th>
													<th>Created at</th>
													<th>Updated at</th>
													<th>Action</th>
												</tr>
											</thead>
                                            <tbody>
											

											
											@foreach ($roles as $index => $role)
                                                <tr>
													<td>{{ $index + 1 }}</td> <!-- arrays start at index 0, so we want to add 1-->
                                                    <td>{{ $role->name }}</td>
                                                    <td>{{ $role->created_at->diffForHumans() }}</td>
													<td>{{ $role->updated_at->diffForHumans() }}</td>
													<td>
														<a href="{{ route('admin.edit-role', ['id' => $role->id]) }}" class="table-action-btn"><i class="md md-edit"></i></a>
													</td>
                                                </tr>
											@endforeach
											
                                            </tbody>
                                        </table>
                                    </div>
                        		</div>
                                
                            </div> <!-- end col -->
                        </div>

                        
                        
                        

                    </div> <!-- container -->
                               
                </div> <!-- content -->

            </div>
            
            
            <!-- Modal -->
			<div id="custom-modal" class="modal-demo">
			    <button type="button" class="close" onclick="Custombox.close();">
			        <span>&times;</span><span class="sr-only">Close</span>
			    </button>
			    <h4 class="custom-modal-title">Create Role</h4>
			    <div class="custom-modal-text text-left">
			        <form role="form" method="post" action="{{ route('admin.create-role') }}">
					
						{{ csrf_field() }}
						
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" value="{{ old('name') }}" class="form-control" name="name" placeholder="Enter Name">
                        </div>
						
						<div class="form-group">
                            <label for="name">Display Name</label>
                            <input type="text" value="{{ old('display_name') }}" class="form-control" name="display_name" placeholder="Enter Display Name">
                        </div>
                        
						
						<div class="form-group">
							<label class="col-md-2 control-label">Description</label>
							<textarea class="form-control" name="description" placeholder="Enter Description" rows="5">{{ old('description') }}</textarea>
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
	

