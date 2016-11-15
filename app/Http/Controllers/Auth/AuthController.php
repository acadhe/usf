<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Auth\EmailAuthService;
use App\Contracts\Auth\FacebookAuthService;
use App\Contracts\Auth\GooglePlusAuthService;
use App\Contracts\Auth\HashPasswordService;
use App\Contracts\Auth\TwitterAuthService;
use App\Contracts\Repositories\ConfirmationTokenRepository;
use App\Contracts\Repositories\FacebookIntegrationRepository;
use App\Contracts\Repositories\ResetPasswordTokenRepository;
use App\Contracts\Repositories\TwitterIntegrationRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Services\AlertMessageService;
use App\Contracts\Services\ConfirmationTokenService;
use App\Contracts\Services\MailerService;
use App\Exceptions\Auth\EmailUsedException;
use App\Exceptions\Auth\InvalidEmailOrPasswordException;
use App\Exceptions\FacebookAuthLoginException;
use App\Models\ResetPasswordToken;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\Auth\Exceptions\FacebookEmailNotProvidedException;
use App\Services\Auth\Exceptions\TwitterEmailNotProvidedException;
use Carbon\Carbon;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Mailgun\Mailgun;

class AuthController extends Controller
{
    const SOCMED_INTEGRATION_EMAIL_SESSION_KEY = "auth_controller_socmed_integration_email_key";
	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

    private $confirmationTokenRepository;
    private $facebookIntegrationRepository;
    private $twitterIntegrationRepository;
    private $userRepository;
    private $alertMessageService;
    private $resetPasswordTokenRepository;
    private $hashPasswordService;
    private $mailerService;
    private $session;
    private $confirmationTokenService;

    /**
     * Create a new authentication controller instance.
     *
     * @param FacebookIntegrationRepository $facebookIntegrationRepository
     * @param TwitterIntegrationRepository $twitterIntegrationRepository
     * @param ConfirmationTokenRepository $confirmationTokenRepository
     * @param ConfirmationTokenService $confirmationTokenService
     * @param Store $session
     * @param MailerService $mailerService
     * @param HashPasswordService $hashPasswordService
     * @param AlertMessageService $alertMessageService
     * @param UserRepository $userRepository
     * @param ResetPasswordTokenRepository $resetPasswordTokenRepository
     */
	public function __construct(FacebookIntegrationRepository $facebookIntegrationRepository,TwitterIntegrationRepository $twitterIntegrationRepository,ConfirmationTokenRepository $confirmationTokenRepository,ConfirmationTokenService $confirmationTokenService,Store $session,MailerService $mailerService,HashPasswordService $hashPasswordService,AlertMessageService $alertMessageService, UserRepository $userRepository, ResetPasswordTokenRepository $resetPasswordTokenRepository)
	{
	    $this->twitterIntegrationRepository = $twitterIntegrationRepository;
        $this->facebookIntegrationRepository = $facebookIntegrationRepository;
	    $this->confirmationTokenRepository = $confirmationTokenRepository;
	    $this->confirmationTokenService = $confirmationTokenService;
	    $this->session = $session;
	    $this->mailerService = $mailerService;
	    $this->hashPasswordService = $hashPasswordService;
        $this->alertMessageService = $alertMessageService;
        $this->userRepository = $userRepository;
        $this->resetPasswordTokenRepository = $resetPasswordTokenRepository;
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|min:6|confirmed',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data)
	{
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);
	}

	public function getLogin(Request $request)
	{
	    $data = [];
        if ($request->has('after_login_url')){
            $data['after_login_url'] = $request->input('after_login_url');
        }
		return view('auth.login',$data);
	}

	public function getRedirectTwitter(Request $request,TwitterAuthService $twitterAuthService){

	    $after_login_url = $request->input('after_login_url',url('/'));
        $twitterAuthService->setAfterLoginURL($after_login_url);

        $after_sync_account_url = $request->input('after_sync_account_url',url('/'));
        $twitterAuthService->setAfterSyncAccountURL($after_sync_account_url);

	    $after_callback_url = $request->input('after_callback_url',route('auth.twitter_registration'));
        $twitterAuthService->setAfterCallbackURL($after_callback_url);

        return redirect()->to($twitterAuthService->createRedirectUrl());
	}

	public function getTwitterCallback(Request $request,TwitterAuthService $twitterAuthService){
		$oauth_token = $request->input('oauth_token');
        $oauth_verifier = $request->input('oauth_verifier');
        $oauth_token_sec = $twitterAuthService->getOAuthTokenSecret();
		if (!$twitterAuthService->validateOAuthToken($oauth_token)){
            abort(401,"Twitter access token mismatch");
		}
        //minta access token (tukar dengan hasil oauth token login)
        $access_token = $twitterAuthService->executeAccessToken($oauth_token,$oauth_token_sec,$oauth_verifier);

        //ganti dengan long token
        $oauth_token = $access_token['oauth_token'];
        $oauth_token_sec = $access_token['oauth_token_secret'];
        $twitterAuthService->setOAuthToken($oauth_token);
        $twitterAuthService->setOAuthTokenSecret($oauth_token_sec);
		return redirect()->to($twitterAuthService->getAfterCallbackURL());
	}

    /**
     * Register user with given oauth token stored in session
     * If there is no email provided from user data, it will prompt user to add email
     * @param Request $request
     * @param TwitterAuthService $twitterAuthService
     * @return \Illuminate\Http\RedirectResponse
     */
	public function getTwitterRegistration(Request $request,TwitterAuthService $twitterAuthService){
        try {
            $oauth_token = $twitterAuthService->getOAuthToken();
            $oauth_token_sec = $twitterAuthService->getOAuthTokenSecret();
            $user = $twitterAuthService->authenticate($oauth_token,$oauth_token_sec);
            Auth::login($user,true);
            return redirect()->to($twitterAuthService->getAfterLoginURL());
        } catch (TwitterEmailNotProvidedException $e){
            //twitter id dan username di store di session
            //pas user submit, diambil lagi
            $twitterAuthService->storeTwitterData($e->getTwitterId(),$e->getName(),$e->getUsername());
            return redirect()->route('auth.add_socmed_email',['source'=>'twitter']);
        }
    }



	public function getAddSocmedEmail($source,Request $request){
        return view('auth.add_email_socmed',compact('source'));
    }

	public function postAddSocmedEmail($source,Request $request,TwitterAuthService $twitterAuthService,FacebookAuthService $facebookAuthService,GooglePlusAuthService $googlePlusAuthService){
	    $this->validate($request,['email'=>['required']]);
        $email = $request->input('email');
        $existingUser = $this->userRepository->findByEmail($email);
        //if exists current user, return to the view again and inform to integrate account
        if ($existingUser != null){
            $this->session->set(self::SOCMED_INTEGRATION_EMAIL_SESSION_KEY,$email);
            return view('auth.add_email_socmed',compact('existingUser','source','email'));
        } else{
            if ($source == 'twitter'){
                $oauth_token = $twitterAuthService->getOAuthToken();
                $oauth_token_sec = $twitterAuthService->getOAuthTokenSecret();
                $twitter_data = $twitterAuthService->executeVerifyCredentials($oauth_token,$oauth_token_sec);

                //create new instance of user and create the confirmation token
                $user = new User();
                $user->email = $email;
                $user->name = $twitter_data->screen_name;
                $user->type = User::TYPE_USER;
                $this->userRepository->save($user);
                $confirmationToken = $this->confirmationTokenService->createTwitterConfirmationToken($user,$twitter_data->id,$twitter_data->screen_name,$oauth_token,$oauth_token_sec,$twitter_data->profile_image_url_https);
                $twitterIntegration = $this->twitterIntegrationRepository->findByConfirmationToken($confirmationToken);

                $this->mailerService->sendTwitterConfirmationToken($user,$confirmationToken,$twitterIntegration);
                return redirect()->route('auth.confirmation_email_sent',['id'=>$confirmationToken->id]);
            } else if ($source == 'facebook'){
                $access_token = $facebookAuthService->getAccessToken();
                $accessTokenExpiredAt = $facebookAuthService->getAccessTokenExpiresAt();
                $fb_data = $facebookAuthService->executeMe($access_token);

                //create new instance of user and create the confirmation token
                $user = new User();
                $user->email = $email;
                $user->name = $fb_data['name'];
                $user->type = User::TYPE_USER;
                $this->userRepository->save($user);
                $confirmationToken = $this->confirmationTokenService->createFacebookConfirmationToken($user,$fb_data['id'],$fb_data['name'],$access_token,$accessTokenExpiredAt,$fb_data['picture']['data']['url']);
                $facebookIntegration = $this->facebookIntegrationRepository->findByConfirmationToken($confirmationToken);
                $this->mailerService->sendFacebookConfirmationToken($user,$confirmationToken,$facebookIntegration);
                return redirect()->route('auth.confirmation_email_sent',['id'=>$confirmationToken->id]);
            } else {
                abort(401);
            }
        }
    }

    public function postIntegrateSocmedEmail($source,Request $request,TwitterAuthService $twitterAuthService,FacebookAuthService $facebookAuthService){
        $email = $this->session->get(self::SOCMED_INTEGRATION_EMAIL_SESSION_KEY);
        $existingUser = $this->userRepository->findByEmail($email);
        if ($existingUser == null) abort(500,"Email stored error. Please try again");
        if ($source == 'twitter'){
            $oauth_token = $twitterAuthService->getOAuthToken();
            $oauth_token_sec = $twitterAuthService->getOAuthTokenSecret();
            $twitter_data = $twitterAuthService->executeVerifyCredentials($oauth_token,$oauth_token_sec);
            $confirmationToken = $this->confirmationTokenService->createTwitterConfirmationToken($existingUser,$twitter_data->id,$twitter_data->screen_name,$oauth_token,$oauth_token_sec,$twitter_data->profile_image_url_https);
            $twitterIntegration = $this->twitterIntegrationRepository->findByConfirmationToken($confirmationToken);
            $this->mailerService->sendTwitterConfirmationToken($existingUser,$confirmationToken,$twitterIntegration);
            return redirect()->route('auth.confirmation_email_sent',['id'=>$confirmationToken->id]);
        } else if ($source == 'facebook'){
            $access_token = $facebookAuthService->getAccessToken();
            $accessTokenExpiredAt = $facebookAuthService->getAccessTokenExpiresAt();
            $fb_data = $facebookAuthService->executeMe($access_token);
            $confirmationToken = $this->confirmationTokenService->createFacebookConfirmationToken($existingUser,$fb_data['id'],$fb_data['name'],$access_token,$accessTokenExpiredAt,$fb_data['picture']['data']['url']);
            $facebookIntegration = $this->facebookIntegrationRepository->findByConfirmationToken($confirmationToken);
            $this->mailerService->sendFacebookConfirmationToken($existingUser,$confirmationToken,$facebookIntegration);
            return redirect()->route('auth.confirmation_email_sent',['id'=>$confirmationToken->id]);
        } else {
            abort(400);
        }
    }

    public function getConfirmationEmailSent($id){
        $confirmationToken = $this->confirmationTokenRepository->findById($id);
        if ($confirmationToken == null) abort(404);
        return view('auth.confirmation_email_sent',compact('confirmationToken'));
    }

    public function postResendConfirmationEmail($id){
        $confirmationToken = $this->confirmationTokenRepository->findById($id);
        $existingUser = $confirmationToken->user;
        if ($confirmationToken == null) abort(404);
        if ($confirmationToken->isFacebook()){
            $facebookIntegration = $this->facebookIntegrationRepository->findByConfirmationToken($confirmationToken);
            $this->mailerService->sendFacebookConfirmationToken($existingUser,$confirmationToken,$facebookIntegration);
        } else if ($confirmationToken->isTwitter()){
            $twitterIntegration = $this->twitterIntegrationRepository->findByConfirmationToken($confirmationToken);
            $this->mailerService->sendTwitterConfirmationToken($existingUser,$confirmationToken,$twitterIntegration);
        }
        $this->alertMessageService->setSuccess("Confirmation email has been sent. Please wait for few seconds and then check your inbox/spam folder");
        return redirect()->back();
    }

	public function getFacebookRedirect(Request $request,FacebookAuthService $fbAuthService){
	    $after_callback_url = $request->input('after_callback_url',route('auth.facebook_registration'));
        $fbAuthService->setAfterCallbackURL($after_callback_url);

        $after_login_url = $request->input('after_login_url','/');
        $fbAuthService->setAfterLoginURL($after_login_url);

        $after_sync_account_url = $request->input('after_sync_account_url','/');
        $fbAuthService->setAfterSyncAccountURL($after_sync_account_url);

		return redirect()->to($fbAuthService->createRedirectUrl());
	}
	
	public function getFacebookCallback(FacebookAuthService $fbAuthService){
		try {
			$accessToken = $fbAuthService->extractLongLivedAccessToken();
            $fbAuthService->setAccessToken($accessToken->getValue());
            $fbAuthService->setAccessTokenExpiresAt($accessToken->getExpiresAt());
		} catch (FacebookAuthLoginException $e){
			abort(401,$e->getMessage());
		}
		$after_callback_url = $fbAuthService->getAfterCallbackUrl();
		return redirect()->to($after_callback_url);
	}

	public function getFacebookRegistration(FacebookAuthService $fbAuthService){
        try {
            $access_token = $fbAuthService->getAccessToken();
            $accessTokenExpiresAt = $fbAuthService->getAccessTokenExpiresAt();
            $user = $fbAuthService->authenticate($access_token,$accessTokenExpiresAt);
            Auth::login($user,true);
        } catch (FacebookEmailNotProvidedException $e){
            $fbAuthService->storeFacebookData($e->getFbId(),$e->getName());
            return redirect()->route('auth.add_socmed_email',['source'=>'facebook']);
        }
        return redirect()->intended(route('home'));
    }

	public function getGooglePlusRedirect(Request $request,GooglePlusAuthService $authService){
	    $after_callback_url = $request->input('after_callback_url',route('auth.google_plus_registration'));
        $authService->setAfterCallbackURL($after_callback_url);

        $after_login_url = $request->input('after_login_url',url(''));
        $authService->setAfterLoginURL($after_login_url);

        $after_sync_account_url = $request->input('after_sync_account_url',url(''));
        $authService->setAfterSyncAccountURL($after_sync_account_url);

		return redirect()->to($authService->createRedirectUrl());
	}

	public function postGooglePlusCallback(Request $request,GooglePlusAuthService $authService){
		$auth_code = $request->input('code');
        $access_token = $authService->executeFetchAccessToken($auth_code);
        $authService->setAccessToken($access_token['access_token']);
        $authService->setIDToken($access_token['id_token']);
		return redirect()->to($authService->getAfterCallbackURL());
	}

	public function getGooglePlusRegistration(GooglePlusAuthService $googlePlusAuthService){
	    $id_token = $googlePlusAuthService->getIDToken();
        $user = $googlePlusAuthService->authenticate($id_token);
        Auth::login($user,true);
        return redirect()->to($googlePlusAuthService->getAfterLoginURL());
    }

	public function postLogout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

	public function postRegister(Request $request,EmailAuthService $emailAuthService){
        $email = $request->input('email');
        try {
            $user = $emailAuthService->register($request->input('name'),$email,$request->input('password'));
            //automatically login
            Auth::login($user,true);
            return redirect()->intended('/');
        } catch (EmailUsedException $e){
            Session::flash('error_message',$email." is already registered. If you are the owner of this email, please login with this email");
            return redirect()->back();
        }
    }

    public function getForgotPassword(){
        return view('auth.forgot_password');
    }

    public function postForgotPassword(Request $request){
        $this->validate($request,['email'=>['required','email','exists:users']]);
        $user = $this->userRepository->findByEmail($request->input('email'));
        $token = Str::random(100);

        $resetPasswordToken = new ResetPasswordToken();
        $resetPasswordToken->user()->associate($user);
        $resetPasswordToken->valid_until = Carbon::now()->addDay(1);
        $resetPasswordToken->token = $token;
        $this->resetPasswordTokenRepository->save($resetPasswordToken);

        $this->mailerService->resetPasswordLink($user,$token);
        //send reset password link
        Session::flash('email_sent',"An email has been sent to {$user->email}. Please check inbox/spam folder");
        return redirect()->back();
    }

    public function getConfirmationToken($token){
        $confirmationToken = $this->confirmationTokenRepository->findByToken($token);
        if ($confirmationToken == null) abort(404);
        $user = $this->confirmationTokenService->acceptConfirmationToken($confirmationToken);
        Auth::login($user,true);
        return redirect()->to('');
    }

    public function getResetPassword($reset_token){
        $resetPassword = $this->resetPasswordTokenRepository->findByToken($reset_token);
        $invalid_token = false;
        if ($resetPassword == null){
            $invalid_token = true;
        } else {
            $validUntil = Carbon::createFromFormat('Y-m-d H:i:s',$resetPassword->valid_until);
            if (Carbon::now() > $validUntil){
                $invalid_token = true;
                //delete since it can't be used
                $this->resetPasswordTokenRepository->delete($resetPassword);
            }
        }


        if ($invalid_token){
            return view('auth.reset_password',compact('invalid_token'));
        } else {
            $user = $resetPassword->user;
            return view('auth.reset_password',compact('invalid_token','user'));
        }
    }

    public function postResetPassword($reset_token,Request $request){
        $resetPassword = $this->resetPasswordTokenRepository->findByToken($reset_token);
        $invalid_token = false;
        if ($resetPassword == null) $invalid_token = true;
        $validUntil = Carbon::createFromFormat('Y-m-d H:i:s',$resetPassword->valid_until);
        if (Carbon::now() > $validUntil){
            $invalid_token = true;
            //delete since it can't be used
            $this->resetPasswordTokenRepository->delete($resetPassword);
        }
        if ($invalid_token){
            abort(403);
        }
        $user = $resetPassword->user;
        $user->password = $this->hashPasswordService->hash($request->input('password'));
        $this->userRepository->save($user);
        $this->mailerService->notifyChangePassword($user);
        Auth::login($user,true);
        //delete reset password token
        $this->resetPasswordTokenRepository->delete($resetPassword);
        return redirect()->to('/');
    }

	public function postLoginBasic(Request $request,EmailAuthService $authService)
	{
		$this->validate($request,['email'=>'required','password'=>'required']);
		try {
			$authService->login($request->input("email"),$request->input("password"));
		} catch (InvalidEmailOrPasswordException $e){
            $this->alertMessageService->setError("Invalid email/password combination, please try again");
			return redirect()->back()
				->withInput(['email'=>$request->input('email')]);
//				// ->withErrors(['message'=>'Invalid email/password combination, please try again']);
//
//				->withErrors([
//					'message'=>'<div class="container" id="flash-message">
//									<div class="row">
//										<div class="col s12 m8 offset-m2 l6 offset-l3">
//											<div class="card-panel">
//												<div class="row valign-wrapper">
//													<div class="col m2">
//														<i class="material-icons">error_outline</i>
//													</div>
//													<div class="col m10">
//														<span class="white-text">Invalid email/password combination, please try again</span>
//													</div>
//												</div>
//											</div>
//										</div>
//									</div>
//								</div>',
//					'passwords'=>'<div class="container" id="flash-message">
//									<div class="row">
//										<div class="col s12 m8 offset-m2 l6 offset-l3">
//											<div class="card-panel">
//												<div class="row valign-wrapper">
//													<div class="col m2">
//														<i class="material-icons">error_outline</i>
//													</div>
//													<div class="col m10">
//														<span class="white-text">pass salah</span>
//													</div>
//												</div>
//											</div>
//										</div>
//									</div>
//								</div>',
//					'message_email_inside'=>'Invalid email/password combination, please try again',
//					'message_password_inside'=>'Invalid email/password combination, please try again'
//					]);
		}
		return redirect()->intended(route('home'));
	}
}
