<p id="judul">These are topics you have followed</p>
<?php /* <div class="dummy-wrapper hide-on-small-only"></div> */ ?>
	<div class="cardtopics">
		<?php foreach($articles as $article): ?>
			<div class="row">
				<div class="col s12 m12">
					<div class="card">
						<div class="card-content valign-wrapper">
							<div class="row">
								<div class="col s12 m8 valign-wrapper">
									<div class="row">
									 	<div class="col m12 valign-wrapper" id="info-user-bt">
									 		<div class="row">
										 		<a href="<?php echo e(route('home.panelist',['user_id'=>$user->id])); ?>">
													<div class="col s3 m2">
														<?php if($article->user->photo_url == ''): ?>
															<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="" class="responsive-img circle">
														<?php else: ?>
															<img src="<?php echo e($article->user->photo_url); ?>" class="responsive-img circle">
														<?php endif; ?>
													</div>
													<div class="col s9 m10">
														<p><?php echo e($article->user->name); ?></p>
													</div>
												</a>
											</div>
									 	</div>
										<div class="col s12 m12">
											<a href="<?php echo e(route('article.read',['article_id'=>$article->id])); ?>">
												<p class="truncate"><?php echo e($article->title); ?></p>
											</a>
											<a href="<?php echo e(route('home',['category'=>$article->category])); ?>">
												<p class="title-cards"><?php echo e($article->category); ?></p>
											</a>
										</div>
									</div>
								</div>
								<div class="col s12 m4 valign-wrapper">
									<div class="row" id="share">
										<a class="dropdown-button toggle-post btn-flat tooltipped" href="#" data-activates="dropdown<?php echo e($article->id); ?>" data-position="top" data-delay="50" data-tooltip="Share Topic">
											<i class="material-icons">share</i>
										</a>
										<!-- Dropdown Structure -->
										<ul id='dropdown<?php echo e($article->id); ?>' class='dropdown-content'>
											<p>Share this topic to:</p>
											<li>
												<a class="waves-effect btn-flat fb" href="#" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i>Facebook</a>
											</li>
											<li>
												<a class="waves-effect btn-flat tw" href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i>Twitter</a>
											</li>
											<li>
												<a class="waves-effect btn-flat gp" href="#" target="_blank"><i class="fa fa-google" aria-hidden="true"></i>Google Plus</a>
											</li>
										</ul>
										<?php /* bookmark */ ?>
										<?php if(!Auth::guest()): ?>
											<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('mark',$article)): ?>
												<a href="<?php echo e(route('article.mark',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat bookmark tooltipped" data-position="top" data-delay="50" data-tooltip="Bookmark">
													<i class="material-icons">bookmark_border</i>
												</a>
											<?php endif; ?>
											<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('unmark',$article)): ?>
												<a href="<?php echo e(route('article.unmark',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat bookmark tooltipped" data-position="top" data-delay="50" data-tooltip="Unbookmark">
													<i class="material-icons">bookmark</i>
												</a>
											<?php endif; ?>
										<?php else: ?>
											<?php /* redirect ke login pas klik mark */ ?>
											<a href="<?php echo e(route('auth.login')); ?>" class="toggle-post btn-flat bookmark tooltipped" data-position="top" data-delay="50" data-tooltip="Bookmark">
												<i class="material-icons">bookmark</i>
												<span><?php echo e($article->bookmarks_count); ?></span>
											</a>
										<?php endif; ?>
										<?php /* bookmark */ ?>
										<?php /* vote */ ?>
										<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('vote',$article)): ?>
											<a href="<?php echo e(route('article.vote',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat love tooltipped" data-position="top" data-delay="50" data-tooltip="Vote">
												<i class="material-icons">favorite_border</i>
												<span><?php echo e($article->votes_count); ?></span>
											</a>
										<?php endif; ?>
										<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('unvote',$article)): ?>
											<a href="<?php echo e(route('article.unvote',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat love tooltipped" data-position="top" data-delay="50" data-tooltip="Unvote"
												<i class="material-icons">favorite</i>
												<span><?php echo e($article->votes_count); ?></span>
											</a>
										<?php endif; ?>
										<?php /* vote */ ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
