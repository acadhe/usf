<p id="judul">These are topics you have followed</p>
<div class="dummy-wrapper"></div>
	<div class="cardtopics">
		<?php foreach($articles as $article): ?>
			<div class="row">
				<div class="col s12 m12">
					<div class="card">
						<div class="card-content">
							<div class="row">
								<div class="col m8 valign-wrapper">
									<div class="row">
										<a href="<?php echo e(route('article.read',['article_id'=>$article->id])); ?>">
											<p class="truncate"><?php echo e($article->title); ?></p>
										</a>
										<a href="#">
											<p class="title-cards"><?php echo e($article->category); ?></p>
										</a>
									</div>
								</div>
								<div class="col m4 valign-wrapper">
									<div class="row">
										<a href="#" class="toggle-post btn-flat">
											<i class="material-icons">share</i>
										</a>
										<?php /* bookmark */ ?>
										<?php if(!Auth::guest()): ?>
											<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('mark',$article)): ?>
												<a href="<?php echo e(route('article.mark',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat">
													<i class="material-icons">bookmark_border</i>
												</a>
											<?php endif; ?>
											<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('unmark',$article)): ?>
												<a href="<?php echo e(route('article.unmark',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat">
													<i class="material-icons">bookmark</i>
												</a>
											<?php endif; ?>
										<?php else: ?>
											<?php /* redirect ke login pas klik mark */ ?>
											<a href="<?php echo e(route('auth.login')); ?>" class="toggle-post btn-flat">
												<i class="material-icons">bookmark</i>
												<span><?php echo e($article->bookmarks_count); ?></span>
											</a>
										<?php endif; ?>
										<?php /* bookmark */ ?>
										<?php /* vote */ ?>
										<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('vote',$article)): ?>
											<a href="<?php echo e(route('article.vote',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat">
												<i class="material-icons">favorite_border</i>
												<span><?php echo e($article->votes_count); ?></span>
											</a>
										<?php endif; ?>
										<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('unvote',$article)): ?>
											<a href="<?php echo e(route('article.unvote',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat">
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
