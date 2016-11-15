<?php

namespace App\Contracts\Services;


use App\Http\Requests\Users\CreatePanelistRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\UploadedFile;

interface UserService
{
    /**
     * @param User $user
     * @param $media
     * @return User updated user data
     */
    public function disconnectSocialMedia(User $user,$media);

    /**
     * @param User $user
     * @return boolean
     */
    public function noCredentialsLeft(User $user);

    public function updateImage(User $user,UploadedFile $file);

    public function delete(User $user);

    /**
     * Get all type of users
     * @return array
     */
    public function getCategories();

    public function createPanelistFromRequest(CreatePanelistRequest $request);

    /**
     * @param User $user
     * @param UpdateUserRequest $request
     * @return bool
     * @throws \EmailUsedException
     */
    public function updateUserFromRequest(User $user,UpdateUserRequest $request);
}