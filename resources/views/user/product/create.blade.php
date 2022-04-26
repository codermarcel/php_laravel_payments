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
									X
								</button>
								{{ $errors->first() }}
							</div>
						@endif
						
						@if (Session::has('success'))
							<div class="alert alert-success alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
									X
								</button>
								{{ Session::get('success') }}
							</div>
						@endif
						
						
                        <div class="row">
                            <div class="col-sm-12">


                                    <form action="{{ route('developer.create-stub') }}" method="post">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card-box">
                                                    <h5 class="text-muted text-uppercase m-t-0 m-b-20"><b>Create Product</b></h5>
													
													{{ csrf_field() }}

                                                    <div class="form-group m-b-20">
                                                        <label>Product Title <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="title" placeholder="e.g : MyProduct">
                                                    </div>

                                                    <div class="form-group m-b-20">
                                                        <label>Product Description <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" rows="5" name="description" placeholder="Please enter a description"></textarea>
                                                    </div>


                                                    <div class="form-group m-b-20">
                                                        <label>Price in $<span class="text-danger">*</span></label>
                                                        <input type="text" name="price" class="form-control" value="1">
                                                    </div>

                                                    <div class="form-group m-b-20">
                                                        <label class="m-b-15">Status <span class="text-danger">*</span></label>
                                                        <br/>
														
														<div class="radio radio-inline">
                                                            <input type="radio" name="status" value="0" name="radioInline" checked>
                                                            <label for="inlineRadio2"> Offline </label>
                                                        </div>
														
                                                        <div class="radio radio-inline">
                                                            <input type="radio" name="status" value="1">
                                                            <label for="inlineRadio1"> Online </label>
                                                        </div>	
														
                                                        <div class="radio radio-inline">
                                                            <input type="radio" name="status" value="2">
                                                            <label for="inlineRadio1"> Maintenance </label>
                                                        </div>
       
                                                        <div class="radio radio-inline">
                                                            <input type="radio" name="status" value="3">
                                                            <label for="inlineRadio3"> Pending </label>
                                                        </div>
                                                    </div>

													<div class="row">
														<div class="col-sm-12">
															<hr />
															<div class="text-center p-20">
																 <a href="#" button type="button" class="btn w-sm btn-danger waves-effect">Cancel</button> </a>
																 <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Create Product</button>
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


