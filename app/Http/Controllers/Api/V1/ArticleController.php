<?php

namespace App\Http\Controllers\Api\V1;


use App\Contracts\Repositories\ArticleRepository;
use App\Contracts\Services\ArticleService;
use App\Contracts\Services\ImageUploadService;
use App\Contracts\Services\ShareCounterService;
use App\Http\Controllers\Api\V1\Responses\GetUploadedImagesResponse;
use App\Http\Controllers\Api\V1\Responses\ApiResponseStatus;
use App\Http\Controllers\Controller;
use App\Models\User;

class ArticleController extends Controller
{
    
    private $articleService;
    private $articleRepository;
    private $shareCounterService;
    
    public function __construct(ArticleRepository $articleRepository,ArticleService $articleService,ShareCounterService $shareCounterService)
    {
        $this->articleRepository = $articleRepository;
        $this->articleService = $articleService;
        $this->shareCounterService = $shareCounterService;
        $this->middleware("authorize:".User::TYPE_PANELIST);
    }

    /**
     * Update share count of an article
     * @param $article_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateShareCount($article_id){
        $article = $this->articleRepository->findById($article_id);
        if ($article === null) abort(404);
        $shares_count = $this->articleService->updateShareCount($article);
        return response()->json(['status'=>'ok','shares_count'=>$shares_count]);
    }
    
    public function getUploadedImages($article_id,ImageUploadService $imageUploadService){
        $article = $this->articleRepository->findById($article_id);
        $response = new GetUploadedImagesResponse();
        if ($article === null){
            $response->setStatus(ApiResponseStatus::ERROR);
            $response->setMessage("article not found");
        } else {
            $result = $imageUploadService->getAllFilename($article);
            foreach($result as $url){
                $response->addUrl($url);
            }
        }
        return response()->json($response,200,[],JSON_UNESCAPED_SLASHES);
    }

}