<?php
	use App\Models\Article;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Request;
?>

<?php $__env->startSection('head'); ?>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
	
	<link rel="stylesheet" href="<?php echo e(asset('frontend/css/styles.css')); ?>">
	<link rel="stylesheet" media='screen and (min-width: 1020px) and (max-width: 1280px)' href="<?php echo e(asset('frontend/css/large-below-desktop.css')); ?>">
	<link rel="stylesheet" media='screen and (min-width: 601px) and (max-width: 992px)' href="<?php echo e(asset('frontend/css/medium.css')); ?>">
	<link rel="stylesheet" media='screen and (min-width: 320px) and (max-width: 600px)' href="<?php echo e(asset('frontend/css/small.css')); ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="csrf_token" content="<?php echo e(csrf_token()); ?>"/>
	<title>Urban Community of Practice 2016</title>
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
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="<?php echo e(asset('frontend/img/favicons/mstile-144x144.png')); ?>">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('navbar'); ?>
	<nav class="nav-master" id="articles">
	  <div class="nav-wrapper">
		<div class="container" id="wrapper-nav">

			<?php echo $__env->make('templates.mobile.header-article', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

			<div class="left hide-on-med-and-down" id="wrap-logo">
				<ul>
					<li>
						<a href="<?php echo e(route('home')); ?>" class="brand-logo" id="write">
							<img src="<?php echo e(asset('frontend/img/logo.svg')); ?>" alt="UCP Logo" class="svg-black">
						</a>
					</li>
					<li class="valign-wrapper">
						<p><?php echo e($article->privacy); ?></p>
					</li>
				</ul>
			</div>
			<div class="right" id="nav-articles">
				<?php if(!Auth::guest()): ?>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<?php /*<li>*/ ?>
						<?php /*<a id="save-article" class="waves-effect btn-flat">SAVE TOPIC</a>*/ ?>
					<?php /*</li>*/ ?>
					<li>
						<a class="waves-effect btn-flat right publish-btn draft-post">Save as Draft</a>
					</li>
					<li>
						<a href="#" class="dropdown-publish waves-effect btn-flat publish-post-submit">Publish</a>
						<div id="webui-popovers">
							<p>Ready to publlish?</p>
							<p>Add or change social media accounts (optional),<br>so your story reaches more people:</p>
							<?php /*<?php echo e(Session::get('fb_share_url')); ?>*/ ?>
							<?php $facebook_redirect_url = route('auth.facebook_redirect',['after_callback_url'=>route('user.sync_facebook_account',['user_id'=>Auth::user()->id]),'after_sync_account_url'=>Request::url()]); ?>
							<?php if(!Session::get('has_facebook')): ?>
								<a class="waves-effect btn-flat fb" href="<?php echo e($facebook_redirect_url); ?>"><i class="fa fa-facebook-square" aria-hidden="true"></i>Connect to share on Facebook</a>
							<?php else: ?>
								<form action="#" class="chk-sosmed">
									<p>
										<?php /* tolong konsultasi dulu kalo HTML ID buat tombol publish mau diubah*/ ?>
										<input type="checkbox" id="fb">
										<label for="fb">Connect to share on Facebook</label>
									</p>
								</form>
							<?php endif; ?>
							<?php /*<?php echo e(Session::get('twitter_share_url')); ?>*/ ?>
							<?php $twitter_redirect_url = route('auth.redirect_twitter',['after_callback_url'=>route('user.sync_twitter_account',['user_id'=>Auth::user()->id]),'after_sync_account_url'=>Request::url()]); ?>
							<?php if(!Session::get('has_twitter')): ?>
							<a class="waves-effect btn-flat tw" href="<?php echo e($twitter_redirect_url); ?>"><i class="fa fa-twitter" aria-hidden="true"></i>Connect to share on Twitter</a>
							<?php else: ?>
							<form action="#" class="chk-sosmed">
								<p>
									<?php /* tolong konsultasi dulu kalo HTML ID buat tombol publish mau diubah*/ ?>
									<input type="checkbox" id="tw">
									<label for="tw">Connect to share on Twitter</label>
								</p>
							</form>
							<?php endif; ?>
							<?php $gplus_redirect_url = route('auth.google_plus_redirect',['after_callback_url'=>route('user.sync_google_plus_account',['user_id'=>Auth::user()->id]),'after_sync_account_url'=>Request::url()]); ?>
							<?php if(!Session::get('has_google_plus')): ?>
							<a class="waves-effect btn-flat gp" href="<?php echo e($gplus_redirect_url); ?>"><i class="fa fa-google" aria-hidden="true"></i>Connect to share on Google Plus</a>
							<?php else: ?>
							<form action="#" class="chk-sosmed">
								<p>
									<?php /* tolong konsultasi dulu kalo HTML ID buat tombol publish mau diubah*/ ?>
									<input type="checkbox" id="gp">
									<label for="gp">Connect to share on Google Plus</label>
								</p>
							</form>
							<?php endif; ?>

							<hr>
							<?php /* tolong konsultasi dulu kalo HTML ID buat tombol publish mau diubah*/ ?>
							<?php /* soalnya ngefek ke submit form buat publish post */ ?>
							<?php /* <a id="publish-post-submit" class="waves-effect btn-flat right publish-btn">PUBLISH TOPICS</a> */ ?>
						</div>
					</li>
					<a class="dropdown-button menu" data-beloworigin="true" data-hover="true" data-activates="dropdown-more">
						<i class="material-icons">more_horiz</i>
					</a>
					<ul id="dropdown-more" class="dropdown-content">
						<p>Action</p>
						<li>
							<a class="waves-effect waves-light modal-trigger" href="#ets">Edit Topic Status</a>
						</li>
						<li>
							<a class="waves-effect waves-light modal-trigger" href="#ct">Close Topic</a>
						</li>
						<li>
							<a class="modal-trigger" href="#del-top">Delete Topic</a>
						</li>
					</ul>
					<a href="#" class="dropdown-button menu" id="wrapper-profilep-img" data-beloworigin="true" data-hover="true" data-activates="dropdown-profile">
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
						<li class="valign-wrapper" id="article">
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
	  </div>
	</nav>

	<div id="ets" class="modal">
		<form action="<?php echo e(route('article.change_privacy.post',['article_id'=>$article->id])); ?>" method="post">
			<?php echo csrf_field(); ?>

			<div class="modal-content">
				<p>Topic Status</p>

					<p>
						<input class="with-gap" name="privacy" type="radio" id="publish" <?php if($article->privacy == \App\Models\Article::PRIVACY_PUBLISHED): ?> checked <?php endif; ?> value="<?php echo e(\App\Models\Article::PRIVACY_PUBLISHED); ?>"/>
						<label for="publish">Publish</label>
					</p>
					<p>
						<input class="with-gap" name="privacy" type="radio" id="unpublish" <?php if($article->privacy == \App\Models\Article::PRIVACY_DRAFT): ?> checked <?php endif; ?> value="<?php echo e(\App\Models\Article::PRIVACY_DRAFT); ?>"/>
						<label for="unpublish">Unpublished</label>
					</p>

				<p>
					The topic is published. People can view, share, and have a discusison on your topic.
				</p>
				<p class="hide">
					The topic is unpublished. People will no longer be able to view, share, and have a discussion on this topic.
				</p>
			</div>
			<div class="modal-footer">
				<button type="submit" class=" modal-action modal-close btn-flat">Change Topic Status</button>
				<a href="#!" class=" modal-action modal-close btn-flat">Cancel</a>
			</div>
		</form>
	</div>

	<div id="ct" class="modal">
		<div class="modal-content">
			<p>Do you want to close this topic?</p>
			<p>After this action people will no longer be able to view, share, and have a discussion on this topic. And don't forget to write summary for this topic.</p>
		</div>
		<div class="modal-footer">
			<form action="<?php echo e(route('article.close.post',['article_id'=>$article->id,'next'=>route('article.update_summary',['article_id'=>$article->id])])); ?>" method="post">
				<?php echo csrf_field(); ?>

				<a href="#!" class=" modal-action modal-close btn-flat">Cancel</a>
				<button type="submit" class=" modal-action modal-close btn-flat">Close Topic</button>
			</form>
		</div>
	</div>

	<div id="del-top" class="modal">
		<div class="modal-content">
			<p>Do you want to delete this topic?</p>
			<p>This action can’t be undone. <br>
			People will no longer be able to view, share, and have a discussion on this topic. All data about this topic also will be deleted.</p>
		</div>
		<div class="modal-footer">
			<form action="<?php echo e(route('article.delete.post',['article_id'=>$article->id,'next'=>route('article.mine')])); ?>" method="post">
				<?php echo csrf_field(); ?>

				<a href="#!" class=" modal-action modal-close btn-flat">Cancel</a>
				<button type="submit" class=" modal-action modal-close btn-flat">Delete Topic</button>
			</form>
		</div>
	</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript" src="<?php echo e(asset('frontend/js/jquery-2.1.1.min.js')); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset('frontend/js/materialize.js')); ?>"></script>
	<script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
	<script type="text/javascript" src="<?php echo e(asset('frontend/js/jquery.dirtyforms.min.js')); ?>"></script>
	<script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
	<script>
		$(document).ready(function() {
			$('a#publish-post').webuiPopover({
				url:'#webui-popover',
				style: 'padding',
			});
		});
		// $(document).delegate('.save-draft', 'click', function(){
		// 	$(this).data('id');
		// 	console.log('save draft');
		// });
		// $(document).delegate('.up-publish', 'click', function(){
		// 	$(this).data('id');
		// 	console.log('publish');
		// });
	</script>
	<script type="text/javascript" src="<?php echo e(asset('frontend/js/main.js')); ?>"></script>
	<?php echo $__env->make('templates.messages.toast_scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>