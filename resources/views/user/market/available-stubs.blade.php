@extends('user.base')

@section('top')
	@parent
	<link href="{{ asset('assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet" type="text/css" />
	<script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
@endsection

@section('content')
					
            <div class="content-page">
                <div class="content">
                    <div class="container">
					

                        <!--Basic Columns-->
						<!--===================================================-->
						
						<div class="row">
							<div class="col-sm-12">
								<div class="card-box">
									<h4 class="m-t-0 header-title"><b>Available Stubs</b></h4>
									<p class="text-muted font-13">
										Here you can view all available stubs and purchase crypts.
									</p>
									
									
									<table data-toggle="table" class="table-bordered ">
										<thead>
											<tr>
												<th data-field="id" data-switchable="false">#</th>
												<th data-field="name">ID</th>
												<th data-field="date">Stub Title</th>
												<th data-field="title">Stub Developer</th>
												<th data-field="amount">Crypt Price</th>
												<th data-field="user-status" class="text-center">Supported Mode</th>
											</tr>
										</thead>
										
										<tbody>
										
										@foreach ($stubs as $index => $stub)
											<tr>
												<td>{{ $index + 1 }}</td>
												<td> <a href="{{ route('user.view-stub', $stub->uuid) }}"> {{ $stub->uuid }}</a> </td>
												<td>{{ $stub->title }}</td>
												<td>{{ $stub->user->username }}</td>
												<td>${{ $stub->price }}</td>
												<td><span class="label label-table label-{{ $stub->getModeColor() }}">{{ $stub->getMode($stub->mode) }}</span></td>
											</tr>
										@endforeach
										

											
										</tbody>
									</table>
									
									<div class="pagination"> {{ $stubs->links() }} </div>
									
									
								</div>
							</div>
						</div>
						
						
						
					
                    </div> <!-- container -->      
                </div> <!-- content -->
            </div>
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
        
        <script src="{{ asset('assets/plugins/bootstrap-table/dist/bootstrap-table.min.js') }}"></script>
        
        <script src="{{ asset('assets/pages/jquery.bs-table.js') }}"></script>
@endsection
	

