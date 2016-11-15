@extends('templates.master')
<?php
	use App\Models\Article;
?>
@section('navbar')
	<nav class="nav-master" id="nav-prof">
		<div class="nav-wrapper">
			<div class="container" id="wrapper-nav">
				<a href="{{route('home')}}" class="brand-logo hide-on-med-and-down">
					<img src="{{ asset('frontend/img/logo.svg') }}" alt="UCP Logo" class="svg-black">
				</a>
				@include('templates.mobile.header-profile')
				
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					@can('create',new Article())
						<li><a href="{{route('article.mine')}}" class="menu">Your topics</a></li>
						<li><a href="{{route('article.create')}}" class="menu">Write topic</a></li>
					@endcan
					<li>
						@if(!Auth::guest())
							<!-- Dropdown Trigger -->
							<a class="dropdown-button menu" id="wrapper-profilep-img" href="#" data-beloworigin="true" data-hover="false" data-activates="dropdown-profile">
								@if(Auth::user()->photo_url == '')
									<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="circle responsive-img profilep-img">
								@else
									<img src="{{Auth::user()->photo_url}}" alt="" class="circle responsive-img profilep-img">
								@endif
							</a>
							<!-- Dropdown Structure -->
							<ul id="dropdown-profile" class="dropdown-content">
								<li class="valign-wrapper" id="profile">
									<form method="post" action="{{route('auth.logout.post')}}">
										{!! csrf_field() !!}
										<button class="btn-flat" type="submit">Sign Out</button>
									</form>
								</li>
							</ul>
						@else
							<a href="{{route('auth.login')}}" class="sgnin menu">Sign In / Signup</a>
						@endif
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<nav class="nav-subnav hide-on-med-and-down">
		<div class="nav-wrapper">
			<div class="container" id="wrapper-nav">
				@include('users.read.navigation',['user'=>$user,'tab'=>$tab])
			</div>
		</div>
	</nav>
@endsection

@section('scripts')
@parent
	<script type="text/javascript">
		$('#card-user #aside').pushpin({ top: $('#card-user').offset().top });
	</script>
@endsection