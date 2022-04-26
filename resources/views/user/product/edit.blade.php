@extends('user.base')

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
									x
								</button>
								{{ $errors->first() }}
							</div>
						@endif
						
						@if (Session::has('success'))
							<div class="alert alert-success alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
									x
								</button>
								{{ Session::get('success') }}
							</div>
						@endif
						
						
                        <div class="row">
                            <div class="col-sm-12">


                                    <form action="{{ route('developer.edit-stub', $stub->uuid) }}" method="post">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card-box">
                                                    <h5 class="text-muted text-uppercase m-t-0 m-b-20"><b>Edit Stub</b></h5>
													
													{{ csrf_field() }}

                                                    <div class="form-group m-b-20">
                                                        <label>Stub Title <span class="text-danger">*</span></label>
                                                        <input type="text" value="{{ $stub->title }}" class="form-control" name="title" placeholder="e.g : Simple Crypter">
                                                    </div>

                                                    <div class="form-group m-b-20">
                                                        <label>Stub Description <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" rows="5" name="description" placeholder="Please enter a description">{{ $stub->description }}</textarea>
                                                    </div>
													
													<div class="checkbox checkbox-primary">
														<input name="new_api_key" value="true" type="checkbox">
														<label for="checkbox1">
															Generate new API Key
														</label>
													</div>
													</br>
													
                                                    <div class="form-group m-b-20">
                                                        <label>Price per crypt in $<span class="text-danger">*</span></label>
                                                        <input type="text" name="price" value="{{ $stub->price }}" class="form-control" value="1">
                                                    </div>
													
                                                    <div class="form-group m-b-20">
                                                        <label class="m-b-15">Mode <span class="text-danger">*</span></label>
                                                        <br/>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" name="mode" value="0" name="radioInline" {{ $stub->isMode(0) ? 'checked' : '' }}>
                                                            <label for="inlineRadio1"> Easy </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" name="mode" value="1" name="radioInline" {{ $stub->isMode(1) ? 'checked' : '' }}>
                                                            <label for="inlineRadio2"> Medium </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" name="mode" value="2" name="radioInline" {{ $stub->isMode(2) ? 'checked' : '' }}>
                                                            <label for="inlineRadio3"> Advanced </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-b-20">
                                                        <label class="m-b-15">Status <span class="text-danger">*</span></label>
                                                        <br/>
														
														<div class="radio radio-inline">
                                                            <input type="radio" name="status" value="0" name="radioInline" {{ $stub->isStatus(0) ? 'checked' : '' }}>
                                                            <label for="inlineRadio2"> Offline </label>
                                                        </div>
														
                                                        <div class="radio radio-inline">
                                                            <input type="radio" name="status" value="1" {{ $stub->isStatus(1) ? 'checked' : '' }}>
                                                            <label for="inlineRadio1"> Online </label>
                                                        </div>	
														
                                                        <div class="radio radio-inline">
                                                            <input type="radio" name="status" value="2" {{ $stub->isStatus(2) ? 'checked' : '' }}>
                                                            <label for="inlineRadio1"> Maintenance </label>
                                                        </div>
       
                                                        <div class="radio radio-inline">
                                                            <input type="radio" name="status" value="3" {{ $stub->isStatus(3) ? 'checked' : '' }}>
                                                            <label for="inlineRadio3"> Pending </label>
                                                        </div>
                                                    </div>
													
													<div class="row">
														<div class="col-sm-12">
															<hr />
															<div class="text-center p-20">
																 <a href="{{ route('developer.stubs') }}" button type="button" class="btn w-sm btn-danger waves-effect">Cancel</button> </a>
																 <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Edit Stub</button>
															</div>
														</div>
													</div>
														
													</div>
												</div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
		   


		</div> <!-- container -->   
	</div> <!-- content -->
</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
@endsection


