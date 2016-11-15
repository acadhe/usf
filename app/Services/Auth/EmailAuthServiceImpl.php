<?php

namespace App\Services\Auth;


use App\Contracts\Auth\EmailAuthService;
use App\Contracts\Auth\HashPasswordService;
use App\Contracts\Repositories\UserRepository;
use App\Exceptions\Auth\EmailUsedException;
use App\Exceptions\Auth\InvalidEmailOrPasswordException;
use App\Models\User;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Auth;
use Mailgun\Mailgun;

class EmailAuthServiceImpl implements EmailAuthService
{
    private $userRepository;
    private $hashPasswordService;
    private $mailer;

    public function __construct(Mailer $mailer,UserRepository $userRepository,HashPasswordService $hashPasswordService)
    {
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
        $this->hashPasswordService = $hashPasswordService;
    }

    /**
     * @param $name
     * @param $email
     * @param $password
     * @return User
     * @throws EmailUsedException
     */
    public function register($name, $email, $password)
    {
        if ($this->userRepository->findByEmail($email) !== null){
            throw new EmailUsedException($email);
        }
        $user = new User();
        $user->name = $name;
        $user->password = $this->hashPasswordService->hash($password);
        $user->email = $email;
        $user->type = User::TYPE_USER;
        //auto accept
        //send confirmation email
//        $mg = new Mailgun(config('mail.mailgun.api_key'));
//        $domain = config('mail.mailgun.domain');
//        $mg->sendMessage($domain,[
//            'from' =>'admin@urbansocialforum.or.id',
//            'to' => $user->email,
//            'subject' => 'UCP Email Verification',
//            'text' => view('mails.email_verification',['user'=>$user])
//        ]);
        $this->userRepository->save($user);
        return $user;
    }
    
    public function login($email, $password)
    {
        $user = $this->userRepository->findByEmail($email);
        if ($user === null || !$this->hashPasswordService->equalsWithHashed($password,$user->password)){
            throw new InvalidEmailOrPasswordException();
        } else {
            Auth::login($user,true);
        }
    }

}