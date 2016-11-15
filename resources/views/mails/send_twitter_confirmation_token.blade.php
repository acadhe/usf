<?php
$twitterURL = "https://www.twitter.com/intent/user?user_id={$twitterIntegration->twitter_id}";
$confirmationURL = route('auth.confirmation_token',['token'=>$confirmationToken->token]);
?>
Hi,

Somebody wants to connect your account ({{$user->email}}) with this twitter data:

Name: {{$twitterIntegration->twitter_name}}
URL: {{$twitterURL}}

Please click link or copy-paste link below to confirm your twitter account. Otherwise, ignore this email.

{{$confirmationURL}}