@extends('errors.base')

@section('content')
<div class="wrapper-page">
	<div class="ex-page-content text-center">
		<div class="text-error"><span class="text-primary">5</span><i class="ti-face-sad text-pink"></i><i class="ti-face-sad text-info"></i></div>
		<h2>Internal Server Error.</h2><br>
		<p class="text-muted">Why not try refreshing your page? or you can contact <a href="#">support</a></p>
		<br>
		<a class="btn btn-default waves-effect waves-light" href="{{ route('user.home') }}"> Return Home</a>
		
	</div>
</div>
@endsection

