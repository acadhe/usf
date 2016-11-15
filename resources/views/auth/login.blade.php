<?php
use Illuminate\Support\Facades\Session;
?>
@extends('templates.master-login')

@section('content')
<section id="error-message">
	{!! $errors->first('message') !!}
</section>
<section id="error-message">
	{!! $errors->first('passwords') !!}
</section>
@if (Session::has('error_message'))
	<section id="error-message">
		<div class="card-panel">
			<div class="row valign-wrapper">
				<div class="col s2 m1 l1">
					<i class="material-icons">info_outline</i>
				</div>
				<div class="col s10 m11 l11">
					<p>
						{{Session::get('error_message')}}
					</p>
				</div>
			</div>
		</div>
	</section>
@endif
<section id="login" class="valign-wrapper">
	<div class="container valign" id="wrapper-login">
		<div class="row">
			<div class="col s12 m12">
				<a href="{{route('home')}}" class="logo-login">
					<img src="{{ asset('frontend/img/logo.svg') }}" alt="UCP Logo" class="svg-black">
				</a>
			</div>
			<div class="col s12 m12">
				<p id="head-login">Sign in Urban Communities of Practice to connect with that matter<br>for you the most</p>
			</div>
			<div class="col s12 m12">
				<a href="{{route('auth.facebook_redirect')}}" class="waves-effect waves-light btn" id="fb"><i class="fa fa-facebook-square" aria-hidden="true"></i><span>Continue with Facebook</span></a>
			</div>
			<div class="col s12 m12">
				<a href="{{route('auth.redirect_twitter')}}" class="waves-effect waves-light btn" id="twitter"><i class="fa fa-twitter" aria-hidden="true"></i><span>Continue with Twitter</span></a>
			</div>
			<div class="col s12 m12">
				<a href="{{route('auth.google_plus_redirect')}}" class="waves-effect waves-light btn" id="gmail"><img src="{{asset('frontend/img/google.png')}}" alt="" class="responsive-img"><span>Continue with Gmail</span></a>
			</div>
			<div class="col s12 m12" id="modal-sect">
				<a href="#signin" class="modal-trigger sign">Sign in</a>
				<span>or</span>
				<a href="#signup" class="modal-trigger sign">sign up</a>
				<span>with email</span>
				<div id="signin" class="modal">
					<form action="{{url('auth/login_basic')}}" method="post">
						{{csrf_field()}}
						<div class="modal-content">
							<h4>Sign In</h4>
							<span>{{$errors->first('message_email_inside')}}</span>
							<div class="row">
								<div class="input-field col s12 m12">
									<i class="material-icons prefix">email</i>
									<input id="icon_prefix" type="email" name="email" class="validate" placeholder="Put your email here" value="{{old('email')}}" required>
									<label for="email" data-error="wrong email input" data-success="right"></label>
								</div>
								<div class="input-field col s12 m12">
									<i class="material-icons prefix">create</i>
									<input type="password" name="password" placeholder="Your password" value="{{old('password')}}" required>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<div class="row">
								<div class="col s12 m6">
									<a href="{{route('auth.forgot_password')}}" class="btn-flat waves-effect" id="kiri">Forgot your password?</a>
								</div>
								<div class="col s12 m6">
									<button class="btn-flat" id="kanan" type="submit">Login</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div id="signup" class="modal">
					<form action="{{route('auth.register.post')}}" method="post">
						<div class="modal-content">
							<h4>Sign Up</h4>
							<div class="row">
								{{csrf_field()}}
								<div class="input-field col s12 m12">
									<i class="material-icons prefix">email</i>
									<input id="icon_prefix" type="email" name="email" class="validate" placeholder="Put your email here" value="{{old('email')}}" required>
									<span>{{$errors->first('email')}}</span>
								</div>
								<div class="input-field col s12 m12">
									<i class="material-icons prefix">account_circle</i>
									<input id="icon_prefix" type="text" name="name" class="validate" placeholder="Put your name here" value="{{old('name')}}" required>
									<span>{{$errors->first('name')}}</span>
								</div>
								<div class="input-field col s12 m12">
									<i class="material-icons prefix">create</i>
									<input id="password" type="password" name="password" class="validate" placeholder="Your password" value="{{old('password')}}" required>
									<span>{{$errors->first('password')}}</span>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn-flat waves-effect waves-light" type="submit">Sign Up</button>
						</div>
					</form>
				</div>
				<p class="center loa">
					By using UCP or signing up for an account, you're agreeing to our <a href="{{route('home.tos')}}">Terms of Use</a> and <a href="{{route('home.privacy-policy')}}">Privacy Policy</a><br>If you’re connected using Facebook, Twitter, or Google Plus, <br> we won’t upload any files without your permissions.
				</p>
			</div>
		</div>
	</div>
</section>
@endsection

@section('scripts')
@parent
	{{-- google plus login requirements--}}
	{{--<script src="https://apis.google.com/js/client:platform.js"></script>--}}
	{{--<script>--}}
		{{--var auth2;--}}
		{{--gapi.load('auth2', function() {--}}
			{{--auth2 = gapi.auth2.init({--}}
				{{--client_id: '{{config('auth.google_plus.client_id')}}'--}}
			{{--});--}}
		{{--});--}}
		{{--$('#gmail').click(function() {--}}
			{{--// signInCallback defined in step 6.--}}
			{{--auth2.grantAccess({'redirect_uri': '{{url(route('auth.google_plus_callback.post'))}}'}).then(signInCallback);--}}
		{{--});--}}
		{{--function signInCallback(authResult) {--}}
			{{--console.log(authResult);--}}
			{{--if (authResult['code']) {--}}
				{{--console.log(authResult['code']);--}}
				{{--$("#gmail_token").val(authResult['code']);--}}
				{{--$("#gmail_token_form").submit();--}}
			{{--} else {--}}
				{{--// There was an error.--}}
			{{--}--}}
		{{--}--}}
	{{--</script>--}}
@endsection
