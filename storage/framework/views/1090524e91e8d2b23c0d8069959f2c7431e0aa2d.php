<?php
	use App\Models\Article;
?>
<?php $__env->startSection('navbar'); ?>
	<nav class="nav-master" id="nav-prof">
		<div class="nav-wrapper">
			<div class="container" id="wrapper-nav">
				<a href="<?php echo e(route('home')); ?>" class="brand-logo hide-on-med-and-down">
					<img src="<?php echo e(asset('frontend/img/logo.svg')); ?>" alt="UCP Logo" class="svg-black">
				</a>
				<?php echo $__env->make('templates.mobile.header-profile', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('create',new Article())): ?>
						<li><a href="<?php echo e(route('article.mine')); ?>" class="menu">Your topics</a></li>
						<li><a href="<?php echo e(route('article.create')); ?>" class="menu">Write topic</a></li>
					<?php endif; ?>
					<li>
						<?php if(!Auth::guest()): ?>
							<!-- Dropdown Trigger -->
							<a class="dropdown-button menu" id="wrapper-profilep-img" href="#" data-beloworigin="true" data-hover="false" data-activates="dropdown-profile">
								<?php if(Auth::user()->photo_url == ''): ?>
									<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="" class="circle responsive-img profilep-img">
								<?php else: ?>
									<img src="<?php echo e(Auth::user()->photo_url); ?>" alt="" class="circle responsive-img profilep-img">
								<?php endif; ?>
							</a>
							<!-- Dropdown Structure -->
							<ul id="dropdown-profile" class="dropdown-content">
								<li class="valign-wrapper" id="profile">
									<form method="post" action="<?php echo e(route('auth.logout.post')); ?>">
										<?php echo csrf_field(); ?>

										<button class="btn-flat" type="submit">Sign Out</button>
									</form>
								</li>
							</ul>
						<?php else: ?>
							<a href="<?php echo e(route('auth.login')); ?>" class="sgnin menu">Sign In / Signup</a>
						<?php endif; ?>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<nav class="nav-subnav hide-on-med-and-down">
		<div class="nav-wrapper">
			<div class="container" id="wrapper-nav">
				<?php echo $__env->make('users.read.navigation',['user'=>$user,'tab'=>$tab], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			</div>
		</div>
	</nav>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
@parent
	<script type="text/javascript">
		$('#card-user #aside').pushpin({ top: $('#card-user').offset().top });
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>