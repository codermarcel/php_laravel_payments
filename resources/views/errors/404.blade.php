@extends('errors.base')

@section('content')
<div class="wrapper-page">
	<div class="ex-page-content text-center">
		<div class="text-error"><span class="text-primary">4</span><i class="ti-face-sad text-pink"></i><span class="text-info">4</span></div>
		<h2>Who0ps! Page not found</h2><br>
		<p class="text-muted">Use the navigation above or the button below to get back on track.</p>
		<br>
		<a class="btn btn-default waves-effect waves-light" href="{{ route('user.home') }}"> Return Home</a>
	</div>
</div>
@endsection

