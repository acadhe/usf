<?php
use App\Models\Comment;
$comment = $nestedComment->comment;
?>
<div class="card-content response-card">
	<div class="row" id="wrapper-comment-head">
		<div class="col s7 m9 left comment-kiri">
			<div class="row valign-wrapper">
				<div class="col s3 m2">
					<a href="{{ ($comment->user->type=='panelist') ? route('home.panelist',['user_id'=>$comment->user_id]) : 'javascript:void(0)' }}">
						@if($comment->user->photo_url == '')
							<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="circle responsive-img">
						@else
							<img src="{{$comment->user->photo_url}}" alt="" class="circle responsive-img">
						@endif
					</a>
				</div>
				<div class="col s9 m10">
					<a href="{{ ($comment->user->type=='panelist') ? route('home.panelist',['user_id'=>$comment->user_id]) : 'javascript:void(0)' }}">
						<span class="black-text">{{$comment->user->name}}</span>
					</a>
					<a href="{{ ($comment->user->type=='panelist') ? route('home.panelist',['user_id'=>$comment->user_id]) : 'javascript:void(0)' }}">
						<span class="grey-text">{{$comment->user->tagline}}</span>
					</a>
				</div>
			</div>
		</div>
		<div class="col s5 m3 left comment-kanan">
			<span class="grey-text">{{$comment->created_at->diffForHumans()}}</span>
		</div>
	</div>
	<div class="row" id="body-reply-comment">
		<div class="col s12 m12">
			<p>{{$comment->content}}</p>
		</div>
	</div>
	<div class="row">
		<div class="col s2 m2 left comment-kiri valign-wrapper">
			@can('vote',$comment)
				<a href="{{route('comment.vote',['comment_id'=>$comment->id])}}" class="btn-flat vote-cmnt">
					<i class="material-icons fav-com tooltipped" data-position="top" data-delay="50" data-tooltip="Like comemnt">favorite_border</i>
				</a>
				<span class="counter">{{$comment->votes_count}}</span>
			@endcan
			@can('unvote',$comment)
				<a href="{{route('comment.unvote',['comment_id'=>$comment->id])}}" class="btn-flat vote-cmnt">
					<i class="material-icons unfav-com tooltipped" data-position="top" data-delay="50" data-tooltip="Unlike comment">favorite</i>
				</a>
				<span class="counter">{{$comment->votes_count}}</span>
			@endcan
		</div>
		<div class="col s10 m10 comment-kanan">
			@can('delete',$comment)
				{{-- harus pake form+button ya jangan diganti a href. kalo mw modif, modif css form/buttonnya--}}
				<form method="post" action="{{route('comment.delete',['id'=>$comment->id])}}">
					{!! csrf_field() !!}
					<button class="btn-flat relpysatu tooltipped right" id="del" data-position="top" data-delay="50" data-tooltip="Delete comment" type="submit	"><i class="material-icons">delete</i></button>
				</form>
			@endcan
		</div>
	</div>
	<hr>
</div>