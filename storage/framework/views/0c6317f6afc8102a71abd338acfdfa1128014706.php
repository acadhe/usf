{{-- <?php
use Illuminate\Support\Facades\Session;
?> --}}

<?php $__env->startSection('content'); ?>
<section id="non-email">
	<div class="container">
		<div class="row">
			<div class="col m12 valign-wrapper" id="wrapper-email">
				<div class="hide" id="non-exist">
					<h4>Please write your email to complete the sign up process</h4>
					<form method="post" action="<?php echo e(route('auth.add_socmed_email.post',['source'=>$source])); ?>">
						<?php echo csrf_field(); ?>

						<input name="email" type="email" value="<?php echo e(isset($email) ? $email : ''); ?>" autofocus>
						<span><?php echo e($errors->first('email')); ?></span>
						<button class="wave-light btn-flat right" type="submit">Add Email</button>
					</form>
				</div>
				<div id="existed" class="">
					<div class="row">
						<div class="col m12">
							<?php if(isset($existingUser)): ?>
								<h4>Your email had registered as <span><?php echo e($existingUser->name); ?></span>. Click the following button if you want to integrate it, otherwise please write another email address.</h4>
								<form method="post" action="<?php echo e(route('auth.integrate_socmed_email.post',['source'=>$source])); ?>">
									<?php echo csrf_field(); ?>

									<button class="waves-effect waves-light btn signup" type="submit">Integrate My Account and Login</button>
								</form>
							<?php endif; ?>		
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>