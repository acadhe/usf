<?php
/** @var \App\Contracts\Services\Mappers\Notifications\AbstractNotification $notification */
/** @var \App\Contracts\Services\Mappers\Notifications\AbstractNotification[] $notifications */

use App\Contracts\Services\Mappers\Notifications\UserReplyCommentNotification;
use App\Contracts\Services\Mappers\Notifications\UserCommentArticleNotification;
use App\Contracts\Services\Mappers\Notifications\PanelistCloseSubscribedArticleNotification;
use App\Contracts\Services\Mappers\Notifications\UserVoteCommentNotification;

?>
<p id="judul">Activities timeline</p>
{{-- <div class="dummy-wrapper hide-on-small-only"></div> --}}
<div class="container-timeline">
	@foreach($notifications as $notification)
		@if($notification instanceof \App\Contracts\Services\Mappers\Notifications\PanelistCloseSubscribedArticleNotification)
			@include('users.read.activities.panelist_close_subscribed_article',['notification'=>$notification])
		@elseif($notification instanceof \App\Contracts\Services\Mappers\Notifications\UserCommentArticleNotification)
			@include('users.read.activities.user_comment_created_article',['notification'=>$notification])
		@elseif($notification instanceof \App\Contracts\Services\Mappers\Notifications\UserReplyCommentNotification)
			@include('users.read.activities.user_reply_comment',['notification'=>$notification])
		@elseif($notification instanceof \App\Contracts\Services\Mappers\Notifications\UserVoteCommentNotification)
			@include('users.read.activities.user_vote_comment',['notification'=>$notification])
		@endif
	@endforeach
</div>
