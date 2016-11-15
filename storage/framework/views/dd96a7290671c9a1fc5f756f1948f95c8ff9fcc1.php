<?php
use Illuminate\Support\Facades\Session;
?>

<?php $__env->startSection('content'); ?>
<?php if(Session::has('email_sent')): ?>
    <?php echo e(Session::get('email_sent')); ?>

<?php endif; ?>
<section id="forgot-pass">
	<form method="post">
    <?php echo csrf_field(); ?>

		<div class="container">
			<div class="row">
				<div class="col m12 valign-wrapper" id="wrapper-email">
					<div id="non-exist">
						<h4>Forgot your password? Please enter your email</h4>
						<p>We will send you an email with instructions on how to reset your password.</p>
						<input type="email" name="email" autofocus>
						<span><?php echo e($errors->first('email')); ?></span>
						<button class="wave-light btn-flat right" type="submit">Reset password</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>