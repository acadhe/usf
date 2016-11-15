<?php
	use App\Models\Article;
	use Illuminate\Support\Facades\Request;
	$route_name = Request::route()->getName();
?>
<!DOCTYPE html>
<html>
	<head>
		@section('head')
			<meta name="csrf_token" content="{{csrf_token()}}"/>
			<meta name="msapplication-TileColor" content="#da532c">
			<meta name="msapplication-TileImage" content="{{ asset('frontend/img/favicons/mstile-144x144.png') }}">
			<meta name="theme-color" content="#ffffff">
			<title>Urban Community of Practice 2016</title>
			<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
			<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">
			<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/slick.css') }}"/>

			
			<link rel="stylesheet" href="{{asset('frontend/css/styles.css')}}">
			<link rel="stylesheet" media='screen and (min-width: 1020px) and (max-width: 1280px)' href="{{ asset('frontend/css/large-below-desktop.css') }}">
			<link rel="stylesheet" media='screen and (min-width: 601px) and (max-width: 992px)' href="{{ asset('frontend/css/medium.css') }}">
			<link rel="stylesheet" media='screen and (min-width: 320px) and (max-width: 600px)' href="{{ asset('frontend/css/small.css') }}">

			<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('frontend/img/favicons/apple-touch-icon-57x57.png') }}">
			<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('frontend/img/favicons/apple-touch-icon-60x60.png') }}">
			<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('frontend/img/favicons/apple-touch-icon-72x72.png') }}">
			<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('frontend/img/favicons/apple-touch-icon-76x76.png') }}">
			<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('frontend/img/favicons/apple-touch-icon-114x114.png') }}">
			<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('frontend/img/favicons/apple-touch-icon-120x120.png') }}">
			<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('frontend/img/favicons/apple-touch-icon-144x144.png') }}">
			<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('frontend/img/favicons/apple-touch-icon-152x152.png') }}">
			<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/img/favicons/apple-touch-icon-180x180.png') }}">
			<link rel="icon" type="image/png" href="{{ asset('frontend/img/favicons/favicon-32x32.png') }}" sizes="32x32">
			<link rel="icon" type="image/png" href="{{ asset('frontend/img/favicons/android-chrome-192x192.png') }}" sizes="192x192">
			<link rel="icon" type="image/png" href="{{ asset('frontend/img/favicons/favicon-96x96.png') }}" sizes="96x96">
			<link rel="icon" type="image/png" href="{{ asset('frontend/img/favicons/favicon-16x16.png') }}" sizes="16x16">
			<link rel="manifest" href="{{ asset('frontend/img/favicons/manifest.json') }}">
			<link rel="mask-icon" href="{{ asset('frontend/img/favicons/safari-pinned-tab.svg') }}" color="#ffd600">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			
			@include('templates.navbars.notification_head')
		@show
	</head>
<body>
@section('navbar')
	<nav class="nav-master">
	  <div class="nav-wrapper">
		<div class="container" id="wrapper-nav">
			<a href="{{route('home')}}" class="brand-logo left hide-on-med-and-down">
				<img src="{{ asset('frontend/img/logo.svg') }}" alt="UCP Logo">
			</a>
			@include('templates.mobile.header')
			<ul id="nav-mobile" class="left hide-on-med-and-down">
				<li><a href="{{url('about')}}" @if($route_name == 'home.about') class="menu active" @endif class="menu">About</a></li>
				<li><a href="{{url('panelists')}}" @if($route_name == 'home.panelist') class="menu active" @endif class="menu">Panelist</a></li>
				<li><a href="{{url('contact')}}" @if($route_name == 'home.contact') class="menu active" @endif class="menu">Contact Us</a></li>
				<li><a class="dropdown-nav" href="#!" class="dropdown-button menu" href="#" data-beloworigin="true" data-hover="true" data-activates="dd-nav"><i class="material-icons">keyboard_arrow_down</i></a></li>
			</ul>
			<ul id="dd-nav" class="dropdown-content">
				{{-- <li><a href="{{url('help')}}" @if($route_name == 'home.help') class="menu active" @endif class="menu">Help</a></li> --}}
				<li><a href="{{url('tos')}}" @if($route_name == 'home.tos') class="menu active" @endif class="menu">Terms of Use</a></li>
				<li><a href="{{url('privacy-policy')}}" @if($route_name == 'home.privacy-policy') class="menu active" @endif class="menu">Privacy Policy</a></li>
				<li><a href="{{url('ucp-rules')}}" @if($route_name == 'home.rules') class="menu active" @endif class="menu">Rules</a></li>
			</ul>
			<ul id="nav-mobile" class="right hide-on-med-and-down">
				@if(!Auth::guest())
					@can('create',new Article())
						<li><a href="{{route('article.create')}}" class="menu">Write Topic</a></li>
					@endcan
					<li>
						@include('templates.navbars.notification',compact('navbar_notifications'))
					</li>
				@endif
				@if(!Auth::guest())
					<a class="dropdown-button menu" href="#" data-beloworigin="true" data-hover="true" data-activates="dropdown-profile">
						@if(Auth::user()->photo_url == '')
							<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="circle responsive-img profilep-img">
						@else
							<img src="{{Auth::user()->photo_url}}" alt="" class="circle responsive-img profilep-img">
						@endif
					</a>
					<ul id="dropdown-profile" class="dropdown-content">
					@can('create',new Article())
						<li><a href="{{route('article.mine')}}" class="menu">Your Topic</a></li>
					@endcan
						<li><a href="{{route('user.read',['user_id'=>Auth::user()->id])}}">Profile</a></li>
						<li class="valign-wrapper">
							<form method="post" action="{{route('auth.logout.post')}}">
								{!! csrf_field() !!}
								<button class="btn-flat" type="submit">Sign Out</button>
							</form>
						</li>
					</ul>
				@else
					<li>
						<a href="{{route('auth.login')}}" class="sgnin menu">Sign In / Signup</a>
					</li>
				@endif
			</ul>
		</div>
	  </div>
	</nav>
@show
{{--@section('alert')--}}
	{{--@if(isset($message_success))--}}
	{{--<div class="container">--}}
		{{--<div class="alert alert-success">{{$message_success}}</div>--}}
	{{--</div>--}}
	{{--@endif--}}
{{--@show--}}

@yield('content')

@section('scripts')
	<script type="text/javascript" src="{{asset('frontend/js/jquery-2.1.1.min.js')}}"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
	<script type="text/javascript" src="{{asset('frontend/js/jquery.dirtyforms.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('frontend/js/materialize.js')}}"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/classie/1.0.1/classie.min.js"></script>
	<script type="text/javascript" src="{{asset('frontend/js/main.js')}}"></script>

	{{-- script for notification in navbar --}}
	@if(!Auth::guest())
		@include('templates.navbars.notification_scripts')
	@endif

	{{-- script for toast --}}
	@include('templates.messages.toast_scripts')
@show
	</body>
</html>

