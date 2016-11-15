<?php
	use App\Models\Article;
	use Illuminate\Support\Facades\Request;
	$route_name = Request::route()->getName();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php $__env->startSection('head'); ?>
			<meta name="csrf_token" content="<?php echo e(csrf_token()); ?>"/>
			<meta name="msapplication-TileColor" content="#da532c">
			<meta name="msapplication-TileImage" content="<?php echo e(asset('frontend/img/favicons/mstile-144x144.png')); ?>">
			<meta name="theme-color" content="#ffffff">
			<title>Urban Community of Practice 2016</title>
			<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
			<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">
			<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/slick.css')); ?>"/>

			
			<link rel="stylesheet" href="<?php echo e(asset('frontend/css/styles.css')); ?>">
			<link rel="stylesheet" media='screen and (min-width: 1020px) and (max-width: 1280px)' href="<?php echo e(asset('frontend/css/large-below-desktop.css')); ?>">
			<link rel="stylesheet" media='screen and (min-width: 601px) and (max-width: 992px)' href="<?php echo e(asset('frontend/css/medium.css')); ?>">
			<link rel="stylesheet" media='screen and (min-width: 320px) and (max-width: 600px)' href="<?php echo e(asset('frontend/css/small.css')); ?>">

			<link rel="apple-touch-icon" sizes="57x57" href="<?php echo e(asset('frontend/img/favicons/apple-touch-icon-57x57.png')); ?>">
			<link rel="apple-touch-icon" sizes="60x60" href="<?php echo e(asset('frontend/img/favicons/apple-touch-icon-60x60.png')); ?>">
			<link rel="apple-touch-icon" sizes="72x72" href="<?php echo e(asset('frontend/img/favicons/apple-touch-icon-72x72.png')); ?>">
			<link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('frontend/img/favicons/apple-touch-icon-76x76.png')); ?>">
			<link rel="apple-touch-icon" sizes="114x114" href="<?php echo e(asset('frontend/img/favicons/apple-touch-icon-114x114.png')); ?>">
			<link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(asset('frontend/img/favicons/apple-touch-icon-120x120.png')); ?>">
			<link rel="apple-touch-icon" sizes="144x144" href="<?php echo e(asset('frontend/img/favicons/apple-touch-icon-144x144.png')); ?>">
			<link rel="apple-touch-icon" sizes="152x152" href="<?php echo e(asset('frontend/img/favicons/apple-touch-icon-152x152.png')); ?>">
			<link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('frontend/img/favicons/apple-touch-icon-180x180.png')); ?>">
			<link rel="icon" type="image/png" href="<?php echo e(asset('frontend/img/favicons/favicon-32x32.png')); ?>" sizes="32x32">
			<link rel="icon" type="image/png" href="<?php echo e(asset('frontend/img/favicons/android-chrome-192x192.png')); ?>" sizes="192x192">
			<link rel="icon" type="image/png" href="<?php echo e(asset('frontend/img/favicons/favicon-96x96.png')); ?>" sizes="96x96">
			<link rel="icon" type="image/png" href="<?php echo e(asset('frontend/img/favicons/favicon-16x16.png')); ?>" sizes="16x16">
			<link rel="manifest" href="<?php echo e(asset('frontend/img/favicons/manifest.json')); ?>">
			<link rel="mask-icon" href="<?php echo e(asset('frontend/img/favicons/safari-pinned-tab.svg')); ?>" color="#ffd600">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			
			<?php echo $__env->make('templates.navbars.notification_head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo $__env->yieldSection(); ?>
	</head>
<body>
<?php $__env->startSection('navbar'); ?>
	<nav class="nav-master">
	  <div class="nav-wrapper">
		<div class="container" id="wrapper-nav">
			<a href="<?php echo e(route('home')); ?>" class="brand-logo left hide-on-med-and-down">
				<img src="<?php echo e(asset('frontend/img/logo.svg')); ?>" alt="UCP Logo">
			</a>
			<?php echo $__env->make('templates.mobile.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<ul id="nav-mobile" class="left hide-on-med-and-down">
				<li><a href="<?php echo e(url('about')); ?>" <?php if($route_name == 'home.about'): ?> class="menu active" <?php endif; ?> class="menu">About</a></li>
				<li><a href="<?php echo e(url('panelists')); ?>" <?php if($route_name == 'home.panelist'): ?> class="menu active" <?php endif; ?> class="menu">Panelist</a></li>
				<li><a href="<?php echo e(url('contact')); ?>" <?php if($route_name == 'home.contact'): ?> class="menu active" <?php endif; ?> class="menu">Contact Us</a></li>
				<li><a class="dropdown-nav" href="#!" class="dropdown-button menu" href="#" data-beloworigin="true" data-hover="true" data-activates="dd-nav"><i class="material-icons">keyboard_arrow_down</i></a></li>
			</ul>
			<ul id="dd-nav" class="dropdown-content">
				<?php /* <li><a href="<?php echo e(url('help')); ?>" <?php if($route_name == 'home.help'): ?> class="menu active" <?php endif; ?> class="menu">Help</a></li> */ ?>
				<li><a href="<?php echo e(url('tos')); ?>" <?php if($route_name == 'home.tos'): ?> class="menu active" <?php endif; ?> class="menu">Terms of Use</a></li>
				<li><a href="<?php echo e(url('privacy-policy')); ?>" <?php if($route_name == 'home.privacy-policy'): ?> class="menu active" <?php endif; ?> class="menu">Privacy Policy</a></li>
				<li><a href="<?php echo e(url('ucp-rules')); ?>" <?php if($route_name == 'home.rules'): ?> class="menu active" <?php endif; ?> class="menu">Rules</a></li>
			</ul>
			<ul id="nav-mobile" class="right hide-on-med-and-down">
				<?php if(!Auth::guest()): ?>
					<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('create',new Article())): ?>
						<li><a href="<?php echo e(route('article.create')); ?>" class="menu">Write Topic</a></li>
					<?php endif; ?>
					<li>
						<?php echo $__env->make('templates.navbars.notification',compact('navbar_notifications'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					</li>
				<?php endif; ?>
				<?php if(!Auth::guest()): ?>
					<a class="dropdown-button menu" href="#" data-beloworigin="true" data-hover="true" data-activates="dropdown-profile">
						<?php if(Auth::user()->photo_url == ''): ?>
							<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="" class="circle responsive-img profilep-img">
						<?php else: ?>
							<img src="<?php echo e(Auth::user()->photo_url); ?>" alt="" class="circle responsive-img profilep-img">
						<?php endif; ?>
					</a>
					<ul id="dropdown-profile" class="dropdown-content">
					<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('create',new Article())): ?>
						<li><a href="<?php echo e(route('article.mine')); ?>" class="menu">Your Topic</a></li>
					<?php endif; ?>
						<li><a href="<?php echo e(route('user.read',['user_id'=>Auth::user()->id])); ?>">Profile</a></li>
						<li class="valign-wrapper">
							<form method="post" action="<?php echo e(route('auth.logout.post')); ?>">
								<?php echo csrf_field(); ?>

								<button class="btn-flat" type="submit">Sign Out</button>
							</form>
						</li>
					</ul>
				<?php else: ?>
					<li>
						<a href="<?php echo e(route('auth.login')); ?>" class="sgnin menu">Sign In / Signup</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	  </div>
	</nav>
<?php echo $__env->yieldSection(); ?>
<?php /*<?php $__env->startSection('alert'); ?>*/ ?>
	<?php /*<?php if(isset($message_success)): ?>*/ ?>
	<?php /*<div class="container">*/ ?>
		<?php /*<div class="alert alert-success"><?php echo e($message_success); ?></div>*/ ?>
	<?php /*</div>*/ ?>
	<?php /*<?php endif; ?>*/ ?>
<?php /*<?php echo $__env->yieldSection(); ?>*/ ?>

<?php echo $__env->yieldContent('content'); ?>

<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript" src="<?php echo e(asset('frontend/js/jquery-2.1.1.min.js')); ?>"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
	<script type="text/javascript" src="<?php echo e(asset('frontend/js/jquery.dirtyforms.min.js')); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset('frontend/js/materialize.js')); ?>"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/classie/1.0.1/classie.min.js"></script>
	<script type="text/javascript" src="<?php echo e(asset('frontend/js/main.js')); ?>"></script>

	<?php /* script for notification in navbar */ ?>
	<?php if(!Auth::guest()): ?>
		<?php echo $__env->make('templates.navbars.notification_scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php endif; ?>

	<?php /* script for toast */ ?>
	<?php echo $__env->make('templates.messages.toast_scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldSection(); ?>
	</body>
</html>

