<?php
	use App\Models\Article;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Request;
?>
@extends('templates.master')
@section('head')
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
	
	<link rel="stylesheet" href="{{asset('frontend/css/styles.css')}}">
	<link rel="stylesheet" media='screen and (min-width: 1020px) and (max-width: 1280px)' href="{{ asset('frontend/css/large-below-desktop.css') }}">
	<link rel="stylesheet" media='screen and (min-width: 601px) and (max-width: 992px)' href="{{ asset('frontend/css/medium.css') }}">
	<link rel="stylesheet" media='screen and (min-width: 320px) and (max-width: 600px)' href="{{ asset('frontend/css/small.css') }}">

	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="csrf_token" content="{{csrf_token()}}"/>
	<title>Urban Community of Practice 2016</title>
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
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="{{ asset('frontend/img/favicons/mstile-144x144.png') }}">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.css">
@endsection

@section('navbar')
	<nav class="nav-master" id="articles">
	  <div class="nav-wrapper">
		<div class="container" id="wrapper-nav">

			@include('templates.mobile.header-article')

			<div class="left hide-on-med-and-down" id="wrap-logo">
				<ul>
					<li>
						<a href="{{route('home')}}" class="brand-logo" id="write">
							<img src="{{ asset('frontend/img/logo.svg') }}" alt="UCP Logo" class="svg-black">
						</a>
					</li>
					<li class="valign-wrapper">
						<p>{{$article->privacy}}</p>
					</li>
				</ul>
			</div>
			<div class="right" id="nav-articles">
				@if(!Auth::guest())
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					{{--<li>--}}
						{{--<a id="save-article" class="waves-effect btn-flat">SAVE TOPIC</a>--}}
					{{--</li>--}}
					<li>
						<a class="waves-effect btn-flat right publish-btn draft-post">Save as Draft</a>
					</li>
					<li>
						<a href="#" class="dropdown-publish waves-effect btn-flat publish-post-submit">Publish</a>
						<div id="webui-popovers">
							<p>Ready to publlish?</p>
							<p>Add or change social media accounts (optional),<br>so your story reaches more people:</p>
							{{--{{Session::get('fb_share_url')}}--}}
							<?php $facebook_redirect_url = route('auth.facebook_redirect',['after_callback_url'=>route('user.sync_facebook_account',['user_id'=>Auth::user()->id]),'after_sync_account_url'=>Request::url()]); ?>
							@if(!Session::get('has_facebook'))
								<a class="waves-effect btn-flat fb" href="{{$facebook_redirect_url}}"><i class="fa fa-facebook-square" aria-hidden="true"></i>Connect to share on Facebook</a>
							@else
								<form action="#" class="chk-sosmed">
									<p>
										{{-- tolong konsultasi dulu kalo HTML ID buat tombol publish mau diubah--}}
										<input type="checkbox" id="fb">
										<label for="fb">Connect to share on Facebook</label>
									</p>
								</form>
							@endif
							{{--{{Session::get('twitter_share_url')}}--}}
							<?php $twitter_redirect_url = route('auth.redirect_twitter',['after_callback_url'=>route('user.sync_twitter_account',['user_id'=>Auth::user()->id]),'after_sync_account_url'=>Request::url()]); ?>
							@if(!Session::get('has_twitter'))
							<a class="waves-effect btn-flat tw" href="{{$twitter_redirect_url}}"><i class="fa fa-twitter" aria-hidden="true"></i>Connect to share on Twitter</a>
							@else
							<form action="#" class="chk-sosmed">
								<p>
									{{-- tolong konsultasi dulu kalo HTML ID buat tombol publish mau diubah--}}
									<input type="checkbox" id="tw">
									<label for="tw">Connect to share on Twitter</label>
								</p>
							</form>
							@endif
							<?php $gplus_redirect_url = route('auth.google_plus_redirect',['after_callback_url'=>route('user.sync_google_plus_account',['user_id'=>Auth::user()->id]),'after_sync_account_url'=>Request::url()]); ?>
							@if(!Session::get('has_google_plus'))
							<a class="waves-effect btn-flat gp" href="{{$gplus_redirect_url}}"><i class="fa fa-google" aria-hidden="true"></i>Connect to share on Google Plus</a>
							@else
							<form action="#" class="chk-sosmed">
								<p>
									{{-- tolong konsultasi dulu kalo HTML ID buat tombol publish mau diubah--}}
									<input type="checkbox" id="gp">
									<label for="gp">Connect to share on Google Plus</label>
								</p>
							</form>
							@endif

							<hr>
							{{-- tolong konsultasi dulu kalo HTML ID buat tombol publish mau diubah--}}
							{{-- soalnya ngefek ke submit form buat publish post --}}
							{{-- <a id="publish-post-submit" class="waves-effect btn-flat right publish-btn">PUBLISH TOPICS</a> --}}
						</div>
					</li>
					<a class="dropdown-button menu" data-beloworigin="true" data-hover="true" data-activates="dropdown-more">
						<i class="material-icons">more_horiz</i>
					</a>
					<ul id="dropdown-more" class="dropdown-content">
						<p>Action</p>
						<li>
							<a class="waves-effect waves-light modal-trigger" href="#ets">Edit Topic Status</a>
						</li>
						<li>
							<a class="waves-effect waves-light modal-trigger" href="#ct">Close Topic</a>
						</li>
						<li>
							<a class="modal-trigger" href="#del-top">Delete Topic</a>
						</li>
					</ul>
					<a href="#" class="dropdown-button menu" id="wrapper-profilep-img" data-beloworigin="true" data-hover="true" data-activates="dropdown-profile">
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
						<li class="valign-wrapper" id="article">
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
	  </div>
	</nav>

	<div id="ets" class="modal">
		<form action="{{route('article.change_privacy.post',['article_id'=>$article->id])}}" method="post">
			{!! csrf_field() !!}
			<div class="modal-content">
				<p>Topic Status</p>

					<p>
						<input class="with-gap" name="privacy" type="radio" id="publish" @if($article->privacy == \App\Models\Article::PRIVACY_PUBLISHED) checked @endif value="{{\App\Models\Article::PRIVACY_PUBLISHED}}"/>
						<label for="publish">Publish</label>
					</p>
					<p>
						<input class="with-gap" name="privacy" type="radio" id="unpublish" @if($article->privacy == \App\Models\Article::PRIVACY_DRAFT) checked @endif value="{{\App\Models\Article::PRIVACY_DRAFT}}"/>
						<label for="unpublish">Unpublished</label>
					</p>

				<p>
					The topic is published. People can view, share, and have a discusison on your topic.
				</p>
				<p class="hide">
					The topic is unpublished. People will no longer be able to view, share, and have a discussion on this topic.
				</p>
			</div>
			<div class="modal-footer">
				<button type="submit" class=" modal-action modal-close btn-flat">Change Topic Status</button>
				<a href="#!" class=" modal-action modal-close btn-flat">Cancel</a>
			</div>
		</form>
	</div>

	<div id="ct" class="modal">
		<div class="modal-content">
			<p>Do you want to close this topic?</p>
			<p>After this action people will no longer be able to view, share, and have a discussion on this topic. And don't forget to write summary for this topic.</p>
		</div>
		<div class="modal-footer">
			<form action="{{route('article.close.post',['article_id'=>$article->id,'next'=>route('article.update_summary',['article_id'=>$article->id])])}}" method="post">
				{!! csrf_field() !!}
				<a href="#!" class=" modal-action modal-close btn-flat">Cancel</a>
				<button type="submit" class=" modal-action modal-close btn-flat">Close Topic</button>
			</form>
		</div>
	</div>

	<div id="del-top" class="modal">
		<div class="modal-content">
			<p>Do you want to delete this topic?</p>
			<p>This action can’t be undone. <br>
			People will no longer be able to view, share, and have a discussion on this topic. All data about this topic also will be deleted.</p>
		</div>
		<div class="modal-footer">
			<form action="{{route('article.delete.post',['article_id'=>$article->id,'next'=>route('article.mine')])}}" method="post">
				{!! csrf_field() !!}
				<a href="#!" class=" modal-action modal-close btn-flat">Cancel</a>
				<button type="submit" class=" modal-action modal-close btn-flat">Delete Topic</button>
			</form>
		</div>
	</div>

@endsection

@section('scripts')
	<script type="text/javascript" src="{{asset('frontend/js/jquery-2.1.1.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('frontend/js/materialize.js')}}"></script>
	<script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
	<script type="text/javascript" src="{{asset('frontend/js/jquery.dirtyforms.min.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
	<script>
		$(document).ready(function() {
			$('a#publish-post').webuiPopover({
				url:'#webui-popover',
				style: 'padding',
			});
		});
		// $(document).delegate('.save-draft', 'click', function(){
		// 	$(this).data('id');
		// 	console.log('save draft');
		// });
		// $(document).delegate('.up-publish', 'click', function(){
		// 	$(this).data('id');
		// 	console.log('publish');
		// });
	</script>
	<script type="text/javascript" src="{{asset('frontend/js/main.js')}}"></script>
	@include('templates.messages.toast_scripts')
@endsection