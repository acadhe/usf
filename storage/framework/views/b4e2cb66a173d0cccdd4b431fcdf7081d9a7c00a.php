<?php
use App\Models\Comment;
$comment = $nestedComment->comment;
?>
	<div class="card">
		<div class="card-content" id="parent-comment">
			<div class="row" id="wrapper-comment-head">
				<div class="col s7 m8 left comment-kiri">
					<div class="row valign-wrapper">
						<div class="col s2 m1">
							<a href="<?php echo e(($comment->user->type=='panelist') ? route('home.panelist',['user_id'=>$comment->user_id]) : 'javascript:void(0)'); ?>">
								<?php if($comment->user->photo_url == ''): ?>
									<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="" class="circle responsive-img">
								<?php else: ?>
									<img src="<?php echo e($comment->user->photo_url); ?>" alt="" class="circle responsive-img">
								<?php endif; ?>
							</a>
						</div>
						<div class="col s10 m11">
							<a href="<?php echo e(($comment->user->type=='panelist') ? route('home.panelist',['user_id'=>$comment->user_id]) : 'javascript:void(0)'); ?>">
								<span class="black-text"><?php echo e($comment->user->name); ?></span>
							</a>
							<a href="<?php echo e(($comment->user->type=='panelist') ? route('home.panelist',['user_id'=>$comment->user_id]) : 'javascript:void(0)'); ?>">
								<span class="grey-text"><?php echo e($comment->user->tagline); ?></span>
							</a>
							<?php /* <span class="grey-text"><?php echo e($comment->votes_count); ?> Favorites - <?php echo e($comment->created_at->diffForHumans()); ?></span> */ ?>
						</div>
					</div>
				</div>
				<div class="col s5 m4 comment-kanan">
					<?php if($comment->support == Comment::SUPPORT_PRO): ?>
						<div id="support">
							<div for="pro" class="stat-pro">PRO</div>
						</div>
					<?php elseif($comment->support == Comment::SUPPORT_CONTRA): ?>
						<div id="support">
							<div for="cons" class="stat-cons">KONTRA</div>
						</div>
					<?php endif; ?>
					<p class="grey-text right" id="clock"><?php echo e($comment->created_at->diffForHumans()); ?></p>
				</div>
			</div>
			<div class="row" id="body-comment">
				<div class="col s12 m12">
					<p><?php echo e($comment->content); ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col s2 m2 left comment-kiri valign-wrapper">
					<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('vote',$comment)): ?>
						<a href="<?php echo e(route('comment.vote',['comment_id'=>$comment->id])); ?>" class="btn-flat vote-cmnt">
							<i class="material-icons fav-com tooltipped" data-position="top" data-delay="50" data-tooltip="Like comemnt">favorite_border</i>
						</a>
						<span class="counter"><?php echo e($comment->votes_count); ?></span>
					<?php endif; ?>
					<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('unvote',$comment)): ?>
						<a href="<?php echo e(route('comment.unvote',['comment_id'=>$comment->id])); ?>" class="btn-flat vote-cmnt">
							<i class="material-icons unfav-com tooltipped" data-position="top" data-delay="50" data-tooltip="Unlike comment">favorite</i>
						</a>
						<span class="counter"><?php echo e($comment->votes_count); ?></span>
					<?php endif; ?>
				</div>
				<div class="col s10 m10 comment-kanan">
					<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('comment',$article)): ?>
						<a class="btn-flat relpysatu tooltipped right" id="reply-trig-com" data-toggle="<?php echo e($comment->id); ?>" data-position="top" data-delay="50" data-tooltip="Reply comment">
							<i class="material-icons">reply</i>
						</a>
					<?php endif; ?>
					<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('delete',$comment)): ?>
						<?php /* harus pake form+button ya jangan diganti a href. kalo mw modif, modif css form/buttonnya*/ ?>
						<form method="post" action="<?php echo e(route('comment.delete',['id'=>$comment->id])); ?>">
						<?php echo csrf_field(); ?>

							<button class="btn-flat relpysatu tooltipped right" id="del" data-position="top" data-delay="50" data-tooltip="Delete comment" type="submit	"><i class="material-icons">delete</i></button>
						</form>
					<?php endif; ?>
					<a class="btn-flat allreply right" id="hide-com" data-toggle="<?php echo e($comment->id); ?>">Hide/Show Replies</a>
				</div>
			</div>

			<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('comment',$article)): ?>
				<div class="row txt" id="txt<?php echo e($comment->id); ?>">
					<div class="col s12 m12" id="comment-body">
						<?php echo $__env->make('articles._comment_form',['article'=>$article,'replied_comment_id'=>$comment->id], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					</div>
				</div>
			<?php endif; ?>

		</div>
		
		<div id="hide<?php echo e($comment->id); ?>">
			<?php foreach($nestedComment->childNestedComments as $childNestedComment): ?>
				<?php echo $__env->make('articles._read_comment_card_first_child',['nestedComment'=>$childNestedComment], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<?php endforeach; ?>
		</div>
	</div>