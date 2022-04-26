@extends('user.base')

@section('content')

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->      
            <div class="content-page">
			<div class="content">
			<div class="container">

                    <div class="row pricing-plan">
	
						<div class="col-md-1"> </div>
					
                        <div class="col-md-10">
						
							<div class="col-md-12">
								<h2 class="page-header">Available Packages</h2>
							</div>
							
						
                            <div class="row">

                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <div class="price_card text-center">
                                        <div class="pricing-header bg-pink">
                                            <span class="price">21321311 Credits</span>
                                            <span class="name">dqqqdqqdqq</span>
                                        </div>
                                        <ul class="price-features">
											<li>Access to premium section</li>
                                            <li>Beta access to new features</li>
											<li>Increase settings limit to <strong>30</strong></li>
                                        </ul>
										<form action="#" method="post">
											{{ csrf_field() }}
											<button type="submit" class="btn btn-primary waves-effect waves-light w-md">Instant Purchase!</button>
										</form>
                                    </div> <!-- end Pricing_card -->
                                </div> <!-- end col -->

                                {{--<div class="col-sm-6 col-md-6 col-lg-4">--}}
                                    {{--<div class="price_card text-center">--}}
                                        {{--<div class="pricing-header bg-primary">--}}
                                            {{--<span class="price">{{ $developer['price'] }} Credits</span>--}}
                                            {{--<span class="name">{{ $developer['display_name'] }}</span>--}}
                                        {{--</div>--}}
                                        {{--<ul class="price-features">--}}
                                            {{--<li>Access to developer section</li>--}}
											{{--<li>Access to developer API</li>--}}
											{{--<li>Manage and sell your stubs</li>--}}
                                        {{--</ul>--}}
										{{--<form action="{{ route('user.buy-package', $developer['uuid']) }}" method="post">--}}
											{{--{{ csrf_field() }}--}}
											{{--<button class="btn btn-primary waves-effect waves-light w-md">Instant Purchase!</button>--}}
										{{--</form>--}}
                                    {{--</div> <!-- end Pricing_card -->--}}
                                {{--</div> <!-- end col -->--}}

                                {{--<div class="col-sm-6 col-md-6 col-lg-4">--}}
                                    {{--<div class="price_card text-center">--}}
                                        {{--<div class="pricing-header bg-purple">--}}
                                            {{--<span class="price">{{ $ultimate['price'] }} Credits</span>--}}
                                            {{--<span class="name">{{ $ultimate['display_name'] }}</span>--}}
                                        {{--</div>--}}
                                        {{--<ul class="price-features">--}}
                                            {{--<li>{{ $premium['display_name'] }} package</li>--}}
											{{--<li>{{ $developer['display_name'] }} package</li>--}}
											{{--<li>Save $5</li>--}}
                                        {{--</ul>--}}
										{{--<form action="{{ route('user.buy-package', $ultimate['price']) }}" method="post">--}}
											{{--{{ csrf_field() }}--}}
											{{--<button class="btn btn-primary waves-effect waves-light w-md">Instant Purchase!</button>--}}
										{{--</form>--}}
                                    {{--</div> <!-- end Pricing_card -->--}}
                                {{--</div> <!-- end col -->--}}
  

                            </div> 
                        </div>
                    </div>
					
				</div>
			</div>
		</div>

@endsection