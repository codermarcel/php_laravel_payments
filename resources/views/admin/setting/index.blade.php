@extends('user.base')

@section('content')
					
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
								<div class="col-lg-4">
									<div class="panel panel-border panel-primary">
										<div class="panel-heading">
											<h3 class="panel-title">Site Settings</h3>
										</div>
										
										<div class="panel-body">
												<form role="form" id="edit" action="{{ route('admin.edit-settings') }}" method="post">
													{{ csrf_field() }}
													
													@foreach ($settings as $key => $setting)
														<div class="form-group">
															<label for="exampleInputEmail1">{{ $setting->name }}</label>
															<input value="{{ $setting->value }}" type="text" class="form-control" name="{{ $setting->name }}" placeholder="{{ $setting->name }}">
														</div>
													@endforeach

													<button type="submit" name="action" value="edit" class="btn btn-purple waves-effect waves-light">Save changes</button>
													<button type="submit" name="action" value="reset" class="btn btn-primary waves-effect waves-light">Reset from Config</button>
												</form>
												

										</div>
										
									</div>
								</div>
						</div>	

                    </div> <!-- container -->      
                </div> <!-- content -->
            </div>
@endsection

