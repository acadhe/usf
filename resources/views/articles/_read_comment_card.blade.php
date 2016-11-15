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
							<a href="{{ ($comment->user->type=='panelist') ? route('home.panelist',['user_id'=>$comment->user_id]) : 'javascript:void(0)' }}">
								@if($comment->user->photo_url == '')
									<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="circle responsive-img">
								@else
									<img src="{{$comment->user->photo_url}}" alt="" class="circle responsive-img">
								@endif
							</a>
						</div>
						<div class="col s10 m11">
							<a href="{{ ($comment->user->type=='panelist') ? route('home.panelist',['user_id'=>$comment->user_id]) : 'javascript:void(0)' }}">
								<span class="black-text">{{$comment->user->name}}</span>
							</a>
							<a href="{{ ($comment->user->type=='panelist') ? route('home.panelist',['user_id'=>$comment->user_id]) : 'javascript:void(0)' }}">
								<span class="grey-text">{{$comment->user->tagline}}</span>
							</a>
							{{-- <span class="grey-text">{{$comment->votes_count}} Favorites - {{$comment->created_at->diffForHumans()}}</span> --}}
						</div>
					</div>
				</div>
				<div class="col s5 m4 comment-kanan">
					@if($comment->support == Comment::SUPPORT_PRO)
						<div id="support">
							<div for="pro" class="stat-pro">PRO</div>
						</div>
					@elseif($comment->support == Comment::SUPPORT_CONTRA)
						<div id="support">
							<div for="cons" class="stat-cons">KONTRA</div>
						</div>
					@endif
					<p class="grey-text right" id="clock">{{$comment->created_at->diffForHumans()}}</p>
				</div>
			</div>
			<div class="row" id="body-comment">
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
					@can('comment',$article)
						<a class="btn-flat relpysatu tooltipped right" id="reply-trig-com" data-toggle="{{$comment->id}}" data-position="top" data-delay="50" data-tooltip="Reply comment">
							<i class="material-icons">reply</i>
						</a>
					@endcan
					@can('delete',$comment)
						{{-- harus pake form+button ya jangan diganti a href. kalo mw modif, modif css form/buttonnya--}}
						<form method="post" action="{{route('comment.delete',['id'=>$comment->id])}}">
						{!! csrf_field() !!}
							<button class="btn-flat relpysatu tooltipped right" id="del" data-position="top" data-delay="50" data-tooltip="Delete comment" type="submit	"><i class="material-icons">delete</i></button>
						</form>
					@endcan
					<a class="btn-flat allreply right" id="hide-com" data-toggle="{{$comment->id}}">Hide/Show Replies</a>
				</div>
			</div>

			@can('comment',$article)
				<div class="row txt" id="txt{{$comment->id}}">
					<div class="col s12 m12" id="comment-body">
						@include('articles._comment_form',['article'=>$article,'replied_comment_id'=>$comment->id])
					</div>
				</div>
			@endcan

		</div>
		
		<div id="hide{{$comment->id}}">
			@foreach($nestedComment->childNestedComments as $childNestedComment)
				@include('articles._read_comment_card_first_child',['nestedComment'=>$childNestedComment])
			@endforeach
		</div>
	</div>