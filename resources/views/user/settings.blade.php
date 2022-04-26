@extends('user.base')

@section('top')
	@parent
		<link href="{{ asset('assets/plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet">
		<!-- Dropzone css -->
        <link href="{{ asset('assets/plugins/dropzone/dist/dropzone.css') }}" rel="stylesheet" type="text/css" />
		<script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
@endsection

@section('content')
					<div class="content-page">
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
							<div class="col-sm-12">
								<div class="card-box">
									<h4 class="m-t-0 header-title"><b>Manage your Settings</b></h4>
									<p class="text-muted m-b-30 font-13">
										Add or remove Settings.
									</p>
									
									<table id="demo-foo-addrow" class="table table-striped m-b-0 table-hover toggle-circle" data-page-size="7">
										<thead>
											<tr>
												<th data-sort-ignore="true" class="min-width"></th>
												<th data-sort-initial="true" data-toggle="true">Title</th>
												<th>Hash</th>
												<th data-hide="phone">Upload Date</th>
                                                <th data-hide="phone">Last Used</th>
                                                <th data-hide="phone, tablet">Usages</th>
												<th data-hide="phone, tablet">Actions</th>
											</tr>
										</thead>
										<div class="pad-btm form-inline">
											<div class="row">

												<div class="col-sm-6 text-xs-center">
													<div class="col-sm-4">
														 <a href="#upload-modal" class="btn btn-default btn-md w-md waves-effect waves-ligh" data-animation="fadein" data-plugin="custommodal" 
														 data-overlaySpeed="1" data-overlayColor="#36404a"><i class="ion-upload m-r-5"></i> Upload Settings</a>
													</div>
												</div>
												
												<div class="col-sm-6 text-xs-center text-right">
													<div class="form-group">
														<input id="demo-input-search2" type="text" placeholder="Search" class="form-control  input-sm" autocomplete="off">
													</div>
												</div>
											</div>
										</div>
										<tbody>
                                            {{--@foreach ($settings as $setting)--}}
                                                {{--<tr>--}}
    												{{--<td style="text-align: center;"><button class="demo-delete-row btn btn-danger btn-xs btn-icon fa fa-times"></button></td>--}}
    												{{--<td>{{ $setting->title }}</td>--}}
    												{{--<td>{{ $setting->hash }}</td>--}}
    												{{--<td>{{ $setting->created_at->diffForHumans() }}</td>--}}
                                                    {{--<td>{{ $setting->updated_at->diffForHumans() }}</td>--}}
                                                    {{--<td>{{ $setting->usages }}</td>--}}
    												{{--<td><span class="label label-table label-success">Active</span></td>--}}
    											{{--</tr>--}}
                                            {{--@endforeach--}}


												<tr>
													<td style="text-align: center;"><button class="demo-delete-row btn btn-danger btn-xs btn-icon fa fa-times"></button></td>
													<td>{141414141s</td>
													<td>3121414141</td>
													<td>DDe1e1</td>
													<td>DDD</td>
													<td>AAA</td>
													<td><span class="label label-table label-success">Active</span></td>
												</tr>


										</tbody>
										<tfoot>
											<tr>
												<td colspan="6">
													<div class="text-right">
														<ul class="pagination pagination-split m-t-30"></ul>
													</div>
												</td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>
					
					
            <!-- Modal -->
			<div id="upload-modal" class="modal-demo">
			    <button type="button" class="close" onclick="Custombox.close();">
			        <span>&times;</span><span class="sr-only">Close</span>
			    </button>
			    <h4 class="custom-modal-title">Upload Setting</h4>
			    <div class="custom-modal-text text-left">

                        <div class="row">
                            <div class="col-md-6 portlets">
                                <!-- Your awesome content goes here -->
                                <div class="m-b-30">

								<div class="dz-message">

								</div>

								<div class="fallback">
									<input name="file" type="file" multiple />
								</div>

								<div class="dropzone-previews" id="dropzonePreview"></div>

								<h4 style="text-align: center;color:#428bca;">Drop images in this area  <span class="glyphicon glyphicon-hand-down"></span></h4>
									
                                </div>
                            </div>
                        </div>
				
			    </div>
			</div>
					
					
@endsection

@section('bot')

<script>
	var resizefunc = [];
</script>

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

<!-- Page Specific JS Libraries -->
<script src="{{ asset('assets/plugins/dropzone/dist/dropzone.js') }}"></script>
		
<!-- Modal-Effect -->
<script src="{{ asset('assets/plugins/custombox/dist/custombox.min.js') }}"></script>
<script src="{{ asset('assets/plugins/custombox/dist/legacy.min.js') }}"></script>
@endsection
	

