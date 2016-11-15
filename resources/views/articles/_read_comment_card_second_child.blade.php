<?php
use App\Models\Comment;
$comment = $nestedComment->comment;
?>
<div class="card-content response-card" style="padding-left:100px;">
    <div class="row" id="wrapper-comment-head">
        <div class="col m6 left comment-kiri">
            <div class="row">
                <div class="col s2">
                    <img src="{{$comment->user->photo_url}}" alt="" class="circle responsive-img">
                </div>
                <div class="col s10">
                    <span class="black-text">{{$comment->user->name}}</span>
                    <span class="grey-text">{{$comment->votes_count}} Favorites - 2 Hours Ago</span>
                </div>
            </div>
        </div>
        <div class="col m6 right comment-kanan">
            @can('vote',$comment)
                <a href="{{route('comment.vote',['comment_id'=>$comment->id])}}"><i class="material-icons unactive">favorite</i></a>
            @endcan
            @can('unvote',$comment)
                <a href="{{route('comment.unvote',['comment_id'=>$comment->id])}}"><i class="material-icons">favorite</i></a>
            @endcan
        </div>
    </div>
    <div class="row" id="body-reply-comment">
        <div class="col m12">
            <p>{{$comment->content}}</p>
        </div>
    </div>
</div>