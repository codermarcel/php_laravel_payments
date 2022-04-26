@extends('user.base')

@section('content')

   <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
		
                <div class="wraper container-fluid">
				
						<div class="row">
						<div class="col-sm-1"> </div>
							
								<div class="col-lg-10">
								
										<div class="row">
											<div class="col-sm-12">
												<h2 class="page-header">Navigation Menu</h2>
											</div>
										</div>

											<div class="card-box widget-inline">
											<div class="row">	
											
													{{--<a href="{{ route('user.plans') }}">--}}
													<div class="col-lg-3" >
														<div class="widget-inline-box text-center">
															<h3><i class="text-success ion-social-usd"></i></h3>
															<h4 class="text-muted">Buy Credits</h4>
														</div>
													</div>		

													
													{{--<a href="{{ route('user.packages') }}">--}}
													<div class="col-lg-3" >
														<div class="widget-inline-box text-center">
															<h3><i class="text-warning ion-pricetags"></i></h3>
															<h4 class="text-muted">Buy Package</h4>
														</div>
													</div>
								
										
													<a href="#b"> 
													<div class="col-lg-3" >
														<div class="widget-inline-box text-center">
															<h3><i class="text-danger ion-ios7-cart"></i></h3>
															<h4 class="text-muted">Billing History</h4>
														</div>
													</div>	
													<a/>
													
													
													{{--<a href="{{ route('user.faq') }}"> --}}
													<div class="col-lg-3" >
														<div class="widget-inline-box text-center">
															<h3><i class="text-info ion-chatbox"></i></h3>
															<h4 class="text-muted">Faq & Support</h4>
														</div>
													</div>
													<a/>
																

												</div>
											</div>
								

							</div>
						</div>
						
				<div class="col-md-1"> </div>
				

				<div class="col-md-10">
				
					<div class="row">
						<div class="col-sm-6">
							<h2 class="page-header">Profile</h4>
						</div>
					</div>
					
					
					
					<div class="row">
						<div class="col-md-3">
							<div class="card-box">
								<h4 class="m-t-0 header-title"><b>Userdata</b></h4>
								<div class="p-20">
                                
									<div class="about-info-p">
										<strong>Username</strong>
										<br>
										<p class="text-muted">{{ Auth::user()->username }}</p>
									</div>

									<div class="about-info-p">
										<strong>Email</strong>
										<br>
										<p class="text-muted">{{ Auth::user()->email }}</p>
									</div>

									<div class="about-info-p">
										<strong>Join Date</strong>
										<br>
										<p class="text-muted">{{ Auth::user()->created_at->diffForHumans() }}</p>
									</div>

                                    <div class="about-info-p">
										<strong>Last Active</strong>
										<br>
										<p class="text-muted">{{ Auth::user()->updated_at->diffForHumans() }}</p>
									</div>
									
									<!-- Later
								   <button type="button" class="btn btn-primary waves-effect waves-light">
								   <span class="btn-label"><i class="fa fa-edit"></i>
								   </span>Edit Info</button>
								   -->
								</div>
							</div>				
						</div>
						
						<div class="col-md-3">
							<div class="card-box">
								<h4 class="m-t-0 header-title"><b>Other Information</b></h4>
								<div class="p-20">
								
									<div class="about-info-p">
										<strong>End of Subscription</strong>
										<br>
										<p class="text-muted">{{ Auth::user()->subscription_end }}</p>
									</div>
											

                                    <div class="about-info-p">
										<strong>Product Limit</strong>
										<br>
										<p class="success">10</p>
									</div>
									
									
								</div>
							</div>				
						</div>
                </div> <!-- container -->   
						
				</div>
						
						
						
				
      
                </div> <!-- content -->
            </div>
		</div>


		
@endsection

