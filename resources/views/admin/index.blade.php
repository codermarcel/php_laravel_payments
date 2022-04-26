@extends('user.base')

@section('content')
					
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
					
						<div class="row">
							<div class="col-lg-4">
								<div class="card-box">
									<div class="bar-widget">
										<div class="table-box">
											<div class="table-detail">
												<div class="iconbox bg-info">
													<i class="icon-layers"></i>
												</div>
											</div>

											<div class="table-detail">
											   <h4 class="m-t-0 m-b-5"><b>12560</b></h4>
											   <p class="text-muted m-b-0 m-t-0">Total Users</p>
											</div>
                                            <div class="table-detail text-right">
                                                <span data-plugin="peity-bar" data-colors="#34d3eb,#ebeff2" data-width="120" data-height="45">5,3,9,6,5,9,7,3,5,2,9,7,2,1</span>
                                            </div>

										</div>
									</div>
								</div>
							</div>

                            <div class="col-lg-4">
								<div class="card-box">
									<div class="bar-widget">
										<div class="table-box">
											<div class="table-detail">
												<div class="iconbox bg-custom">
													<i class="icon-layers"></i>
												</div>
											</div>

											<div class="table-detail">
											   <h4 class="m-t-0 m-b-5"><b>356</b></h4>
											   <p class="text-muted m-b-0 m-t-0">Total Revenue</p>
											</div>
                                            <div class="table-detail text-right">
                                                <span data-plugin="peity-pie" data-colors="#5fbeaa,#ebeff2" data-width="50" data-height="45">1/5</span>
                                            </div>

										</div>
									</div>
								</div>
							</div>

                            <div class="col-lg-4">
								<div class="card-box">
									<div class="bar-widget">
										<div class="table-box">
											<div class="table-detail">
												<div class="iconbox bg-danger">
													<i class="icon-layers"></i>
												</div>
											</div>

											<div class="table-detail">
											   <h4 class="m-t-0 m-b-5"><b>96562</b></h4>
											   <p class="text-muted m-b-0 m-t-0">Total Packages sold</p>
											</div>
                                            <div class="table-detail text-right">
                                                <span data-plugin="peity-donut" data-colors="#f05050,#ebeff2" data-width="50" data-height="45">1/5</span>
                                            </div>

										</div>
									</div>
								</div>
							</div>
						</div>


                        <div class="row">
                            <div class="col-lg-4">
                        		<div class="card-box">
                        			<h4 class="text-dark header-title m-t-0 m-b-30">Daily Report</h4>

                        			<div class="widget-chart text-center">
                                        <div id="sparkline3"></div>
	                                	<ul class="list-inline m-t-15">
	                                		<li>
	                                			<h5 class="text-muted m-t-20">User Registrations</h5>
	                                			<h4 class="m-b-0">$1000</h4>
	                                		</li>
	                                		<li>
	                                			<h5 class="text-muted m-t-20">Package Revenue</h5>
	                                			<h4 class="m-b-0">$523</h4>
	                                		</li>
	                                		<li>
	                                			<h5 class="text-muted m-t-20">Other Revenue</h5>
	                                			<h4 class="m-b-0">$965</h4>
	                                		</li>
	                                	</ul>
                                	</div>
                        		</div>

                            </div>

                            <div class="col-lg-4">
                        		<div class="card-box">
                        			<h4 class="text-dark  header-title m-t-0 m-b-30">Weekly Report</h4>

                        			<div class="widget-chart text-center">
                                        <div id="sparkline2"></div>
	                                	<ul class="list-inline m-t-15">
	                                		<li>
	                                			<h5 class="text-muted m-t-20">User Registrations</h5>
	                                			<h4 class="m-b-0">$1000</h4>
	                                		</li>
	                                		<li>
	                                			<h5 class="text-muted m-t-20">Package Revenue</h5>
	                                			<h4 class="m-b-0">$523</h4>
	                                		</li>
	                                		<li>
	                                			<h5 class="text-muted m-t-20">Other Revenue</h5>
	                                			<h4 class="m-b-0">$965</h4>
	                                		</li>
	                                	</ul>
                                	</div>
                        		</div>

                            </div>

                            <div class="col-lg-4">
                        		<div class="card-box">
                        			<h4 class="text-dark  header-title m-t-0 m-b-30">Monthly Report</h4>

                        			<div class="widget-chart text-center">
                                        <div id="sparkline1"></div>
	                                	<ul class="list-inline m-t-15">
	                                		<li>
	                                			<h5 class="text-muted m-t-20">User Registrations</h5>
	                                			<h4 class="m-b-0">$1000</h4>
	                                		</li>
	                                		<li>
	                                			<h5 class="text-muted m-t-20">Package Revenue</h5>
	                                			<h4 class="m-b-0">$523</h4>
	                                		</li>
	                                		<li>
	                                			<h5 class="text-muted m-t-20">Other Revenue</h5>
	                                			<h4 class="m-b-0">$965</h4>
	                                		</li>
	                                	</ul>
                                	</div>
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
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <script src="assets/plugins/peity/jquery.peity.min.js"></script>

        <script src="assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
		
		
		<script src="assets/pages/jquery.dashboard_3.js"></script>

        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
@endsection
	

