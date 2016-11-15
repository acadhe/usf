<?php

namespace App\Services\Services;


use App\Contracts\Auth\HashPasswordService;
use App\Contracts\Repositories\BookmarkRepository;
use App\Contracts\Repositories\SubscriptionRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Services\ImageUploadService;
use App\Contracts\Services\MailerService;
use App\Contracts\Services\UserService;
use App\Exceptions\Auth\EmailUsedException;
use App\Http\Requests\Users\CreatePanelistRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use App\Services\Services\Exceptions\NoCredentialsLeftException;
use Illuminate\Http\UploadedFile;

class UserServiceImpl implements UserService
{
    private $userRepo;
    private $bookmarkRepo;
    private $subscriptionRepo;
    private $hasher;
    private $imageUploadService;
    private $mailerService;

    public function __construct(MailerService $mailerService,ImageUploadService $imageUploadService,UserRepository $userRepo,
                                BookmarkRepository $bookmarkRepo,
                                SubscriptionRepository $subscriptionRepo,HashPasswordService $hasher)
    {
        $this->mailerService = $mailerService;
        $this->imageUploadService = $imageUploadService;
        $this->userRepo = $userRepo;
        $this->bookmarkRepo = $bookmarkRepo;
        $this->subscriptionRepo = $subscriptionRepo;
        $this->hasher = $hasher;
    }

    public function getCategories()
    {
        return [
            User::TYPE_ADMIN,User::TYPE_PANELIST,User::TYPE_USER
        ];
    }

    public function createPanelistFromRequest(CreatePanelistRequest $request)
    {
        $user = new User();
        $email = $request->input('email');
        $password = $request->input('password');
        $user->email = $request->input('email');
        $user->password = $this->hasher->hash($request->input('password'));
        $user->name = $request->input('name');
        $user->tagline = $request->input('tagline');
        $user->type = User::TYPE_PANELIST;
        $user->description = $request->input('description');


        $this->mailerService->sendPanelistCredentials($email,$password);
        
        $ret = $this->userRepo->save($user);
        if ($request->hasFile('photo')){
            $user->photo_url = $this->imageUploadService->storeUserPicture($user,$request->file('photo'));
            $this->userRepo->save($user);
        }
        return $ret;
    }

    public function updateUserFromRequest(User $user, UpdateUserRequest $request)
    {
        $notifyPasswordChanged = false;
        if ($user->email != $request->input('email')){
            $anotherUser = $this->userRepo->findByEmail($request->input('email'));
            if ($anotherUser !== null && ($anotherUser->id != $user->id)){
                throw new EmailUsedException($request->input('email'));
            } else {
                $user->email = $request->input('email');
            }
        }
        if ($request->input('password') != ''){
            $user->password = $this->hasher->hash($request->input('password'));
            $notifyPasswordChanged = true;
        }
        $user->name = $request->input('name');
        $user->tagline = $request->input('tagline');
        $user->description = $request->input('description');
        $ret = $this->userRepo->save($user);
        if ($notifyPasswordChanged){
            $this->mailerService->notifyChangePassword($user);
        }
        return $ret;
    }

    public function delete(User $user)
    {
        $ret =  $this->userRepo->delete($user);
        $this->mailerService->notifyUserHasBeenDeleted($user);
        return $ret;
    }

    public function updateImage(User $user, UploadedFile $file)
    {
        $url = $this->imageUploadService->storeUserPicture($user,$file);
        $user->photo_url = $url;
        $this->userRepo->save($user);
    }

    public function disconnectSocialMedia(User $user, $media)
    {
        if ($media == 'twitter') {
            $user->twitter_id = null;
            $user->twitter_name = null;
            $user->twitter_oauth_token = null;
            $user->twitter_oauth_token_secret = null;
        } elseif ($media == 'facebook') {
            $user->facebook_id = null;
            $user->facebook_name = null;
            $user->facebook_access_token = null;
        } else if ($media == 'google_plus'){
            $user->google_plus_id = null;
            $user->google_plus_name = null;
        }
        if ($this->noCredentialsLeft($user)) throw new NoCredentialsLeftException();
        $this->userRepo->save($user);
        return $user;
    }

    /**
     * @param User $user
     * @return boolean
     */
    public function noCredentialsLeft(User $user)
    {
        return $user->twitter_id == '' && $user->facebook_id == '' && $user->google_plus_id == '' && $user->password == '';
    }
}