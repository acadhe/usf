<?php
use App\Models\Comment;
$comment = $nestedComment->comment;
?>
<div class="card-content response-card">
	<div class="row" id="wrapper-comment-head">
		<div class="col s7 m9 left comment-kiri">
			<div class="row valign-wrapper">
				<div class="col s3 m2">
					<a href="<?php echo e(($comment->user->type=='panelist') ? route('home.panelist',['user_id'=>$comment->user_id]) : 'javascript:void(0)'); ?>">
						<?php if($comment->user->photo_url == ''): ?>
							<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="" class="circle responsive-img">
						<?php else: ?>
							<img src="<?php echo e($comment->user->photo_url); ?>" alt="" class="circle responsive-img">
						<?php endif; ?>
					</a>
				</div>
				<div class="col s9 m10">
					<a href="<?php echo e(($comment->user->type=='panelist') ? route('home.panelist',['user_id'=>$comment->user_id]) : 'javascript:void(0)'); ?>">
						<span class="black-text"><?php echo e($comment->user->name); ?></span>
					</a>
					<a href="<?php echo e(($comment->user->type=='panelist') ? route('home.panelist',['user_id'=>$comment->user_id]) : 'javascript:void(0)'); ?>">
						<span class="grey-text"><?php echo e($comment->user->tagline); ?></span>
					</a>
				</div>
			</div>
		</div>
		<div class="col s5 m3 left comment-kanan">
			<span class="grey-text"><?php echo e($comment->created_at->diffForHumans()); ?></span>
		</div>
	</div>
	<div class="row" id="body-reply-comment">
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
			<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('delete',$comment)): ?>
				<?php /* harus pake form+button ya jangan diganti a href. kalo mw modif, modif css form/buttonnya*/ ?>
				<form method="post" action="<?php echo e(route('comment.delete',['id'=>$comment->id])); ?>">
					<?php echo csrf_field(); ?>

					<button class="btn-flat relpysatu tooltipped right" id="del" data-position="top" data-delay="50" data-tooltip="Delete comment" type="submit	"><i class="material-icons">delete</i></button>
				</form>
			<?php endif; ?>
		</div>
	</div>
	<hr>
</div>