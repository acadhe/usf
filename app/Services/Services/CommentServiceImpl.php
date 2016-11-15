<?php

namespace App\Services\Services;


use App\Contracts\Repositories\ArticleRepository;
use App\Contracts\Repositories\CommentRepository;
use App\Contracts\Services\Mappers\NestedComment;
use App\Contracts\Services\NotificationService;
use App\Models\Comment;
use App\Contracts\Repositories\UserVoteCommentRepository;
use App\Contracts\Services\CommentService;
use App\Models\Article;
use App\Models\User;
use App\Models\UserVoteComment;

class CommentServiceImpl implements CommentService
{
    private $commentRepo;
    private $articleRepository;
    private $userVoteCommentRepo;
    private $notificationService;

    public function __construct(NotificationService $notificationService,CommentRepository $commentRepo,ArticleRepository $articleRepository,
                                UserVoteCommentRepository $userVoteCommentRepo)
    {
        $this->notificationService = $notificationService;
        $this->commentRepo = $commentRepo;
        $this->articleRepository = $articleRepository;
        $this->userVoteCommentRepo = $userVoteCommentRepo;
    }


    public function postComment(Article $article, User $user, $content, $support,Comment $repliedComment = null)
    {
        $comment = new Comment();
        $comment->article()->associate($article);
        $comment->user()->associate($user);
        $comment->support = $support;
        $comment->content = $content;
        if ($repliedComment != null){
            $comment->repliedComment()->associate($repliedComment);
        }
        $this->commentRepo->save($comment);
        $this->commentRepo->updateCommentsCount($article);
        if ($repliedComment != null){
            $this->notificationService->addUserReplyCommentInArticle($user,$repliedComment, $article,$comment);
        } else {
            $this->notificationService->addUserCommentArticle($user, $article,$comment);
        }
        return $comment;
    }

    public function hideComment(Comment $comment)
    {
        $comment->show = false;
        return $this->commentRepo->save($comment);
    }

    public function unhideComment(Comment $comment)
    {
        $comment->show = true;
        return $this->commentRepo->save($comment);
    }

    public function voteComment(User $user, Comment $comment)
    {
        $uvc = $this->userVoteCommentRepo->findByUserAndComment($user, $comment);
        if ($uvc === null){
            $uvc = new UserVoteComment();
            $uvc->user_id = $user->id;
            $uvc->comment_id = $comment->id;
            if ($this->userVoteCommentRepo->save($uvc)){
                $this->commentRepo->updateVotesCount($comment);
            }
            $this->notificationService->notifyCommentatorThatUserHasVoteHisorHerComment($user,$comment);
        
        }
    }

    public function unvoteComment(User $user, Comment $comment)
    {
        $uvc = $this->userVoteCommentRepo->findByUserAndComment($user,$comment);
        if ($uvc !== null){
            if ($this->userVoteCommentRepo->delete($uvc)){
                $this->commentRepo->updateVotesCount($comment);
            }
        }
    }

    /**
     * Check if user votes a comment
     * @param User $user
     * @param Comment $comment
     * @return boolean
     */
    public function isVoteComment(User $user, Comment $comment)
    {
        return $this->userVoteCommentRepo->findByUserAndComment($user,$comment) !== null;
    }

    public function getNestedCommentsByArticleWithUser(Article $article, $desc_order = null)
    {
        $comments = $this->commentRepo->findAllByArticleOrderByDescWithUser($article,$desc_order);
        //map comments to comment_id-value of comments
        /** @var NestedComment[] $nestedComments */
        $nestedComments = [];
        //create the parent first
        foreach($comments as $comment){
            $nestedComments[$comment->id] = new NestedComment($comment);
        }
        //link the child
        foreach($nestedComments as $nestedComment){
            $parent_id = $nestedComment->comment->replied_comment_id;
            //if it is child, append to parent
            if ($parent_id != null){
                //check invalid parent. if invalid, assumes it is root
                if (array_key_exists($parent_id,$nestedComments))
                    $nestedComments[$parent_id]->addChildNestedComment($nestedComment);
            }
        }
        //only return root comment
        $retval = [];
        foreach($nestedComments as $nestedComment){
            if ($nestedComment->comment->replied_comment_id == null){
                array_push($retval,$nestedComment);
            }
        }
        return $retval;
    }
}
