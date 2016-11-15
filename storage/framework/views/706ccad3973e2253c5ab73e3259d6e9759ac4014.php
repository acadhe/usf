			<div class="col s6 m6">
				<div class="card">
					<div class="card-image waves-effect waves-block waves-light">
						<img class="activator card-img" src="<?php echo e(asset('frontend/img/post.jpg')); ?>">
					</div>
					<div class="card-content card-moderated">
						<div class="row valign-wrapper wrapper-card-moderated">
							<div class="col m2" id="card-photo">
								<img src="<?php echo e($user->photo_url); ?>" alt="" class="circle responsive-img card-pp">
							</div>
							<div class="col m10" id="card-author">
								<span class="card-title activator grey-text text-darken-4" id="aut-name">
									<a href="<?php echo e(route('user.read',['user_id'=>$user->id])); ?>"><?php echo e($user->name); ?></a>
									<span class="right" id="post-hour">2 Hours Ago</span>
								</span>
							</div>
						</div>
						<p class="truncate"><a href="<?php echo e(route('article.read',['article_id'=>$article->id])); ?>"><?php echo e($article->title); ?></a></p>
						<p class="title-cards"><a href="#"><?php echo e($article->category); ?></a></p>
					</div>

					<div class="card-action">
						<div class="row">
							<div class="col m12">
								<span class="cmt-shr">
									<a href="#">
										<i class="material-icons">comment</i>
										<span><?php echo e($article->comments_count); ?></span>
									</a>
								</span>
								<span class="cmt-shr">
									<a href="#">
										<i class="material-icons">share</i>
										<span><?php echo e($article->shares_count); ?></span>
									</a>
								</span>
							</div>
						</div>
					</div>

					<div class="card-reveal" id="reveal">
						<div class="card-content card-moderated">
							<div class="row valign-wrapper wrapper-card-moderated">
								<div class="col m2" id="card-photo">
									<img src="<?php echo e($user->photo_url); ?>" alt="" class="circle responsive-img card-pp">
								</div>
								<div class="col m10" id="card-author">
									<span class="card-title activator grey-text text-darken-4" id="aut-name">
										<a href="<?php echo e(route('user.read',['user_id'=>$user->id])); ?>"><?php echo e($user->name); ?></a>
										<span class="card-title activator right" id="post-hour">
											2 Hours Ago
										</span>
									</span>
								</div>
							</div>
							<p><a href="<?php echo e(route('article.read',['article_id'=>$article->id])); ?>"><?php echo e($article->title); ?></a></p>
							<!-- <p class="title-cards"><a href="#">public places</a></p> -->
							<p class="title-cards"><a href="#"><?php echo e($article->category); ?></a></p>
						</div>
						<p class="reveal-content">Here is some more information about this product that is only revealed once clicked on.</p>
						<p class="read-more-content"><a href="<?php echo e(route('article.read',['article_id'=>$article->id])); ?>">read full story</a></p>
					</div>
				</div>
			</div>