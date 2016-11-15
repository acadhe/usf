<?php
use Illuminate\Support\Facades\Session;
?>
@extends('templates.master')
@section('content')
@if (Session::has('email_sent'))
    {{Session::get('email_sent')}}
@endif
<section id="forgot-pass">
	<form method="post">
    {!! csrf_field() !!}
		<div class="container">
			<div class="row">
				<div class="col s12 m12 s12 valign-wrapper" id="wrapper-email">
					<div id="non-exist">
						<h4>Forgot your password? Please enter your email</h4>
						<p>We will send you an email with instructions on how to reset your password.</p>
						<input type="email" name="email" autofocus>
						<span>{{$errors->first('email')}}</span>
						<button class="wave-light btn-flat right" type="submit">Reset password</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
@endsection