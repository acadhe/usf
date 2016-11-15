<?php

namespace App\Http\Controllers;

use App\Contracts\Auth\FacebookAuthService;
use App\Contracts\Auth\GooglePlusAuthService;
use App\Contracts\Auth\TwitterAuthService;
use App\Contracts\Repositories\ArticleCategoryRepository;
use App\Contracts\Repositories\ArticleRepository;
use App\Contracts\Repositories\CommentRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\UserVoteArticleRepository;
use App\Contracts\Services\AlertMessageService;
use App\Contracts\Services\ArticleService;
use App\Contracts\Services\BookmarkService;
use App\Contracts\Services\CommentService;
use App\Contracts\Services\ImageUploadService;
use App\Contracts\Services\NotificationService;
use App\Contracts\Services\SocialMediaService;
use App\Contracts\Services\UserService;
use App\Contracts\Services\UserVoteArticleService;
use App\Http\Requests\Articles\CreateArticleRequest;
use App\Http\Requests\Articles\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ArticleController extends Controller
{
    private $articleCategoryRepository;
    private $articleRepository;
    private $articleService;
    private $bookmarkService;
    private $commentService;
    private $userService;
    private $alertMessageService;
    private $notificationService;
    private $twitterAuthService;
    private $facebookAuthService;
    private $googlePlusAuthService;
    private $userVoteArticleRepo;
    private $socialMediaService;
    private $commentRepository;
    private $userRepository;

    public function __construct(TwitterAuthService $twitterAuthService,FacebookAuthService $facebookAuthService,GooglePlusAuthService $googlePlusAuthService,ArticleCategoryRepository $articleCategoryRepository,ArticleRepository $articleRepository,SocialMediaService $socialMediaService,UserVoteArticleService $userVoteArticleService, ArticleService $articleService,
                                BookmarkService $bookmarkService, AlertMessageService $alertMessageService,UserRepository $userRepository,
                                CommentService $commentService, UserService $userService, NotificationService $notificationService,CommentRepository $commentRepository){
        $this->middleware("authorize:".User::TYPE_PANELIST, [
            'except'=>['getRead','getVote','getUnvote','getMark','getUnmark']
        ]);
        $this->middleware('auth',[
            'except'=>['getRead']
        ]);
        $this->twitterAuthService = $twitterAuthService;
        $this->facebookAuthService = $facebookAuthService;
        $this->googlePlusAuthService = $googlePlusAuthService;
        $this->articleCategoryRepository = $articleCategoryRepository;
        $this->socialMediaService = $socialMediaService;
        $this->userVoteArticleRepo = $userVoteArticleService;
        $this->articleService = $articleService;
        $this->bookmarkService = $bookmarkService;
        $this->commentService = $commentService;
        $this->userService = $userService;
        $this->alertMessageService = $alertMessageService;
        $this->notificationService = $notificationService;
        $this->articleRepository = $articleRepository;
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
    }

    public function postClose($article_id,Gate $gate,Request $request){
        $summary = $request->input('summary');
        $article = $this->getArticleOrThrowNotFound($article_id);
        if (!$gate->allows('close',$article)){
            abort(403);
        }
        $this->articleService->closeArticle($article,Auth::user(), $summary);
        $this->alertMessageService->setSuccess("Discussion closed. Please add the summary");
        if ($request->has('next')){
            return redirect()->to($request->input('next'));
        } else {
            return redirect()->route('article.update_summary',['article_id'=>$article_id]);
        }
    }

    public function getUpdateSummary($article_id){
        $article = $this->getArticleOrThrowNotFound($article_id);
        return view('articles.update_summary',compact('article'));
    }

    public function postUpdateSummary($article_id,Request $request){
        $article = $this->getArticleOrThrowNotFound($article_id);
        $article->summary = $request->input('summary');
        $this->alertMessageService->setSuccess("Summary updated");
        $this->articleRepository->save($article);
        if ($article->open){
            //close article if it is open
            $this->articleService->closeArticle($article,Auth::user(),$article->summary);
        }
        return redirect()->route('article.read',['id'=>$article_id]);
    }

    /**
     * Get article detail
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function getRead($id,Request $request,Gate $gate)
    {
        $article = $this->articleRepository->findById($id);
        if ($article === null){
            abort(404);
        }
        //if user can close article and the intent is want to close (from "Your Article" page
        if ($gate->allows('close',$article)){
            $intentCloseArticle = $request->input('intent_close_article',false);
        } else {
            $intentCloseArticle = false;
        }
        $bookmarked = false;
        $order_column = 'created_at';
        $sort = $request->input('sort','most_recent');
        if ($sort == 'most_popular'){
            $order_column = 'votes_count';
        } else {
            $order_column = 'created_at';
        }
        if (!Auth::guest()){
            $bookmarked = $this->bookmarkService->isArticleBookmarked($article,Auth::user());
        }
        $nestedComments = $this->commentService->getNestedCommentsByArticleWithUser($article,$order_column);
        $countPro = $this->commentRepository->countByArticleAndSupport($article,Comment::SUPPORT_PRO);
        $countContra = $this->commentRepository->countByArticleAndSupport($article,Comment::SUPPORT_CONTRA);
        $user = $article->user;
        $article->facebook_share_url = $this->socialMediaService->facebookShareArticle($article);
        $article->twitter_share_url = $this->socialMediaService->twitterShareArticle($article);
        $article->google_plus_share_url = $this->socialMediaService->googlePlusShareArticle($article);
        return view('articles.read',compact('intentCloseArticle','article','bookmarked','nestedComments','user','sort','countPro','countContra'));
    }

    /**
     * show article form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate()
    {
        $user = Auth::user();
        $newArticle = $this->articleService->createBlankArticle($user);
//        $categories = $this->articleCategoryService->getAllCategories();
        return redirect()->route('article.update',['article_id'=>$newArticle->id]);
//        return view('articles.create',compact('categories','article'));
    }

    /**
     * save a new article
     * @param CreateArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CreateArticleRequest $request)
    {
        $id = $this->articleService->createArticleFromRequest($request,Auth::user());
        $this->alertMessageService->setSuccess("Artikel dibuat");
        return redirect()->route('article.read',['id'=>$id]);
    }

    /**
     * bookmark an article
     * @param $article_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getMark($article_id)
    {
        $article = $this->getArticleOrThrowNotFound($article_id);
        $this->bookmarkService->markArticle($article,Auth::user());
        $this->alertMessageService->setSuccess('Article marked');
        return redirect()->back();
    }

    /**
     * Show article update form
     * @param $article_id
     * @param ImageUploadService $imgUploadService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdate($article_id,ImageUploadService $imgUploadService)
    {
        $user = $this->userRepository->findById(Auth::user()->id);
        $article = $this->getArticleOrThrowNotFound($article_id);
        $categories = $this->articleCategoryRepository->findAll();
        $image_upload_url = $imgUploadService->updateArticleUploadURL($article);
        $image_delete_url = $imgUploadService->articleDeleteImageURL($article);
        Session::flash('fb_share_url',$this->socialMediaService->facebookShareArticle($article));
        Session::flash('twitter_share_url',$this->socialMediaService->twitterShareArticle($article));
        if ($user->hasFacebook()){
            Session::flash('has_facebook',true);
        }
        if ($user->hasTwitter()){
            Session::flash('has_twitter',true);
        }
        if ($user->hasGooglePlus()){
            Session::flash('has_google_plus',true);
        }
        return view('articles.update',compact('article','categories','image_upload_url','image_delete_url'));
    }

    /**
     * Update the article
     * @param $article_id
     * @param UpdateArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdate($article_id,UpdateArticleRequest $request)
    {
        $privacy = $request->input('privacy');
        $share_facebook = $request->input('share_facebook');
        $share_twitter = $request->input('share_twitter');
        $share_google_plus = $request->input('share_google_plus');
        $article = $this->getArticleOrThrowNotFound($article_id);
        $this->articleService->updateArticle($article, $request);
        if ($privacy == Article::PRIVACY_DRAFT){
            $this->alertMessageService->setSuccess("Article saved as draft");
            return redirect()->route('article.update',['article_id'=>$article->id]);
        } else {
            if ($share_facebook){

            }
            if ($share_twitter){
                $this->twitterAuthService->shareArticle($article,Auth::user());
            }
            if ($share_google_plus){
            }
            $this->alertMessageService->setSuccess("Article saved and published!");
            return redirect()->route('article.share_link',['article_id'=>$article_id]);
        }
    }

    public function getShareLink($article_id){
        $article = $this->articleRepository->findById($article_id);
        if ($article == null) abort(404);
        $share_link = route('article.read',['article_id'=>$article_id]);
        return view('articles.share_link',compact('share_link'));
    }

    /**
     * Delete the article. only the creator can delete the article
     * @param int $article_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDelete($article_id,Request $request){
        $article = $this->getArticleOrThrowNotFound($article_id);
        $user = Auth::user();
        if ($user->cannot('delete',$article)) abort(403);
        $this->articleRepository->delete($article);
        $next = $request->input('next');
        $this->alertMessageService->setSuccess("Article deleted");
        if ($next == null){
            return redirect()->back();
        } else {
            return redirect()->to($next);
        }
    }

    public function postDeleteSummary($article_id){
        $article = $this->getArticleOrThrowNotFound($article_id);
        $user = Auth::user();
        if ($user->cannot('deleteSummary',$article)) abort(403);
        $article->summary = null;
        $this->articleRepository->save($article);
        $this->alertMessageService->setSuccess("Article summary deleted");
        return redirect()->back();
    }

    public function postChangePrivacy($article_id,Request $request)
    {
        $this->validate($request,[
            'privacy' => ['required']
        ]);
        $article = $this->getArticleOrThrowNotFound($article_id);
        $user = Auth::user();
        if ($user->cannot('changePrivacy',$article)) abort(403);
        $article->privacy = $request->input('privacy');
        $this->articleRepository->save($article);
        $this->alertMessageService->setSuccess("Privacy changed to ".$request->input('privacy'));
        return redirect()->back();
    }

    /**
     * unmark an article
     * @param $article_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getUnmark($article_id)
    {
        $article = $this->getArticleOrThrowNotFound($article_id);
        $this->bookmarkService->unmarkArticle($article,Auth::user());
        $this->alertMessageService->setSuccess('Article unmarked');
        return redirect()->back();
    }

    public function getVote($article_id){
        $user = Auth::user();
        $article = $this->getArticleOrThrowNotFound($article_id);
        if (!$user->can('vote',$article)) abort(403);
        $this->userVoteArticleRepo->vote($user,$article);
        $this->alertMessageService->setSuccess('Article voted');
        return redirect()->back();
    }

    public function getUnvote($article_id){
        $user = Auth::user();
        $article = $this->getArticleOrThrowNotFound($article_id);
        if (!$user->can('unvote',$article)) abort(403);
        $this->userVoteArticleRepo->unvote($user,$article);
        $this->alertMessageService->setSuccess('Article unvoted');
        return redirect()->back();
    }

    public function getMine()
    {
        $articles = $this->articleRepository->findAllByUser(Auth::user());
        foreach ($articles as $article){
            $article->updated_at = Carbon::createFromFormat("Y-m-d H:i:s",$article->updated_at);
        }
        return view('articles.mine',compact('articles'));
    }


    private function getArticleOrThrowNotFound($article_id){
        $article = $this->articleRepository->findById($article_id);
        if ($article === null){
            abort(404);
        }
        return $article;
    }
}