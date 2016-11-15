			<div class="col s12 m4" id="card-home-over">
				<div class="card">
					<div class="card-image waves-effect waves-block waves-light">
						<a href="<?php echo e(route('article.read',['article_id'=>$article->id])); ?>">
						<?php if($article->header_image_url != null): ?>
							<img class="activator card-img" src="<?php echo e($article->header_image_url); ?>">
						<?php else: ?>
							<img class="activator card-img" src="<?php echo e(asset('frontend/img/default_header.jpg')); ?>">
						<?php endif; ?>
						</a>
					</div>
					<div class="card-content">
						<div class="row valign-wrapper">
							<div class="col s2 m2" id="card-photo">
								<a href="<?php echo e(route('home.panelist',['user_id'=>$user->id])); ?>">
									<?php if($user->photo_url == ''): ?>
										<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="" class="circle responsive-img card-pp">
									<?php else: ?>
										<img src="<?php echo e($user->photo_url); ?>" alt="" class="circle responsive-img card-pp">
									<?php endif; ?>
								</a>
							</div>
							<div class="col s10 m10" id="card-author">
								<span class="card-title activator grey-text text-darken-4" id="aut-name">
									<a href="<?php echo e(route('home.panelist',['user_id'=>$user->id])); ?>">
										<?php echo e($user->name); ?>

									</a>
									<span class="right" id="post-hour">
										<?php echo e($article->created_at->diffForHumans()); ?>

									</span>
								</span>
							</div>
						</div>
						<p class="title-cards"><a href="<?php echo e(route('home',['category'=>$article->category])); ?>"><?php echo e($article->category); ?></a></p>
						<p class="judul"><a href="<?php echo e(route('article.read',['article_id'=>$article->id])); ?>"><?php echo e($article->title); ?></a></p>
					</div>

					<div class="card-action">
						<div class="row">
							<div class="col s3 m3">
								<div class="left bkmrks">
									<?php if(!Auth::guest()): ?>
										<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('vote',$article)): ?>
											<a href="<?php echo e(route('article.vote',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Vote">
												<i class="material-icons share">favorite_border</i>
												<span><?php echo e($article->votes_count); ?></span>
											</a>
										<?php endif; ?>
										<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('unvote',$article)): ?>
											<a href="<?php echo e(route('article.unvote',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Unvote">
												<i class="material-icons share">favorite</i>
												<span><?php echo e($article->votes_count); ?></span>
											</a>
										<?php endif; ?>
									<?php else: ?>
										<a href="<?php echo e(route('auth.login')); ?>" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Vote">
											<i class="material-icons">favorite_border</i>
											<span><?php echo e($article->votes_count); ?></span>
										</a>
									<?php endif; ?>
								</div>
							</div>
							<div class="col s9 m9">
								<div class="cmt-shr right">
									<?php if(!Auth::guest()): ?>
										<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('mark',$article)): ?>
											<a href="<?php echo e(route('article.mark',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Bookmark">
												<i class="material-icons">bookmark_border</i>
											</a>
										<?php endif; ?>
										<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('unmark',$article)): ?>
											<a href="<?php echo e(route('article.unmark',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="unbookmark">
												<i class="material-icons">bookmark</i>
											</a>
										<?php endif; ?>
									<?php else: ?>
										<?php /* redirect ke login pas klik mark */ ?>
										<a href="<?php echo e(route('auth.login')); ?>" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Bookmark">
											<i class="material-icons">bookmark_border</i>
										</a>
									<?php endif; ?>
									<a class="dropdown-button toggle-post btn-flat tooltipped" href='#' data-position="top" data-delay="50" data-tooltip="Share" data-activates='dropdown<?php echo e($article->id); ?>'>
										<i class="material-icons">share</i>
									</a>
									<!-- Dropdown Structure -->
									<ul id='dropdown<?php echo e($article->id); ?>' class='dropdown-content'>
										<p>Share this topic to:</p>
										<li>
											<a class="waves-effect btn-flat fb" href="<?php echo e($article->facebook_share_url); ?>" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i>Facebook</a>
										</li>
										<li>
											<a class="waves-effect btn-flat tw" href="<?php echo e($article->twitter_share_url); ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i>Twitter</a>
										</li>
										<li>
											<a class="waves-effect btn-flat gp" href="<?php echo e($article->google_plus_share_url); ?>" target="_blank"><i class="fa fa-google" aria-hidden="true"></i>Google Plus</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>