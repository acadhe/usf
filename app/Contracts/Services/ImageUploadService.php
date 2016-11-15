<?php

namespace App\Contracts\Services;


use App\Exceptions\Images\ImageNotFoundException;
use App\Exceptions\Images\InvalidURLPrefixException;
use App\Exceptions\Images\TargetFilenameNotProvidedException;
use App\Models\Article;
use App\Models\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageUploadService
{
    /**
     * Image upload url when update an article
     * It is based on article
     * @param Article $article
     * @return
     */
    public function updateArticleUploadURL(Article $article);

    /**
     * Store uploaded image of an article
     * @param Article $article
     * @param UploadedFile $file
     * @return string url of uploaded image
     */
    public function storeUpdateArticleImage(Article $article,UploadedFile $file);

    /**
     * Store to cloud. Note that this will not change the 'photo' field in User model
     * @param User $user
     * @param UploadedFile $file
     * @return string url of uploaded image
     */
    public function storeUserPicture(User $user,UploadedFile $file);

    /**
     * Delete an url of image of an article
     * @param Article $article
     * @param $url
     * @return boolean
     * @throws ImageNotFoundException
     * @throws InvalidURLPrefixException
     * @throws TargetFilenameNotProvidedException
     */
    public function deleteArticleImage(Article $article,$url);

    /**
     * endpoint for deleting an image
     * @param $article
     * @return mixed
     */
    public function articleDeleteImageURL($article);


    /**
     * list all uploaded images in an article
     * @param Article $article
     * @return string[]
     */
    public function getAllFilename(Article $article);
}