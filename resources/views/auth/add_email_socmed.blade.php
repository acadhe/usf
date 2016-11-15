{{-- <?php
use Illuminate\Support\Facades\Session;
?> --}}
@extends('templates.master')
@section('content')
<section id="non-email">
	<div class="container">
		<div class="row">
			<div class="col s12 m12 l12 valign-wrapper" id="wrapper-email">
				<div class="hide" id="non-exist">
					<h4>Please write your email to complete the sign up process</h4>
					<form method="post" action="{{route('auth.add_socmed_email.post',['source'=>$source])}}">
						{!! csrf_field() !!}
						<input name="email" type="email" value="{{$email or ''}}" autofocus>
						<span>{{$errors->first('email')}}</span>
						<button class="wave-light btn-flat right" type="submit">Add Email</button>
					</form>
				</div>
				<div id="existed" class="">
					<div class="row">
						<div class="col s12 m12 l12">
							@if(isset($existingUser))
								<h4>Your email had registered as <span>{{$existingUser->name}}</span>. Click the following button if you want to integrate it, otherwise please write another email address.</h4>
								<form method="post" action="{{route('auth.integrate_socmed_email.post',['source'=>$source])}}">
									{!! csrf_field() !!}
									<button class="waves-effect waves-light btn signup" type="submit">Integrate My Account and Login</button>
								</form>
							@endif		
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection