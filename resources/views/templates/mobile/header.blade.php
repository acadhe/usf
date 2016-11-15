<?php
	use App\Models\Article;
	use Illuminate\Support\Facades\Request;
	$route_name = Request::route()->getName();
?>
	<div class="mobile-ui show-on-medium-and-down hide-on-large-only">
		<div class="valign-wrapper">
			<a href="#" data-activates="mobile-demo" class="button-collapse">
				<i class="material-icons">menu</i>
			</a>
			<ul class="side-nav" id="mobile-demo">
				<li><a href="{{url('about')}}" @if($route_name == 'home.about') class="menu active" @endif class="menu">About</a></li>
				<li><a href="{{url('panelists')}}" @if($route_name == 'home.panelist') class="menu active" @endif class="menu">Panelist</a></li>
				<li><a href="{{url('contact')}}" @if($route_name == 'home.contact') class="menu active" @endif class="menu">Contact Us</a></li>
				<li><a href="{{url('tos')}}" @if($route_name == 'home.tos') class="menu active" @endif class="menu">Terms of Use</a></li>
				<li><a href="{{url('privacy-policy')}}" @if($route_name == 'home.privacy-policy') class="menu active" @endif class="menu">Privacy Policy</a></li>
				<li><a href="{{url('ucp-rules')}}" @if($route_name == 'home.rules') class="menu active" @endif class="menu">Rules</a></li>
			</ul>
			<a href="{{route('home')}}" class="brand-logo left">
				<img src="{{ asset('frontend/img/logo.svg') }}" alt="UCP Logo">
			</a>
			<div id="nav-mobile" class="valign-wrapper">
				@if(!Auth::guest())
					<ul class="right" id="sign-mobile">
						<li>
							<a class="button-collapse valign-wrapper" href="#" data-activates="mobile-profile-menu" id="mobile-prof-sidemenu">
								@if(Auth::user()->photo_url == '')
									<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="circle responsive-img profilep-img">
								@else
									<img src="{{Auth::user()->photo_url}}" alt="" class="circle responsive-img profilep-img">
								@endif
							</a>
						</li>
						@include('templates.navbars.notification',compact('navbar_notifications'))
						@can('create',new Article())
							<li>
								<a href="{{route('article.create')}}" class="menu valign-wrapper">
									<i class="material-icons">mode_edit</i>
								</a>
							</li>
						@endcan
						<ul class="side-nav" id="mobile-profile-menu">
							@can('create',new Article())
								<li><a href="{{route('article.mine')}}" class="menu">Your Topic</a></li>
							@endcan
							<li><a href="{{route('user.read',['user_id'=>Auth::user()->id])}}">Profile</a></li>
							<li class="valign-wrapper">
								<form method="post" action="{{route('auth.logout.post')}}" id="logout">
									{!! csrf_field() !!}
									<button class="btn-flat" type="submit">Sign Out</button>
								</form>
							</li>
						</ul>
					</ul>
				@else
					<ul id="sign-mobile" class="right show-on-medium-and-down hide-on-large-only">
						<li>
							<a href="{{route('auth.login')}}" class="valign-wrapper">
								<i class="material-icons">person</i>
							</a>
						</li>
					</ul>
				@endif
			</div>
		</div>
	</div>