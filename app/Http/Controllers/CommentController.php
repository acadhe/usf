<?php

namespace App\Http\Controllers;


use App\Contracts\Repositories\ArticleRepository;
use App\Contracts\Repositories\CommentRepository;
use App\Contracts\Services\AlertMessageService;
use App\Contracts\Services\ArticleService;
use App\Contracts\Services\CommentService;
use App\Contracts\Services\NotificationService;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    private $articleService;
    private $articleRepository;
    private $commentService;
    private $messageService;
    private $notificationService;
    private $commentRepository;

    public function __construct(ArticleRepository $articleRepository,CommentRepository $commentRepository,ArticleService $articleService,CommentService $commentService,
                                AlertMessageService $messageService,NotificationService $notificationService)
    {
        $this->middleware('auth');
        $this->articleRepository = $articleRepository;
        $this->commentRepository = $commentRepository;
        $this->articleService = $articleService;
        $this->messageService = $messageService;
        $this->commentService = $commentService;
        $this->notificationService = $notificationService;
    }

    /**
     * Post a comment
     * @param $article_id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate($article_id,Request $request)
    {
        $this->validate($request,[
            'content' => ['required','max:8000'],
            'support' => ['in:pro,contra']
        ]);
        $article = $this->getArticleOrAbortNotFound($article_id);
        $user = Auth::user();
        $replied_comment_id = $request->input('replied_comment_id',null);

        $support = $request->input('support');
        if ($replied_comment_id != null){
            $support = Comment::SUPPORT_REPLY_COMMENT;
            $repliedComment = $this->commentRepository->findById($replied_comment_id);
            if ($repliedComment == null) abort(404);
        } else {
            $repliedComment = null;
        }

        $newComment = $this->commentService->postComment($article, $user,$request->input("content"),
            $support,$repliedComment);
        $this->messageService->setSuccess("Comment added");
        return redirect()->back();
    }

    public function postDelete($comment_id)
    {
        /** @var User $user */
        $user = Auth::user();
        $comment = $this->getCommentOrAbortNotFound($comment_id);
        if ($user->cannot('delete',$comment)){
            abort(403);
        }
        $this->commentRepository->delete($comment);

        $this->messageService->setSuccess("Comment deleted");
        return redirect()->back();
    }

    public function getHide($comment_id){
        $user = Auth::user();
        $comment = $this->getCommentOrAbortNotFound($comment_id);
        if ($user->cannot('hide',$comment)){
            abort(403);
        }
        $this->commentService->hideComment($comment);

        $this->messageService->setSuccess("Comment hided");
        return redirect()->back();
    }

    public function getUnhide($comment_id){
        $user = Auth::user();
        $comment = $this->getCommentOrAbortNotFound($comment_id);
        if ($user->cannot('unhide',$comment)){
            abort(403);
        }
        $this->commentService->unhideComment($comment);
        $this->messageService->setSuccess("Comment shown");
        return redirect()->back();
    }

    public function getVote($comment_id){
        $user = Auth::user();
        $comment = $this->getCommentOrAbortNotFound($comment_id);
        $this->commentService->voteComment($user, $comment);
        $this->messageService->setSuccess("Vote comment success");
        return redirect()->back();

    }

    public function getUnvote($comment_id)
    {
        $user = Auth::user();
        $comment = $this->getCommentOrAbortNotFound($comment_id);
        $this->commentService->unvoteComment($user, $comment);
        $this->messageService->setSuccess("Unvote comment success");
        return redirect()->back();
    }
    
    private function getCommentOrAbortNotFound($comment_id){
        $comment = $this->commentRepository->findById($comment_id);
        if ($comment === null) abort(404);
        return $comment;
    }

    private function getArticleOrAbortNotFound($article_id){
        $article = $this->articleRepository->findById($article_id);
        if ($article === null) abort(404);
        return $article;
    }
}