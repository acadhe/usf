<?php

namespace App\Http\Controllers;


use App\Contracts\Repositories\ArticleCategoryRepository;
use App\Contracts\Repositories\ArticleRepository;
use App\Contracts\Repositories\CommentRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Services\AlertMessageService;
use App\Contracts\Services\ArticleService;
use App\Contracts\Services\CommentService;
use App\Contracts\Services\FeedbackService;
use App\Contracts\Services\NotificationService;
use App\Contracts\Services\SocialMediaService;
use App\Contracts\Services\UserService;
use App\Http\Requests;
use App\Models\Article;
use App\Models\NotificationObject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
	private $articleService;
	private $userService;
	private $messageService;
	private $feedbackService;
	private $commentService;
	private $articleRepository;
	private $articleCategoryRepository;
	private $socialMediaService;
	private $commentRepository;
	private $userRepository;

	public function __construct(UserRepository $userRepository,SocialMediaService $socialMediaService,ArticleRepository $articleRepository,ArticleService $articleService,UserService $userService,
								AlertMessageService $alertMessageService,FeedbackService $feedbackService,
								CommentService $commentService,CommentRepository $commentRepository,ArticleCategoryRepository $articleCategoryRepository){
		$this->userRepository = $userRepository;
		$this->socialMediaService = $socialMediaService;
		$this->articleService = $articleService;
		$this->articleCategoryRepository = $articleCategoryRepository;
		$this->articleRepository = $articleRepository;
		$this->userService = $userService;
		$this->messageService = $alertMessageService;
		$this->feedbackService = $feedbackService;
		$this->commentService = $commentService;
		$this->commentRepository = $commentRepository;
	}

	public function getHome(Request $request)
	{
		$panelists = $this->userRepository->findAllByType(User::TYPE_PANELIST);
		$categories = $this->articleCategoryRepository->findAll();
		$filter = [];

		$q = Article::query(); $q->with(['user']);
		if ($request->has("search")){
			$filter['search'] = $request->input('search');
			$lower_filter_search = strtolower($filter['search']);
			$q->where(DB::raw("LOWER(title)"),'LIKE',"%{$lower_filter_search}%");
		}
		$sort = $request->input('sort','most_popular');
		if ($sort == 'most_popular'){
			$q->orderBy('votes_count','desc');
		} else {
			$q->orderBy('created_at','desc');
		}
		$q->orderBy('id','desc');
		$filter['sort'] = $sort;

		if ($request->has("panelist_id")){
			$filter['panelist_id'] = $request->input('panelist_id');
			if ($request->input("panelist_id")!="all"){
				$q->where('user_id','=',$request->input('panelist_id'));
			}
		}
		if ($request->has("category")){
			$filter['category'] = $request->input('category');
			if ($request->input("category")!="all"){
				$q->where('category','=',$request->input("category"));
			}
		}
		//only non-draft articles
		$q->where('privacy','=',Article::PRIVACY_PUBLISHED);
		$articles = $this->articleRepository->findAllByQuery($q);
		foreach ($articles as $article){
			$article->facebook_share_url = $this->socialMediaService->facebookShareArticle($article);
			$article->twitter_share_url = $this->socialMediaService->twitterShareArticle($article);
			$article->google_plus_share_url = $this->socialMediaService->googlePlusShareArticle($article);
		}
		return view('home',compact('articles','panelists','categories','filter'));
	}

	public function getPanelists(Request $request)
	{
		$user = null;
		if ($request->has('name')){
			$users = $this->userRepository->findAllByNameLikeAndType($request->input('name'),User::TYPE_PANELIST);
		} else {
			$users = $this->userRepository->findAllByType(User::TYPE_PANELIST);
		}
		if ($request->has('user_id')) {
			$user = $this->userRepository->findById($request->input('user_id'));
			//get related articles
			$articles = $this->articleRepository->findAllByUserAndPrivacy($user,Article::PRIVACY_PUBLISHED);
		}
		return view('panelists',compact('users','user','articles'));
	}

	public function postContact(Request $request){
		$this->validate($request,[
			'name' => 'required',
			'email' => 'required|email',
			'content' => 'required'
		]);
		$this->feedbackService->createFeedback($request->input('name'),$request->input('email'),$request->input('content'));
		$this->messageService->setSuccess("Terima kasih atas saran anda.");
		return redirect()->back();
	}

	public function getHowto(){
		return view('howto');
	}

	public function getSettings(){
		return view('settings');
	}

	public function getAbout(){
		return view('about');
	}

	public function getTos(){
		return view('tos');
	}

	public function getHelp(){
		return view('help');
	}
	public function getPolicy(){
		return view('privacy-policy');
	}

	public function getRules(){
		return view('ucp-rules');
	}

	public function getContact(){
		return view('contact');
	}

	public function getNotificationRedirect($object_id,$object_type,$action){
		if ($object_type == NotificationObject::TYPE_ARTICLE){
			return redirect()->route('article.read',['id'=>$object_id,'focus_object'=>'comment','focus_object_id'=>$object_id]);
		} else if ($object_type == NotificationObject::TYPE_COMMENT){
			$comment = $this->getCommentOrAbortNotFound($object_id);
			return redirect()->route('article.read',[
				'id'=>$comment->article_id,'focus_object'=>'comment','focus_object_id'=>$object_id
			]);

		} else {
			return response("Unknown notification redirect: [id=$object_id,type=$object_type,action=$action]",401);
		}
	}

	private function getArticleOrAbortNotFound($article_id){
		$article = $this->articleRepository->findById($article_id);
		if ($article === null) abort(404);
		return $article;
	}

	private function getCommentOrAbortNotFound($comment_id){
		$comment = $this->commentRepository->findById($comment_id);
		if ($comment === null) abort(404);
		return $comment;
	}

	public function getTest(NotificationService $notificationService){
		dd($notificationService->findNotificationChangesByUserIdOrderMostRecent(4,10));
	}
}
