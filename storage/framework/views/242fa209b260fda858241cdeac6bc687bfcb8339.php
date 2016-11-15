<?php
use Illuminate\Support\Facades\Session;
?>


<?php $__env->startSection('content'); ?>
<section id="error-message">
	<?php echo $errors->first('message'); ?>

</section>
<section id="error-message">
	<?php echo $errors->first('passwords'); ?>

</section>
<?php if(Session::has('error_message')): ?>
	<section id="error-message">
		<div class="card-panel">
			<div class="row valign-wrapper">
				<div class="col s2 m1 l1">
					<i class="material-icons">info_outline</i>
				</div>
				<div class="col s10 m11 l11">
					<p>
						<?php echo e(Session::get('error_message')); ?>

					</p>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
<section id="login" class="valign-wrapper">
	<div class="container valign" id="wrapper-login">
		<div class="row">
			<div class="col s12 m12">
				<a href="<?php echo e(route('home')); ?>" class="logo-login">
					<img src="<?php echo e(asset('frontend/img/logo.svg')); ?>" alt="UCP Logo" class="svg-black">
				</a>
			</div>
			<div class="col s12 m12">
				<p id="head-login">Sign in Urban Communities of Practice to connect with that matter<br>for you the most</p>
			</div>
			<div class="col s12 m12">
				<a href="<?php echo e(route('auth.facebook_redirect')); ?>" class="waves-effect waves-light btn" id="fb"><i class="fa fa-facebook-square" aria-hidden="true"></i><span>Continue with Facebook</span></a>
			</div>
			<div class="col s12 m12">
				<a href="<?php echo e(route('auth.redirect_twitter')); ?>" class="waves-effect waves-light btn" id="twitter"><i class="fa fa-twitter" aria-hidden="true"></i><span>Continue with Twitter</span></a>
			</div>
			<div class="col s12 m12">
				<a href="<?php echo e(route('auth.google_plus_redirect')); ?>" class="waves-effect waves-light btn" id="gmail"><img src="<?php echo e(asset('frontend/img/google.png')); ?>" alt="" class="responsive-img"><span>Continue with Gmail</span></a>
			</div>
			<div class="col s12 m12" id="modal-sect">
				<a href="#signin" class="modal-trigger sign">Sign in</a>
				<span>or</span>
				<a href="#signup" class="modal-trigger sign">sign up</a>
				<span>with email</span>
				<div id="signin" class="modal">
					<form action="<?php echo e(url('auth/login_basic')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="modal-content">
							<h4>Sign In</h4>
							<span><?php echo e($errors->first('message_email_inside')); ?></span>
							<div class="row">
								<div class="input-field col s12 m12">
									<i class="material-icons prefix">email</i>
									<input id="icon_prefix" type="email" name="email" class="validate" placeholder="Put your email here" value="<?php echo e(old('email')); ?>" required>
									<label for="email" data-error="wrong email input" data-success="right"></label>
								</div>
								<div class="input-field col s12 m12">
									<i class="material-icons prefix">create</i>
									<input type="password" name="password" placeholder="Your password" value="<?php echo e(old('password')); ?>" required>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<div class="row">
								<div class="col s12 m6">
									<a href="<?php echo e(route('auth.forgot_password')); ?>" class="btn-flat waves-effect" id="kiri">Forgot your password?</a>
								</div>
								<div class="col s12 m6">
									<button class="btn-flat" id="kanan" type="submit">Login</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div id="signup" class="modal">
					<form action="<?php echo e(route('auth.register.post')); ?>" method="post">
						<div class="modal-content">
							<h4>Sign Up</h4>
							<div class="row">
								<?php echo e(csrf_field()); ?>

								<div class="input-field col s12 m12">
									<i class="material-icons prefix">email</i>
									<input id="icon_prefix" type="email" name="email" class="validate" placeholder="Put your email here" value="<?php echo e(old('email')); ?>" required>
									<span><?php echo e($errors->first('email')); ?></span>
								</div>
								<div class="input-field col s12 m12">
									<i class="material-icons prefix">account_circle</i>
									<input id="icon_prefix" type="text" name="name" class="validate" placeholder="Put your name here" value="<?php echo e(old('name')); ?>" required>
									<span><?php echo e($errors->first('name')); ?></span>
								</div>
								<div class="input-field col s12 m12">
									<i class="material-icons prefix">create</i>
									<input id="password" type="password" name="password" class="validate" placeholder="Your password" value="<?php echo e(old('password')); ?>" required>
									<span><?php echo e($errors->first('password')); ?></span>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn-flat waves-effect waves-light" type="submit">Sign Up</button>
						</div>
					</form>
				</div>
				<p class="center loa">
					By using UCP or signing up for an account, you're agreeing to our <a href="<?php echo e(route('home.tos')); ?>">Terms of Use</a> and <a href="<?php echo e(route('home.privacy-policy')); ?>">Privacy Policy</a><br>If you’re connected using Facebook, Twitter, or Google Plus, <br> we won’t upload any files without your permissions.
				</p>
			</div>
		</div>
	</div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
@parent
	<?php /* google plus login requirements*/ ?>
	<?php /*<script src="https://apis.google.com/js/client:platform.js"></script>*/ ?>
	<?php /*<script>*/ ?>
		<?php /*var auth2;*/ ?>
		<?php /*gapi.load('auth2', function() {*/ ?>
			<?php /*auth2 = gapi.auth2.init({*/ ?>
				<?php /*client_id: '<?php echo e(config('auth.google_plus.client_id')); ?>'*/ ?>
			<?php /*});*/ ?>
		<?php /*});*/ ?>
		<?php /*$('#gmail').click(function() {*/ ?>
			<?php /*// signInCallback defined in step 6.*/ ?>
			<?php /*auth2.grantAccess({'redirect_uri': '<?php echo e(url(route('auth.google_plus_callback.post'))); ?>'}).then(signInCallback);*/ ?>
		<?php /*});*/ ?>
		<?php /*function signInCallback(authResult) {*/ ?>
			<?php /*console.log(authResult);*/ ?>
			<?php /*if (authResult['code']) {*/ ?>
				<?php /*console.log(authResult['code']);*/ ?>
				<?php /*$("#gmail_token").val(authResult['code']);*/ ?>
				<?php /*$("#gmail_token_form").submit();*/ ?>
			<?php /*} else {*/ ?>
				<?php /*// There was an error.*/ ?>
			<?php /*}*/ ?>
		<?php /*}*/ ?>
	<?php /*</script>*/ ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.master-login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>