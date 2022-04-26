@extends('user.base')

@section('top')
		<!--Footable-->
		<link href="{{ asset('assets/plugins/footable/css/footable.core.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" />
		
		
        <link href="{{ asset('assets/plugins/c3/c3.min.css') }}" rel="stylesheet" type="text/css"  />
        
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
                        	<div class="col-md-6">
								<a href="{{ route('developer.create-stub') }}" class="btn btn-default btn-md waves-effect waves-light m-b-30 pull-left"><i class="md-add"></i> Create new Product</a>
                        	</div>
                        </div>
                        

                        <div class="row">
							<div class="col-sm-12">
								<div class="card-box">
									<h4 class="m-t-0 header-title"><b>Stubs</b></h4>
									<p class="text-muted m-b-30 font-13">
										Press the + icon to see additional infos
									</p>
									<table id="demo-foo-row-toggler" class="table toggle-circle table-hover">
										<thead>
											<tr>
												<th data-toggle="true">Title</th>
												<th>Price</th>
												<th data-hide="phone"> Status </th>
												<th data-hide="all"> Description </th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
										
										@foreach ($products as $key => $product)
											<tr>
												<td>{{ $product->name }}</td>
												<td>${{ $product->price }}</td>
												<td>{{ $product->getMode($stub->mode) }}</td>
												<td><span class="label label-table label-{{ $stub->getStatusColor() }}">{{ $stub->getStatus($stub->status) }}</td>
												<td><span class="label label-table label-success">{{ $stub->api_key }}</span></td>
												<td>{{ $stub->description }}</td>
												<td><a href="{{ route('developer.edit-stub', $stub->uuid) }}" class="btn btn-success btn-sm"><i class="md md-mode-edit"></i></a></td>
											</tr>
										@endforeach

										</tbody>
									</table>
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
			    <h4 class="custom-modal-title">Add New</h4>
			    <div class="custom-modal-text text-left">
			        <form role="form" action="{{ route('developer.create-stub') }}" method="post">
					
						{{ csrf_field() }}
						
			        	<div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Title">
                        </div>
                        
                        <div class="form-group">
                            <label for="position">Description</label>
                            <input type="text" class="form-control" name="description" placeholder="Enter Description">
                        </div>
                        
					<div class="form-group">
						<label for="position">Mode</label>
						<select name="mode" class="form-control">
						  <option value="0">Easy</option>
						  <option value="1">Medium</option>
						  <option value="2">Advanced</option>
						</select>
					</div>
                        
                        <button type="submit" class="btn btn-default waves-effect waves-light">Save</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10">Cancel</button>
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
        
        <!--C3 Chart-->
        <script type="text/javascript" src="{{ asset('assets/plugins/d3/d3.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/c3/c3.min.js') }}"></script>
        
        <script type="text/javascript" src="{{ asset('assets/pages/jquery.opportunities.init.js') }}"></script>
		        
        <!--FooTable-->
		<script src="{{ asset('assets/plugins/footable/js/footable.all.min.js') }}"></script>
		<!--FooTable Example-->
		<script src="{{ asset('assets/pages/jquery.footable.js') }}"></script>
@endsection