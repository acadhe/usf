<?php $__env->startSection('head'); ?>
@parent
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/slick-theme.css')); ?>"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
		<section id="atas-panelis">
			<div class="container" id="wrapper-atas-panelis">
				<div class="row">
					<div class="col s12 m8" id="head-utama-panelis">
						<p>Panelist</p>
						<p>Experts on the city issues</p>
					</div>
				</div>
			</div>
			<div class="container" id="wrapper-atas-panelis-carousel">
				<div class="row" id="wrapper-atas-panelis-inner">
					<div class="carousel-panelis">
						<?php foreach($users as $panelist): ?>
						<div>
							<a href="<?php echo e(route('home.panelist',['user_id'=>$panelist->id])); ?>">
								<?php if($panelist->photo_url == ''): ?>
								<?php /*gambar belum diatur, default gambar pp pengguna*/ ?>
									<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="Panelis" class="circle responsive-img">
								<?php else: ?>
									<img src="<?php echo e($panelist->photo_url); ?>" alt="Panelis" class="circle responsive-img">
								<?php endif; ?>
							</a>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>

		<section id="bawah-panelis">
			<div class="container" id="wrapper-bawah-panelis">
				<div class="row">
					<div class="col s12 m12" id="wrapper-card-panelist">
						<p id="pan">Select a panelist to view full details about the panelist <br>and topic(s) moderated</p>

						<?php if(isset($user) && $user != null): ?>
						<div class="card">
							<div class="card-content" id="card-panelist">
								<div class="row">
									<div class="col s12 m12">
										<div class="content-panelist">
											<div class="row valign-wrapper">
												<div class="col s12 m2" id="img">
													<a href="<?php echo e(route('user.read',['id'=>$user->id])); ?>">
														<?php if($user->photo_url == ''): ?>
															<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="Panelis" class="circle responsive-img" id="content-panelist-img">
														<?php else: ?>
															<img src="<?php echo e($user->photo_url); ?>" alt="Panelis" class="circle responsive-img" id="content-panelist-img">
														<?php endif; ?>
													</a>
												</div>
												<div class="col s12 m10" id="desc">
													<a href="<?php echo e(route('user.read',['id'=>$user->id])); ?>">
														<p><?php echo e($user->name); ?></p>
													</a>
													<a href="<?php echo e(route('user.read',['id'=>$user->id])); ?>">
														<p><?php echo e($user->tagline); ?></p>
													</a>
													<p><?php echo e($user->description); ?></p>
												</div>
											</div>

											<p id="tp">Topics Moderated</p>
											<?php foreach($articles as $article): ?>
												<div class="row tm valign-wrapper">
													<div class="col s12 m2">
														<?php if($article->header_image_url == ''): ?>
														<img class="responsive-img" src="<?php echo e(asset('frontend/img/default_header.jpg')); ?>">
														<?php else: ?>
														<img class="responsive-img" src="<?php echo e($article->header_image_url); ?>"/>
														<?php endif; ?>
													</div>
													<div class="col s12 m10">
														<div class="row valign-wrapper" id="vw">
															<div class="col s12 m12 valign">
																<a href="<?php echo e(route('article.read',['article_id'=>$article->id])); ?>">
																	 <p><?php echo e($article->title); ?></p>
																</a>
																<a href="<?php echo e(route('home',['category'=>$article->category])); ?>">
																	<p class="title-cards"><?php echo e($article->category); ?></p>
																</a>
															</div>
														</div>
													</div>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>