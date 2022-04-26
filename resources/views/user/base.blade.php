<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="@lang('global.description')">
		<meta name="author" content="@lang('global.author')">
		<link rel="shortcut icon" href="{{ asset('assets/images/favicon_1.ico') }}">

		@section('title')
            <title>@lang('global.appname')</title>
        @show
		
		
		@section('top')
		<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/core.css') }}" rel="stylesheet" type="text/css" />		
		<link href="{{ asset('assets/css/components.css') }}" rel="stylesheet" type="text/css" />		
		<link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />		
		<link href="{{ asset('assets/css/pages.css') }}" rel="stylesheet" type="text/css" />		
		<link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />	

		<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->		
        @show

	</head>

    <body class="fixed-left">
        
        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="{{ route('user.index') }}" class="logo"><i class="icon-magnet icon-c-logo"></i><span>R<i class="md md-album"></i>P</span></a>
                    </div>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                </div>
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
				
                    <div class="user-details">
                        <div class="pull-left">
                            <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="" class="thumb-md img-circle">
                        </div>
                        <div class="user-info">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">{{ Auth::user()->username }} <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('user.index') }}"><i class="md md-face-unlock"></i> Profile<div class="ripple-wrapper"></div></a></li>
                                    <li><a href="{{ route('user.logout') }}"><i class="md md-settings-power"></i> Logout</a></li>
                                </ul>
                            </div>
                            <p class="text-muted m-0">User</p>
                        </div>
                    </div>
					
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>

						<li class="text-muted menu-title">Management</li>
						<li><a href="{{ route('user.product.index') }}"><i class="md-menu"></i> <span>Products</span> </a></li>
						<li><a href="#"><i class="md-menu"></i> <span>Email Templates</span> </a></li>
						<li><a href="#folder-structure"><i class="md-menu"></i> <span>NetSeal Codes</span> </a></li>
						<li><a href="#folder-structure"><i class="md-menu"></i> <span>Invoices</span> </a></li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End --> 

			@yield('content')
			
			@section('footer')
			<footer class="footer text-right">
				2015 © @lang('global.appname') - This page took {{  round(microtime(true) - LARAVEL_START, 3) }} seconds to load
			</footer>
			@show

			

        </div>
        <!-- END wrapper -->
		
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
		@show

	</body>
</html>