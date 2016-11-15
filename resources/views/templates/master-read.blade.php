<?php
	use App\Models\Article;
	$route_name = Request::route()->getName();
?>
@extends('templates.master')
@section('head')
@parent
    <meta property="og:description" content="{{substr(strip_tags($article->content),0,200)}}"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
@endsection
@section('navbar')
	<nav class="nav-master">
	  <div class="nav-wrapper">
		<div class="container" id="wrapper-nav">

			@include('templates.mobile.header-read')

			<a href="{{route('home')}}" class="brand-logo hide-on-med-and-down">
				<img src="{{ asset('frontend/img/logo.svg') }}" alt="UCP Logo" class="ic svg-black">
			</a>
			<ul id="nav-mobile" class="right hide-on-med-and-down nav-read">
				@if(!Auth::guest())
					@can('create',new Article())
						<li>
							<a href="{{route('article.create')}}" class="menu">Write Topic</a>
						</li>
					@endcan
				  	@can('update',$article)
					<li>
						<a href="{{route('article.update',['article_id'=>$article->id])}}" class="menu">Edit Topic</a>
					</li>
					@endcan
					@can('close',$article)
					<li>
						<a href="#close-modal-topic" class="menu modal-trigger">Close Topic</a>
					</li>
					@endcan
					<li>
					  @include('templates.navbars.notification')
					</li>
				@endif
				<li>
					@if(!Auth::guest())
						<a class="dropdown-button menu" href="#" data-beloworigin="true" data-hover="true" data-activates="dropdown-profile">
							@if(Auth::user()->photo_url == '')
								<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="circle responsive-img profilep-img">
							@else
								<img src="{{Auth::user()->photo_url}}" alt="" class="circle responsive-img profilep-img">
							@endif
						</a>
						<!-- Dropdown Structure -->
						<ul id="dropdown-profile" class="dropdown-content">
						@can('create',new Article())
							<li><a href="{{route('article.mine')}}" class="menu">Your Topic</a></li>
						@endcan
							<li><a href="{{route('user.read',['user_id'=>Auth::user()->id])}}">Profile</a></li>
							<li class="valign-wrapper" id="read">
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
@endsection

@section('scripts')
@parent
	<script src="https://cdn.jsdelivr.net/jquery.goodshare.js/3.2.8/goodshare.min.js"></script>
	<script>
		$(document).ready(function(){
			$('.modal-trigger').leanModal();
		});
	</script>
@endsection
