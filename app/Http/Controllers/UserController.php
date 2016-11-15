<?php

namespace App\Http\Controllers;

use App\Contracts\Auth\FacebookAuthService;
use App\Contracts\Auth\GooglePlusAuthService;
use App\Contracts\Auth\HashPasswordService;
use App\Contracts\Auth\TwitterAuthService;
use App\Contracts\Repositories\ArticleRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Services\AlertMessageService;
use App\Contracts\Services\ArticleService;
use App\Contracts\Services\ImageUploadService;
use App\Contracts\Services\MailerService;
use App\Contracts\Services\NotificationService;
use App\Contracts\Services\UserService;
use App\Exceptions\Auth\EmailUsedException;
use App\Http\Requests\Users\CreatePanelistRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use App\Services\Services\Exceptions\NoCredentialsLeftException;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Factory;

class UserController extends Controller
{
    const USER_PAGINATION_LENGTH = 10;
    private $hashPasswordService;
    private $userService;
    private $articleService;
    private $alertMessageService;
    private $articleRepository;
    private $userRepository;
    private $twitterAuthService;
    private $facebookAuthService;
    private $mailerService;

    public function __construct(MailerService $mailerService,HashPasswordService $hashPasswordService,TwitterAuthService $twitterAuthService,FacebookAuthService $facebookAuthService,UserRepository $userRepository,ArticleRepository $articleRepository,AlertMessageService $alertMessageService,UserService $userService,ArticleService $articleService){
        $this->middleware("authorize:".User::TYPE_ADMIN,['except'=> [
            'getRead','postUpdatePicture','postEditProfile','getDisconnectSocmed','postDelete','getSyncTwitterAccount',
            'getSyncFacebookAccount','getSyncGooglePlusAccount','postEditProfileName','postEditProfileEmail',
            'postEditProfileNewPassword','postEditProfileChangePassword']
        ]);
        $this->middleware('auth');
        $this->mailerService = $mailerService;
        $this->hashPasswordService = $hashPasswordService;
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->articleService = $articleService;
        $this->alertMessageService = $alertMessageService;
        $this->articleRepository = $articleRepository;
        $this->twitterAuthService = $twitterAuthService;
        $this->facebookAuthService = $facebookAuthService;
    }

    /**
     * List of users
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(Request $request){
        $filter = [];
        if ($request->has('name')){
            $users = $this->userRepository->findAllByNameLike($request->input('name'));
            $filter['name'] = $request->input('name');
        } else {
            $users = $this->userRepository->findAll();
        }
        return view('users.index',compact('users','filter'));
    }

    public function getCreate(){
        $categories = $this->userService->getCategories();
        $user = new User();
        return view('users.create',compact('categories','user'));
    }

    public function postCreate(Request $request,AlertMessageService $alert){
        $user = new User();
        $user->name = $request->input('name');
        $user->type = $request->input('type');
        $this->userRepository->save($user);
        $alert->setSuccess("pengguna dibuat");
        return redirect()->route('user');
    }

    public function postCreatePanelist(CreatePanelistRequest $request,AlertMessageService $alert)
    {
        $this->userService->createPanelistFromRequest($request);
        $alert->setSuccess("panelist added");
        return redirect()->back();
    }

    public function getUpdate($id){
        $user = $this->getUserByIdOrThrowNotFound($id);
        $categories = $this->userService->getCategories();
        return view('users.update',compact('user','categories'));
    }

    public function postUpdate($id,Request $request,AlertMessageService $alert){
        $user = $this->getUserByIdOrThrowNotFound($id);
        $user->name = $request->input('name');
        $user->type = $request->input('type');
        $this->userRepository->save($user);
        $alert->setSuccess("pengguna diubah");
        return redirect()->back();
    }

    public function postDelete($user_id,Request $request,AuthManager $auth,Gate $gate,AlertMessageService $alert){
        $user = $this->getUserByIdOrThrowNotFound($user_id);
        $authUser = $auth->user();
        if ($authUser->can('delete',$user)){
            $this->userService->delete($user);
            //if the deleted user is current, user, return to homepage
            if (Auth::user()->id == $user->id){
                $alert->setSuccess("Your account has been deleted");
                Auth::logout();
                return redirect()->to('/');
            } else {
                $alert->setSuccess("User deleted");
            }
        } else {
            abort(403);
        }
        return redirect()->back();
    }

    public function postEditProfile($user_id,Gate $gate,UpdateUserRequest $request,AlertMessageService $alert,Factory $validator){
        $user = $this->getUserByIdOrThrowNotFound($user_id);
        $authUser = Auth::user();
        if (!$gate->allows('edit',$authUser,$user)) abort(403);
        //create message bag when email is used exception
        $validation = $validator->make($request->input(),[]);
        try {
            $this->userService->updateUserFromRequest($user,$request);
            $alert->setSuccess("user updated");
            return redirect()->back();
        } catch (EmailUsedException $e){
            $validation->getMessageBag()->add('email','Email already used');
            return redirect()->back()->withErrors($validation->getMessageBag())->withInput();
        }

    }

    public function getRead($user_id,Request $request,NotificationService $notificationService,AuthManager $auth,Gate $gate)
    {
        if(Auth::user()->id != $user_id) return redirect('users/'.Auth::user()->id);

        $user = $this->getUserByIdOrThrowNotFound($user_id);
        $tab = $request->input('tab', 'activities');
        /** @var User $authUser */
        $authUser = $auth->user();
        if ($tab == 'followed_topics') {
            if (!$gate->allows('showBookmarkedTopics', $authUser, $user)) abort(403);
            //find user created articles
            $articles = $this->articleRepository->findAllByBookmarked($authUser);
            return view('users.read', compact('user', 'articles', 'tab'));

        } else if ($tab == 'activities') {
            //user can read activities pagebut when not authorized, the data will not be shown
            if ($gate->allows('showActivities', $authUser, $user)) {
                $notifications = $notificationService->findNotificationChangesByUserIdOrderMostRecent($user_id, 50);
                //if current user sees his/her own activities, update the 'seen'
                if ($authUser->id == $user->id){
                    $notificationService->setAllNotificationChangesToSeen($user);
                }
            } else {
                $notifications = [];
            }
            return view('users.read', compact('user', 'notifications', 'tab'));

        } else if ($tab == 'moderated_topics') {
            if (!$gate->allows('showModeratedTopics', $authUser, $user)) abort(403);
            $articles = $this->articleRepository->findAllByUser($user);
            return view('users.read', compact('user', 'articles', 'tab'));

        } else if ($tab == 'add_panelist') {
            if (!$gate->allows('addPanelist', $authUser)) abort(403);
            $managed_users = $this->userRepository->findAllByType(User::TYPE_PANELIST);
            return view('users.read', compact('user', 'tab', 'managed_users'));

        } else if ($tab == 'edit_profile') {
            if (!$gate->allows('edit', $authUser, $user)) abort(403);
            return view('users.read', compact('user', 'tab'));

        } else if ($tab == 'manage_users') {
            if (!$gate->allows('manageUsers', $authUser)) abort(403);
            $managed_users = $this->userRepository->findAllByNotType(User::TYPE_ADMIN);
            return view('users.read', compact('user', 'tab', 'managed_users'));

        } else if ($tab == 'voted_topics') {
            if(!$gate->allows('showVotedTopics',$authUser,$user)) abort(403);
            $articles = $this->articleRepository->findAllVotedByUser($user);
            return view('users.read',compact('user','tab','articles'));
        } else {
            return view('users.read',compact('user','tab'));
        }
    }

    public function getDisconnectSocmed($source){
        $user = $this->userRepository->findById(Auth::user()->id);
        try {
            $this->userService->disconnectSocialMedia($user,$source);
            $this->alertMessageService->setSuccess("Socmed disconnected");
        } catch (NoCredentialsLeftException $e){
            $this->alertMessageService->setError("Please set your password first before disconnect your {$source}. Otherwise, you can't sign in with your account later");
        }
        return redirect()->back();
    }

    public function getSyncFacebookAccount($user_id,Gate $gate,Request $request,FacebookAuthService $facebookAuthService){
        $authUser = Auth::user();
        $user = $this->userRepository->findById($user_id);
        if ($user == null) abort(404);
        if (!$gate->allows('syncSocialMedia',$authUser,$user)){
            abort(403);
        }
        $access_token = $facebookAuthService->getAccessToken();
        $accessTokenExpiresAt = $facebookAuthService->getAccessTokenExpiresAt();
        $fb_data = $facebookAuthService->executeMe($access_token);
        if (isset($fb_data['email']) && $fb_data['email'] != null && $fb_data['email'] == $user->email){
            $this->facebookAuthService->syncAccount($user,$fb_data,$access_token,$accessTokenExpiresAt);
        } else {
            $this->alertMessageService->setError("Your email in facebook account is different from your current email ({$user->email}). Therefore your account cannot by synced");
        }
        return redirect()->to($facebookAuthService->getAfterSyncAccountURL());
    }

    public function getSyncTwitterAccount($user_id,Gate $gate,Request $request,TwitterAuthService $twitterAuthService){
        $authUser = Auth::user();
        $user = $this->userRepository->findById($user_id);
        if ($user == null) abort(404);
        if (!$gate->allows('syncSocialMedia',$authUser,$user)){
            abort(403);
        }
        $oauth_token = $twitterAuthService->getOAuthToken();
        $oauth_token_sec = $twitterAuthService->getOAuthTokenSecret();
        $twitter_data = $twitterAuthService->executeVerifyCredentials($oauth_token,$oauth_token_sec);
        //if email is not the same then reject to sync
        if ($twitter_data->email == '' || $twitter_data->email != $user->email){
            $this->alertMessageService->setError("Your email in twitter account is different from your current email ({$user->email}). Therefore your account cannot by synced");
        } else {
            $this->twitterAuthService->syncAccount($user,$twitter_data,$oauth_token,$oauth_token_sec);
        }
        return redirect()->to($twitterAuthService->getAfterSyncAccountURL());
    }

    public function getSyncGooglePlusAccount($user_id,Gate $gate,Request $request,GooglePlusAuthService $googlePlusAuthService){
        $authUser = Auth::user();
        $user = $this->userRepository->findById($user_id);
        if ($user == null) abort(404);
        if (!$gate->allows('syncSocialMedia',$authUser,$user)){
            abort(403);
        }
        $id_token  = $googlePlusAuthService->getIDToken();
        $gplus_data = $googlePlusAuthService->executeVerifyIDToken($id_token);
        if (isset($gplus_data['email']) && $gplus_data['email'] != '' && $user->email == $gplus_data['email']){
            $googlePlusAuthService->syncAccount($user,$gplus_data);
        } else {
            $this->alertMessageService->setError("Your email in google plus account is different from your current email ({$user->email}). Therefore your account cannot by synced");
        }
        return redirect()->to($googlePlusAuthService->getAfterSyncAccountURL());
    }

    public function postUpdatePicture(Request $request,Factory $factory){
        $max_size = 2500; //2500 KB
        $validator =  $factory->make($request->all(),[
            'image' => ['image','mimes:jpeg,bmp,png,gif','max:'.$max_size]
        ]);
        if ($validator->fails()){
            $this->alertMessageService->setError($validator->getMessageBag()->first());
            return redirect()->back();
        } else {
            $user = Auth::user();
            $this->userService->updateImage($user,$request->file('image'));
            $this->alertMessageService->setSuccess("Picture updated");
            return redirect()->back();
        }
    }

    public function postEditProfileName($user_id,Request $request,Gate $gate){
        $this->validate($request,[
            'name'=>['required','string'],
            'tagline' => ['string'],
            'description' => ['string']
        ]);
        $user = $this->userRepository->findById($user_id);
        if(!$gate->allows('edit',Auth::user(),$user)){
            abort(403);
        }
        $user->name = $request->input('name');
        $user->tagline = $request->input('tagline');
        if ($request->has('description')){
            $user->description = $request->input('description');
        }
        $this->userRepository->save($user);
        $this->alertMessageService->setSuccess("Account updated");
        return redirect()->back();
    }

    public function postEditProfileEmail($user_id,Request $request,Gate $gate){
        $this->validate($request,[
            'email' => ['email','required']
        ]);
        $user = $this->userRepository->findById($user_id);
        if(!$gate->allows('edit',Auth::user(),$user)){
            abort(403);
        }
        $user->email = $request->input('email');
        $this->userRepository->save($user);
        $this->alertMessageService->setSuccess("Email updated");
        return redirect()->back();
    }

    public function postEditProfileNewPassword($user_id,Request $request,Gate $gate,Factory $validator){
        $validation = $validator->make($request->input(),[
            'password' => ['required','string'],
            'repeat_password' => ['required','same:password']
        ]);
        if ($validation->fails()){
            $this->alertMessageService->setError($validation->errors()->first());
        } else {
            $user = $this->userRepository->findById($user_id);
            if(!$gate->allows('edit',Auth::user(),$user)){
                abort(403);
            }
            $user->password = $this->hashPasswordService->hash($request->input('password'));
            $this->userRepository->save($user);
            $this->mailerService->notifyChangePassword($user);
            $this->alertMessageService->setSuccess("New password added");
        }
        return redirect()->back();
    }

    public function postEditProfileChangePassword($user_id,Request $request,Gate $gate,Factory $validatorFactory){
        $validation = $validatorFactory->make($request->input(),[
            'old_password' => ['required','string'],
            'password' => ['required'],
            'repeat_password' => ['required','same:password']
        ]);
        if ($validation->fails()){
            $this->alertMessageService->setError($validation->errors()->first());
        } else {
            $user = $this->userRepository->findById($user_id);
            if(!$gate->allows('edit',Auth::user(),$user)){
                abort(403);
            }
            if ($this->hashPasswordService->equalsWithHashed($request->input('old_password'),$user->password)){
                $user->password = $this->hashPasswordService->hash($request->input('password'));
                $this->userRepository->save($user);
                $this->mailerService->notifyChangePassword($user);
                $this->alertMessageService->setSuccess("Password changed");
            } else {
                $this->alertMessageService->setError("The old password doesn't match");
            }
        }
        return redirect()->back();
    }



    private function getUserByIdOrThrowNotFound($user_id){
        $user = $this->userRepository->findById($user_id);
        if ($user === null){
            abort(404);
        }
        return $user;
    }
}
