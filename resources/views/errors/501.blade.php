@extends('errors.base')

@section('content')
<!-- HOME -->
<section class="home bg-dark" id="home">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<div class="home-wrapper">
					<h1 class="icon-main text-custom"><i class="md md-album"></i></h1>
					<h1 class="home-text"><span class="rotate">Not Implemented,But we are on it!, Check back later</span></h1>
					<p class="m-t-30 text-muted cd-text">
						This page is currently not yet done, please check back later.
					</p>

					<!-- COUNTDOWN -->
					<div class="row m-t-40">
						<div class="col-sm-12 u-countdown">
							<div class="row">
								<div>
									<div>
										<span>0</span><span>Days</span>
									</div>
									<div>
										<span>0</span><span>Hours</span>
									</div>
								</div>
								<div>
									<div>
										<span>0</span><span>Minutes</span>
									</div>
									<div>
										<span>0</span><span>Seconds</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /COUNTDOWN -->

				</div>
			</div>
		</div>
	</div>
</section>
<!-- END HOME -->
@endsection


@section('bot')
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

<!-- Countdown -->
<script src="{{ asset('assets/plugins/countdown/dest/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('assets/plugins/simple-text-rotator/jquery.simple-text-rotator.min.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function() {

		// Countdown
		// To change date, simply edit: var endDate = "September 16, 2016 18:16:00";
		$(function() {
			var endDate = "February 19, 2016 11:59:59";
			$('.u-countdown .row').countdown({
				date : endDate,
				render : function(data) {
					$(this.el).html('<div><div><span class="text-custom">' + (parseInt(this.leadingZeros(data.years, 2) * 365) + parseInt(this.leadingZeros(data.days, 2))) + '</span><span><b>Days</b></span></div><div><span class="text-primary">' + this.leadingZeros(data.hours, 2) + '</span><span><b>Hours</b></span></div></div><div class="lj-countdown-ms"><div><span class="text-pink">' + this.leadingZeros(data.min, 2) + '</span><span><b>Minutes</b></span></div><div><span class="text-info">' + this.leadingZeros(data.sec, 2) + '</span><span><b>Seconds</b></span></div></div>');
				}
			});
		});

		// Text rotate
		$(".home-text .rotate").textrotator({
			animation : "fade",
			speed : 3000
		});
	});

</script>
@endsection
