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

						{{ $plans['bronze']['price'] }}
						
						@if ( ! Auth::user()->isConfirmed())
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
									×
								</button>
								You have not confirmed your email address yet, please confirm your email address before purchasing Credits.
							</div>
						@endif
						
							<div class="col-md-12">
								<h2 class="page-header">Purchase Credits</h2>
							</div>
						
                            <div class="row">
							
					@if (Auth::user()->isConfirmed())
						
					
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <div class="price_card text-center">
                                        <div class="pricing-header bg-pink">
                                            <span class="price">$3</span>
                                            <span class="name">fewfew}</span>
                                        </div>
                                        <ul class="price-features">
											<li>Get  <strong>qdqdqqdq</strong> Credits</li>
                                            <li>Only <strong>qdqdqdqdq</strong> per Credit</li>
											<li><strong>Instant</strong> purchase</li>
                                        </ul>
                                       <form action="#" method="post">
											{{ csrf_field() }}
											<button class="btn btn-primary waves-effect waves-light w-md">Purchase Credits</button>
										</form>
                                    </div> <!-- end Pricing_card -->
                                </div> <!-- end col -->

								
								{{----}}
                                {{--<div class="col-sm-6 col-md-6 col-lg-4">--}}
                                    {{--<div class="price_card text-center">--}}
                                        {{--<div class="pricing-header bg-primary">--}}
                                            {{--<span class="price">${{ $silver['price'] }}</span>--}}
                                            {{--<span class="name">{{ $silver['display_name'] }}</span>--}}
                                        {{--</div>--}}
                                        {{--<ul class="price-features">--}}
											{{--<li>Get  <strong>{{ $silver['credit_amount'] }}</strong> Credits</li>--}}
                                            {{--<li>Only <strong>${{ round($silver['price'] / $silver['credit_amount'], 2) }}</strong> per Credit</li>--}}
											{{--<li><strong>Instant</strong> purchase</li>--}}
                                        {{--</ul>--}}
                                       {{--<form action="{{ route('user.buy-plan', $silver['uuid']) }}" method="post">--}}
											{{--{{ csrf_field() }}--}}
											{{--<button class="btn btn-primary waves-effect waves-light w-md">Purchase Credits</button>--}}
										{{--</form>--}}
                                    {{--</div> <!-- end Pricing_card -->--}}
                                {{--</div> <!-- end col -->--}}

								{{----}}
								{{----}}
                                {{--<div class="col-sm-6 col-md-6 col-lg-4">--}}
                                    {{--<div class="price_card text-center">--}}
                                        {{--<div class="pricing-header bg-purple">--}}
                                            {{--<span class="price">${{ $gold['price'] }}</span>--}}
                                            {{--<span class="name">{{ $gold['display_name'] }}</span>--}}
                                        {{--</div>--}}
                                        {{--<ul class="price-features">--}}
											{{--<li>Get  <strong>{{ $gold['credit_amount'] }}</strong> Credits</li>--}}
                                            {{--<li>Only <strong>${{ round($gold['price'] / $gold['credit_amount'], 2) }}</strong> per Credit</li>--}}
											{{--<li><strong>Instant</strong> purchase</li>--}}
                                        {{--</ul>--}}
										{{--<form action="{{ route('user.buy-plan', $gold['uuid']) }}" method="post">--}}
											{{--{{ csrf_field() }}--}}
											{{--<button class="btn btn-primary waves-effect waves-light w-md">Purchase Credits</button>--}}
										{{--</form>--}}
                                    {{--</div> <!-- end Pricing_card -->--}}
                                {{--</div> <!-- end col -->--}}
					@endif


                            </div> 
                        </div>
                    </div>
					
				</div>
			</div>
		</div>

@endsection