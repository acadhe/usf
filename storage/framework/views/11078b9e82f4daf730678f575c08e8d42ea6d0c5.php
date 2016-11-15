<?php
/** @var \App\Contracts\Services\Mappers\Notifications\AbstractNotification $notification */
/** @var \App\Contracts\Services\Mappers\Notifications\AbstractNotification[] $notifications */

use App\Contracts\Services\Mappers\Notifications\UserReplyCommentNotification;
use App\Contracts\Services\Mappers\Notifications\UserCommentArticleNotification;
use App\Contracts\Services\Mappers\Notifications\PanelistCloseSubscribedArticleNotification;
use App\Contracts\Services\Mappers\Notifications\UserVoteCommentNotification;

?>
<p id="judul">Activities timeline</p>
<?php /* <div class="dummy-wrapper hide-on-small-only"></div> */ ?>
<div class="container-timeline">
	<?php foreach($notifications as $notification): ?>
		<?php if($notification instanceof \App\Contracts\Services\Mappers\Notifications\PanelistCloseSubscribedArticleNotification): ?>
			<?php echo $__env->make('users.read.activities.panelist_close_subscribed_article',['notification'=>$notification], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php elseif($notification instanceof \App\Contracts\Services\Mappers\Notifications\UserCommentArticleNotification): ?>
			<?php echo $__env->make('users.read.activities.user_comment_created_article',['notification'=>$notification], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php elseif($notification instanceof \App\Contracts\Services\Mappers\Notifications\UserReplyCommentNotification): ?>
			<?php echo $__env->make('users.read.activities.user_reply_comment',['notification'=>$notification], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php elseif($notification instanceof \App\Contracts\Services\Mappers\Notifications\UserVoteCommentNotification): ?>
			<?php echo $__env->make('users.read.activities.user_vote_comment',['notification'=>$notification], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
