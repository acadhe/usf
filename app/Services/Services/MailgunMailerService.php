<?php

namespace App\Services\Services;


use App\Contracts\Services\MailerService;
use App\Models\ConfirmationToken;
use App\Models\FacebookIntegration;
use App\Models\TwitterIntegration;
use App\Models\User;
use Mailgun\Mailgun;

class MailgunMailerService implements MailerService
{
    private $mailgun;
    private $domain;
    private $noReplyFrom = "Urban Community of Practice <noreply@urbansocialforum.or.id>";

    public function __construct()
    {
        $this->mailgun = new Mailgun(config('mail.mailgun.api_key'));
        $this->domain = config('mail.mailgun.domain');
    }

    public function resetPasswordLink(User $user,$token){
        $this->mailgun->sendMessage($this->domain,[
            'from' => $this->noReplyFrom,
            'to' => $user->email,
            'subject' => 'UCP Reset Password',
            'text' => view('mails.reset_password',['user'=>$user,'token'=>$token])
        ]);
    }

    public function notifyChangePassword(User $user){
        $this->mailgun->sendMessage($this->domain,[
            'from' => $this->noReplyFrom,
            'to' => $user->email,
            'subject' => 'UCP Password Changed',
            'text' => view('mails.notify_change_password',['user'=>$user])
        ]);
    }

    function notifyUserHasBeenDeleted(User $user)
    {
        $this->mailgun->sendMessage($this->domain,[
            'from' => $this->noReplyFrom,
            'to' => $user->email,
            'subject' => 'Your UCP Account Has Been Deleted',
            'text' => view('mails.notify_user_has_been_deleted',['user'=>$user])
        ]);
    }

    function sendPanelistCredentials($email, $password)
    {
        $this->mailgun->sendMessage($this->domain,[
            'from' => $this->noReplyFrom,
            'to' => $email,
            'subject' => 'Your UCP Panelist Account Credentials',
            'text' => view('mails.send_panelist_credentials',['email'=>$email,'password'=>$password])
        ]);
    }

    function sendFacebookConfirmationToken(User $user,ConfirmationToken $confirmationToken,FacebookIntegration $facebookIntegration)
    {
        $this->mailgun->sendMessage($this->domain,[
            'from'=> $this->noReplyFrom,
            'to' => $user->email,
            'subject' => 'UCP Facebook Account Confirmation',
            'text' => view('mails.send_facebook_confirmation_token',compact('user','confirmationToken','facebookIntegration'))
        ]);
    }

    function sendTwitterConfirmationToken(User $user,ConfirmationToken $confirmationToken,TwitterIntegration $twitterIntegration)
    {
        $this->mailgun->sendMessage($this->domain,[
            'from' => $this->noReplyFrom,
            'to' => $user->email,
            'subject' => 'UCP Twitter Account Confirmation',
            'text' => view('mails.send_twitter_confirmation_token',compact('user','confirmationToken','twitterIntegration'))
        ]);
    }
}