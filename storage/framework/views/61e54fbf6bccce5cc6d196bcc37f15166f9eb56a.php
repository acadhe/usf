<p id="judul">These are topics you liked</p>
<?php /* <div class="dummy-wrapper hide-on-small-only"></div> */ ?>
<div class="row cardtopics">
    <?php foreach($articles as $article): ?>
        <?php /* <?php echo $__env->make('templates.articles.card-moderated',['article'=>$article], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> */ ?>
			<div class="col s12 m12">
				<div class="card">
					<div class="card-content valign-wrapper">
						<div class="row">
							<div class="col s12 m8 valign-wrapper">
								<div class="row">
									<a href="<?php echo e(route('article.read',['article_id'=>$article->id])); ?>">
										<p class="truncate"><?php echo e($article->title); ?></p>
									</a>
									<a href="<?php echo e(route('home',['category'=>$article->category])); ?>">
										<p class="title-cards" id="cat"><?php echo e($article->category); ?></p>
									</a>
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
											<a href="<?php echo e(route('article.mark',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat bookmark tooltipped active" data-position="top" data-delay="50" data-tooltip="Bookmark">
												<i class="material-icons">bookmark_border</i>
											</a>
										<?php endif; ?>
										<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('unmark',$article)): ?>
											<a href="<?php echo e(route('article.unmark',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat bookmark tooltipped active" data-position="top" data-delay="50" data-tooltip="Unbookmark">
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
										<a href="<?php echo e(route('article.vote',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat tooltipped love active" data-position="top" data-delay="50" data-tooltip="Vote">
											<i class="material-icons">favorite_border</i>
											<span><?php echo e($article->votes_count); ?></span>
										</a>
									<?php endif; ?>
									<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('unvote',$article)): ?>
										<a href="<?php echo e(route('article.unvote',['article_id'=>$article->id])); ?>" class="toggle-post btn-flat tooltipped love" data-position="top" data-delay="50" data-tooltip="Unvote">
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
    <?php endforeach; ?>
</div>
