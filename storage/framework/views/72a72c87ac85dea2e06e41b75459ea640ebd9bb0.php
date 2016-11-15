<?php $__env->startSection('content'); ?>

<section id="atas-about">
	<div class="valign-wrapper" id="bg-layer-about">
		<div class="container">
			<div class="row" id="heading-page">
				<h4 class="valign center">
					A home for urban enthusiasts to explore urban issues, discover ideas, and exchange perspectives.
				</h4>
				<?php if(Auth::guest()): ?>
					<a href="<?php echo e(route('auth.login')); ?>" class="waves-effect waves-light btn signup">Join the Community</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<section id="bawah-about">
	<div class="col s12 m12">
		<div class="wrapper-about">
			<p>Urban Community of Practice</p>
			<p>
				Urban Community of Practice (CoP) is a home for knowledge sharing between experts and people where everyone can express and respect each other’s thoughts about urban agenda. By providing library of ideas, CoP enables its member to empower and foster collaboration as well as strengthen collective efforts for urban change.
			</p>
			<p>
				Leaders, activists, academics, and enthusiastic individuals working across a range of different interests, and based in different places, are welcomed to network with one another. We encourage you to be part of the discussion and part of the solution. Together we can make <span class="bold">“Another city is possible!”</span>
			</p>
		</div>
	</div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>