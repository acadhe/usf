<?php $__env->startSection('head'); ?>
@parent
	<meta property="og:description" content="<?php echo e($article->content); ?>" />
	<meta property="og:image" content="<?php echo e($article->header_image_url); ?>" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<form method="post" action="<?php echo e(route('article.update_summary.post',['article_id'=>$article->id])); ?>">
	<?php echo csrf_field(); ?>

	<div id="close-modal-topic" class="modal">
		<div class="modal-content">
			<h4>Do you want to close this topic?</h4>
			<p>This topic will be closed and comments section are no longer available for discussions. <br> But, everyone can still view the topic and comments though</p>
		</div>
		<div class="modal-footer">
			<a href="#!" class=" modal-action modal-close waves-effect btn-flat">Cancel</a>
			<a href="#step1" class=" modal-action modal-close modal-trigger waves-effect waves-green btn-flat">Close Topic</a>
		</div>
	</div>
	<div id="step1" class="modal">
		<form action="<?php echo e(route('article.close.post',['article_id'=>$article->id])); ?>" method="post">

			<div class="modal-content">
				<p>Topic Summary:</p>
				<textarea id="komen-atas" name="summary" class="materialize-textarea" placeholder="Write your summary to this topic..."><?php echo e($article->summary); ?></textarea>
			</div>
			<div class="modal-footer">
				<button class="waves-effect btn-flat right comment-submit" type="submit">Post Summary</button>
				<a href="#!" class=" modal-action modal-close waves-effect btn-flat">Cancel</a>
			</div>
		</form>
	</div>
</form>

<section id="atas-post">
	<div class="container wrapper-atas-post">
		<div class="row">
			<div class="col s12 m8 wrapper-post-infoowner">
				<a href="<?php echo e(route('home.panelist',['user_id'=>$user->id])); ?>">
					<div class="col s3 m2">
						<?php if($user->photo_url == ''): ?>
							<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="" class="circle responsive-img profilep-img">
						<?php else: ?>
							<img src="<?php echo e($user->photo_url); ?>" alt="" class="circle responsive-img profilep-img">
						<?php endif; ?>
					</div>
					<div class="col s9 m10">
						<span class="black-text"><?php echo e($user->name); ?></span>
						<span class="grey-text"><?php echo e($user->tagline); ?></span>
					</div>
				</a>
			</div>
		</div>
	</div>

	<div class="container" id="wrapper-atas-post-body">
		<div class="row">
			<div class="col s12 m12" id="wrapper-post-headcontent">
				<h5><a href="<?php echo e(route('home',['category'=>$article->category])); ?>"><?php echo e($article->category); ?></a></h5>
				<h3><?php echo e($article->title); ?></h3>
			</div>
		</div>
	</div>
	<div class="row">
		<div id="wrapper-post-bodycontent">
		
			<?php if(!$article->open): ?>
				<div class="row" id="post-summary">
					<div class="col s12 m12">
						<div class="card">
							<div class="card-content">
								<div class="row">
									<div class="col s6 m6" id="closed-kiri">
										<span class="left"><i class="material-icons">flag</i></span>
										<p class="left">Discussion closed by <?php echo e($user->name); ?></p>
									</div>
									<div class="col s6 m6" id="closed-kanan">
										<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('updateSummary',$article)): ?>
											<a href="<?php echo e(route('article.update_summary',['article_id'=>$article->id])); ?>" class="tooltipped right" data-position="top" data-delay="50" data-tooltip="Edit summary"><i class="material-icons">edit</i></a>
										<?php endif; ?>
									</div>
								</div>
								<div id="closed-body">
									<p>Topic Summary</p>
									<p><?php echo e($article->summary); ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if($article->header_image_url != null): ?>
				<img class="activator" src="<?php echo e($article->header_image_url); ?>">
			<?php else: ?>
				<img class="activator" src="<?php echo e(asset('frontend/img/default_header.jpg')); ?>">
			<?php endif; ?>
			<?php /* <?php echo e($article->content); ?> */ ?>
			<?php echo $article->content; ?>

		</div>
	</div>
	<div class="container" id="wrapper-share">
		<div class="card">
			<div class="card-content">
				<div class="row valign-wrapper" id="inner-wrapper">
					<div class="col s6 m6 icons-kiri">
						<?php if(!Auth::guest()): ?>
							<?php /* vote section */ ?>

							<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('vote',$article)): ?>
								<a href="<?php echo e(route('article.vote',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Vote">
									<i class="material-icons share">favorite_border</i>
									<span><?php echo e($article->votes_count); ?></span>
								</a>
							<?php endif; ?>
							<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('unvote',$article)): ?>
								<a href="<?php echo e(route('article.unvote',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat tooltipped active" data-position="top" data-delay="50" data-tooltip="Unvote">
									<i class="material-icons share">favorite</i>
									<span><?php echo e($article->votes_count); ?></span>
								</a>
							<?php endif; ?>
							<?php /* vote section */ ?>
						<?php else: ?>
							<a href="<?php echo e(route('auth.login',['after_login_url'=>Request::url()])); ?>" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Vote">
								<i class="material-icons share">favorite_border</i>
								<span><?php echo e($article->votes_count); ?></span>
							</a>
						<?php endif; ?>


						<a class="btn-flat tooltipped" id="pro" data-position="top" data-delay="50" data-tooltip="Comment Pro">
							<i class="material-icons">comment</i>
							<span><?php echo e($countPro); ?></span>
						</a>

						<a class="btn-flat tooltipped" id="kontra" data-position="top" data-delay="50" data-tooltip="Comment Contra">
							<i class="material-icons">comment</i>
							<span><?php echo e($countContra); ?></span>
						</a>
					</div>

					<div class="col s6 m6 icons-kanan valign-wrapper right">
						<div class="right">
							<a href="<?php echo e($article->google_plus_share_url); ?>" class="goodshare tooltipped btn-flat" data-type="gp" data-title="<?php echo e($article->title); ?>" data-text="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua." data-image="http://goodshare.ru/assets/images/goodshare-logo-github.jpg" data-position="top" data-delay="50" data-tooltip="Share to Google Plus">
								<i class="fa fa-google" aria-hidden="true"></i>
								<?php /* <span data-counter="gp"></span> */ ?>
							</a>
							<a href="<?php echo e($article->twitter_share_url); ?>" class="goodshare tooltipped btn-flat" data-type="tw" data-title="<?php echo e($article->title); ?>" data-text="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua." data-image="http://goodshare.ru/assets/images/goodshare-logo-github.jpg" data-position="top" data-delay="50" data-tooltip="Share to Twitter">
								<i class="fa fa-twitter" aria-hidden="true"></i>
							</a>
							<a href="<?php echo e($article->facebook_share_url); ?>" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
							<?php if(!Auth::guest()): ?>
							<?php /* bookmark section */ ?>
							<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('mark',$article)): ?>
								<a href="<?php echo e(route('article.mark',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Bookmark article">
									<i class="material-icons share">bookmark_border</i>
								</a>
							<?php endif; ?>
							<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('unmark',$article)): ?>
								<a href="<?php echo e(route('article.unmark',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat tooltipped active" data-position="top" data-delay="50" data-tooltip="Unmark article">
									<i class="material-icons share">bookmark</i>
								</a>
							<?php endif; ?>
							<?php /* bookmark section */ ?>
							<?php else: ?>
								<a href="<?php echo e(route('auth.login',['after_login_url'=>Request::url()])); ?>" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Bookmark article">
									<i class="material-icons share">bookmark_border</i>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="wrapper-atas-post" id="bio-bawah">
					<div class="row valign-wrapper">
						<div class="col s6 m6 wrapper-post-infoowner" id="bawah-post">
							<div class="row valign-wrapper">
								<p class="left">Published by:</p>
							</div>
							<div class="row valign-wrapper">
								<div class="col s3 m2">
									<a href="<?php echo e(route('home.panelist',['user_id'=>$user->id])); ?>">
										<?php if($user->photo_url == ''): ?>
											<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="" class="circle responsive-img">
										<?php else: ?>
											<img src="<?php echo e($user->photo_url); ?>" alt="" class="circle responsive-img">
										<?php endif; ?>
									</a>
								</div>
								<div class="col s9 m10">
									<a href="<?php echo e(route('home.panelist',['user_id'=>$user->id])); ?>">
										<span class="black-text"><?php echo e($user->name); ?></span>
									</a>
									<a href="<?php echo e(route('home.panelist',['user_id'=>$user->id])); ?>">
										<span class="grey-text"><?php echo e($user->tagline); ?></span>
									</a>
								</div>
							</div>
						</div>
						<div class="col s6 m6 wrapper-post-infoowner" id="kanan-post">
							<p class="right">Topic published in:</p>
							<p class="right"><a href="<?php echo e(route('home',['category'=>$article->category])); ?>"><?php echo e($article->category); ?></a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="bawah-post">
	<div class="container" id="wrapper-bawah-post">
		<div class="row">
			<div class="col s12 m12" id="comment-sect">
				<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('comment',$article)): ?>
					<?php echo $__env->make('articles._comment_form',['article'=>$article], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				<?php endif; ?>

				<?php if(Auth::guest() && $article->open): ?>
					<div class="col s12 m12" id="wrapper-popout">
						<div class="card valign-wrapper">
							<div class="card-content">
								<h4 id="sign-in-alert">Please <a href="<?php echo e(route('auth.login')); ?>">sign in or sign up</a> to comment</h3>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<!-- <div class="container" id="btn-sort"> -->
			<div class="col s12 m12" id="btn-sort">
				<p>Show Comments</p>
				<a class="waves-effect btn-flat <?php if($sort=='most_popular'): ?> active <?php endif; ?>" href="<?php echo e(route('article.read',['id'=>$article->id,'sort'=>'most_popular'])); ?>">Best</a>
				<a class="waves-effect btn-flat <?php if($sort=='most_recent'): ?> active <?php endif; ?>" href="<?php echo e(route('article.read',['id'=>$article->id,'sort'=>'most_recent'])); ?>">Most Recent</a>
				<?php /*<a class="waves-effect waves-teal btn-flat">You Response To</a>*/ ?>
			</div>

			<div class="col s12 m12" id="comment">
				<?php foreach($nestedComments as $nestedComment): ?>
					<?php echo $__env->make('articles._read_comment_card',['nestedComment'=>$nestedComment], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	@parent
<?php if($intentCloseArticle): ?>
	<script>
		alert("config coy");
	</script>
<?php endif; ?>
	<script>
		var token = $('meta[name="csrf_token"]').attr('content');
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': token
			}
		});
		$.ajax({
			type: 'post',
			url: '<?php echo e(route('api.v1.article.update_share_count',['article_id'=>$article->id])); ?>'
		});

		$("a#hide-com").click(function(e){
		  var id_comment_box_terkait = $(this).attr("data-toggle");
		  $("#hide"+id_comment_box_terkait).slideToggle(200);
		});

		$("a#reply-trig-com").click(function(e){
		  var id_comment_box_terkait = $(this).attr("data-toggle");
		  $("#txt"+id_comment_box_terkait).slideToggle(200);
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master-read', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>