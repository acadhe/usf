<?php

namespace App\Http\Controllers\Image;

use App\Contracts\Repositories\ArticleRepository;
use App\Contracts\Services\ArticleService;
use App\Contracts\Services\ImageUploadService;
use App\Models\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    private $imgUploadService;
    private $articleRepository;
    private $articleService;

    public function __construct(ArticleRepository $articleRepository,ImageUploadService $imageUploadService,ArticleService $articleService){
        $this->middleware("authorize:".User::TYPE_PANELIST);
        $this->imgUploadService = $imageUploadService;
        $this->articleService = $articleService;
        $this->articleRepository = $articleRepository;
    }

    public function postDelete($article_id,Request $request)
    {
        $article = $this->getArticleOrThrowNotFound($article_id);
        $file_url =  $request->input('file');
        try {
            $this->imgUploadService->deleteArticleImage($article, $file_url);
            return response()->json(['status'=>'ok']);
        } catch (Exception $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }


    }

    public function postUpload($article_id,Request $request){
        $validator = Validator::make($request->input(),['file' => ['image','mimes:jpeg,bmp,jpg,png']]);
        if (!$validator->fails()){
            $article = $this->getArticleOrThrowNotFound($article_id);
            $file = $request->file('image');
            $originalNameWithExt = $file->getClientOriginalName();
            $image_url = $this->imgUploadService->storeUpdateArticleImage($article,$file);
            return response()->json([
                'status'=>'ok',
                'name' => $originalNameWithExt,
                'url' => $image_url
            ]);
        } else {
            return response()->json(['status'=>'error','message'=>$validator->errors()]);
        }

    }

    private function getArticleOrThrowNotFound($article_id){
        $article = $this->articleRepository->findById($article_id);
        if ($article === null) abort(404);
        return $article;
    }
}
