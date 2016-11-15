<?php
	use App\Models\Article;
	use Illuminate\Support\Facades\Request;
	$route_name = Request::route()->getName();
?>
	<div class="mobile-ui show-on-medium-and-down hide-on-large-only">
		<div class="valign-wrapper">
			<a href="#" data-activates="mobile-demo" class="button-collapse">
				<i class="material-icons">menu</i>
			</a>
			<ul class="side-nav" id="mobile-demo">
				<li><a href="<?php echo e(url('about')); ?>" <?php if($route_name == 'home.about'): ?> class="menu active" <?php endif; ?> class="menu">About</a></li>
				<li><a href="<?php echo e(url('panelists')); ?>" <?php if($route_name == 'home.panelist'): ?> class="menu active" <?php endif; ?> class="menu">Panelist</a></li>
				<li><a href="<?php echo e(url('contact')); ?>" <?php if($route_name == 'home.contact'): ?> class="menu active" <?php endif; ?> class="menu">Contact Us</a></li>
				<li><a href="<?php echo e(url('tos')); ?>" <?php if($route_name == 'home.tos'): ?> class="menu active" <?php endif; ?> class="menu">Terms of Use</a></li>
				<li><a href="<?php echo e(url('privacy-policy')); ?>" <?php if($route_name == 'home.privacy-policy'): ?> class="menu active" <?php endif; ?> class="menu">Privacy Policy</a></li>
				<li><a href="<?php echo e(url('ucp-rules')); ?>" <?php if($route_name == 'home.rules'): ?> class="menu active" <?php endif; ?> class="menu">Rules</a></li>
			</ul>
			<a href="<?php echo e(route('home')); ?>" class="brand-logo left">
				<img src="<?php echo e(asset('frontend/img/logo.svg')); ?>" alt="UCP Logo">
			</a>
			<div id="nav-mobile" class="valign-wrapper">
				<?php if(!Auth::guest()): ?>
					<ul class="right" id="sign-mobile">
						<li>
							<a class="button-collapse valign-wrapper" href="#" data-activates="mobile-profile-menu" id="mobile-prof-sidemenu">
								<?php if(Auth::user()->photo_url == ''): ?>
									<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="" class="circle responsive-img profilep-img">
								<?php else: ?>
									<img src="<?php echo e(Auth::user()->photo_url); ?>" alt="" class="circle responsive-img profilep-img">
								<?php endif; ?>
							</a>
						</li>
						<?php echo $__env->make('templates.navbars.notification',compact('navbar_notifications'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('create',new Article())): ?>
							<li>
								<a href="<?php echo e(route('article.create')); ?>" class="menu valign-wrapper">
									<i class="material-icons">mode_edit</i>
								</a>
							</li>
						<?php endif; ?>
						<ul class="side-nav" id="mobile-profile-menu">
							<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('create',new Article())): ?>
								<li><a href="<?php echo e(route('article.mine')); ?>" class="menu">Your Topic</a></li>
							<?php endif; ?>
							<li><a href="<?php echo e(route('user.read',['user_id'=>Auth::user()->id])); ?>">Profile</a></li>
							<li class="valign-wrapper">
								<form method="post" action="<?php echo e(route('auth.logout.post')); ?>" id="logout">
									<?php echo csrf_field(); ?>

									<button class="btn-flat" type="submit">Sign Out</button>
								</form>
							</li>
						</ul>
					</ul>
				<?php else: ?>
					<ul id="sign-mobile" class="right show-on-medium-and-down hide-on-large-only">
						<li>
							<a href="<?php echo e(route('auth.login')); ?>" class="valign-wrapper">
								<i class="material-icons">person</i>
							</a>
						</li>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>