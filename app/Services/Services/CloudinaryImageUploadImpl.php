<?php

namespace App\Services\Services;


use App\Contracts\Services\ImageUploadService;
use App\Exceptions\Images\ImageNotFoundException;
use App\Exceptions\Images\InvalidURLPrefixException;
use App\Exceptions\Images\TargetFilenameNotProvidedException;
use App\Models\Article;
use App\Models\User;
use Cloudinary;
use Cloudinary\Api\Response;
use Cloudinary\Uploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CloudinaryImageUploadImpl implements ImageUploadService
{
    private $cloud_name;
    private $base_url;

    public function __construct()
    {
        $this->cloud_name = config('cloud.cloudinary.cloud_name');
        $this->base_url = "http://res.cloudinary.com/{$this->cloud_name}/image/upload";
        Cloudinary::config([
            'cloud_name' => $this->cloud_name,
            'api_key' => config('cloud.cloudinary.api_key'),
            'api_secret' => config('cloud.cloudinary.api_secret')
        ]);
    }

    /**
     * Image upload url when update an article
     * It is based on article
     * @param Article $article
     * @return
     */
    public function updateArticleUploadURL(Article $article)
    {
        return route('image.article.upload',['article_id'=>$article->id],false);
    }

    /**
     * Store uploaded image of an article
     * @param Article $article
     * @param UploadedFile $file
     * @return mixed
     */
    public function storeUpdateArticleImage(Article $article, UploadedFile $file)
    {
        $public_id = "{$this->articleImageUrlPrefix($article)}/{$this->generateFilename()}";
        $result = Uploader::upload($file, [
            'public_id' => $public_id
        ]);
        return "{$this->base_url}/{$public_id}";
    }

    /**
     * Delete an url of image of an article
     * @param Article $article
     * @param $url
     * @return boolean
     * @throws ImageNotFoundException
     * @throws InvalidURLPrefixException
     * @throws TargetFilenameNotProvidedException
     */
    public function deleteArticleImage(Article $article, $url)
    {
        //TODO throw exception
        if (strpos($url,"{$this->base_url}/".$this->articleImageUrlPrefix($article)) === 0){
            $public_id_pos = strlen("{$this->base_url}/");
            $public_id = substr($url,$public_id_pos);
            $result = Uploader::destroy($public_id);
        } else {
            throw new InvalidURLPrefixException($url);
        }
    }

    /**
     * endpoint for deleting an image
     * @param $article
     * @return mixed
     */
    public function articleDeleteImageURL($article)
    {
        return route('image.article.delete',['article_id'=>$article->id],false);
    }

    private function generateFilename()
    {
        return str_random(20)."-".time();
    }

    private function articleImageUrlPrefix(Article $article){
        return "articles/$article->id";
    }

    private function articleImagePathPrefix(Article $article){
        return "articles/$article->id";
    }

    private function articleImagePath(Article $article,$filename){
        return $this->articleImagePathPrefix($article)."/".$filename;
    }

    private function userPictureImageUrlPrefix(User $user){
        return "users/{$user->id}";
    }

    public function getAllFilename(Article $article){
        $result = [];
        $api = new Cloudinary\Api();
//        Log::debug($this-$this->articleImageUrlPrefix($article));
        /** @var Response $response */
        $response = $api->resources(['type'=>'upload','prefix'=>$this->articleImageUrlPrefix($article)]);
        $resources = $response->getArrayCopy()['resources'];
        foreach($resources as $resource){
            array_push($result,$resource['url']);
        }
        return $result;
    }

    /**
     * @param User $user
     * @param UploadedFile $file
     * @return string url of uploaded image
     */
    public function storeUserPicture(User $user, UploadedFile $file)
    {
        $public_id = "{$this->userPictureImageUrlPrefix($user)}/profile-picture";
        $result = Uploader::upload($file, [
            'public_id' => $public_id
        ]);
        return $result['secure_url'];
    }
}