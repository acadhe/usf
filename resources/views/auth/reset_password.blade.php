@extends('templates.master')
@section('content')
<section id="forgot-pass">
	@if ($invalid_token)
		<h4>
			Your reset password link had expired, or this is an invalid reset password link. Please request another reset password <a href="{{route('auth.forgot_password')}}" class="btn-flat waves-effect">here</a>.
		</h4>
	@else
		<form method="post">
		{!! csrf_field() !!}
			<div class="container">
				<div class="row">
					<div class="col s12 m12 l12 valign-wrapper" id="wrapper-email">
						<div id="non-exist">
							<h4>Please enter your new password.</h4>
							<p>Your email: {{$user->email}}</p>
							<input name="password" type="password"/>
							<span>{{$errors->first('password')}}</span>
							<button type="submit">Save and login</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	@endif
</section>
@endsection