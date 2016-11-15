<?php
	use App\Models\Article;
	$route_name = Request::route()->getName();
?>

<?php $__env->startSection('head'); ?>
@parent
    <meta property="og:description" content="<?php echo e(substr(strip_tags($article->content),0,200)); ?>"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('navbar'); ?>
	<nav class="nav-master">
	  <div class="nav-wrapper">
		<div class="container" id="wrapper-nav">

			<?php echo $__env->make('templates.mobile.header-read', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

			<a href="<?php echo e(route('home')); ?>" class="brand-logo hide-on-med-and-down">
				<img src="<?php echo e(asset('frontend/img/logo.svg')); ?>" alt="UCP Logo" class="ic svg-black">
			</a>
			<ul id="nav-mobile" class="right hide-on-med-and-down nav-read">
				<?php if(!Auth::guest()): ?>
					<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('create',new Article())): ?>
						<li>
							<a href="<?php echo e(route('article.create')); ?>" class="menu">Write Topic</a>
						</li>
					<?php endif; ?>
				  	<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('update',$article)): ?>
					<li>
						<a href="<?php echo e(route('article.update',['article_id'=>$article->id])); ?>" class="menu">Edit Topic</a>
					</li>
					<?php endif; ?>
					<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('close',$article)): ?>
					<li>
						<a href="#close-modal-topic" class="menu modal-trigger">Close Topic</a>
					</li>
					<?php endif; ?>
					<li>
					  <?php echo $__env->make('templates.navbars.notification', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					</li>
				<?php endif; ?>
				<li>
					<?php if(!Auth::guest()): ?>
						<a class="dropdown-button menu" href="#" data-beloworigin="true" data-hover="true" data-activates="dropdown-profile">
							<?php if(Auth::user()->photo_url == ''): ?>
								<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="" class="circle responsive-img profilep-img">
							<?php else: ?>
								<img src="<?php echo e(Auth::user()->photo_url); ?>" alt="" class="circle responsive-img profilep-img">
							<?php endif; ?>
						</a>
						<!-- Dropdown Structure -->
						<ul id="dropdown-profile" class="dropdown-content">
						<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('create',new Article())): ?>
							<li><a href="<?php echo e(route('article.mine')); ?>" class="menu">Your Topic</a></li>
						<?php endif; ?>
							<li><a href="<?php echo e(route('user.read',['user_id'=>Auth::user()->id])); ?>">Profile</a></li>
							<li class="valign-wrapper" id="read">
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
@parent
	<script src="https://cdn.jsdelivr.net/jquery.goodshare.js/3.2.8/goodshare.min.js"></script>
	<script>
		$(document).ready(function(){
			$('.modal-trigger').leanModal();
		});
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>