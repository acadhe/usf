<?php

namespace App\Services\Services;


use App\Contracts\Services\ImageUploadService;
use App\Exceptions\Images\ImageNotFoundException;
use App\Exceptions\Images\InvalidURLPrefixException;
use App\Exceptions\Images\TargetFilenameNotProvidedException;
use App\Models\Article;
use App\Models\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploadServiceImpl implements ImageUploadService
{
    private $filesys;

    public function __construct(Filesystem $filesys)
    {
        $this->filesys = $filesys;
    }

    /**
     * @param Article $article
     * @return string
     * @internal param User $user
     */
    public function updateArticleUploadURL(Article $article)
    {
        return route('image.article.upload',['article_id'=>$article->id]);
    }

    /**
     * @deprecated. use storeupdatearticle instead
     * @param User $user
     * @param UploadedFile $file
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function storeCreateArticleImage(User $user,UploadedFile $file)
    {
        $directory = $this->articleUploadDir($user);
        $filename = $this->generateFilename($file->getClientOriginalExtension());
        $file->move($directory,$filename);
        return url($directory."/".$filename);
    }

    public function storeUpdateArticleImage(Article $article,UploadedFile $file)
    {
        $directory = $this->articleUploadDir($article);
        $filename = $this->generateFilename($file->getClientOriginalExtension());
        $file->move($directory,$filename);
        return $this->articleImageUrl($article, $filename);
    }

    public function deleteArticleImage(Article $article,$url)
    {
        //check if the prefix url is valid to prevent cross-deleting other article image
        if (strpos($url,$this->articleImageUrlPrefix($article)) === 0){
            //get filename
            $pos = strrpos($url,"/");
            //check if contains filename
            if ($pos === false){
                throw new TargetFilenameNotProvidedException($url);
            } else {
                $filename = substr($url,$pos+1);
                $image_location = $this->articleImagePath($article, $filename);

                //check if file exists
                if ($this->filesys->exists($image_location)){
                    return $this->filesys->delete($image_location);
                } else {
                    throw new ImageNotFoundException($filename);
                }
            }
        } else {
            throw new InvalidURLPrefixException($url);
        }
    }

    private function articleImageUrl(Article $article, $filename)
    {
        return $this->articleImageUrlPrefix($article)."/$filename";
    }

    private function articleImageUrlPrefix(Article $article){
        return asset("uploaded/articles/$article->id");
    }

    private function articleImagePathPrefix(Article $article){
        return public_path("uploaded/articles/$article->id");
    }

    private function articleImagePath(Article $article,$filename){
        return $this->articleImagePathPrefix($article)."/".$filename;
    }

    private function articleUploadDir(Article $article)
    {
        return public_path("uploaded/articles/$article->id");
    }

    private function generateFilename($extension)
    {
        return str_random(20)."-".time().".".$extension;
    }

    public function articleDeleteImageURL($article)
    {
        return route('image.article.delete',['article_id'=>$article->id]);
    }
}