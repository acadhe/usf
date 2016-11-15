<?php
$facebookURL = "https://www.facebook.com/{$facebookIntegration->facebook_id}";
$confirmationURL = route('auth.confirmation_token',['token'=>$confirmationToken->token]);
?>
Hi,

Somebody wants to connect your account {{$user->email}} with this facebook data:

Name: {{$facebookIntegration->facebook_name}}
URL: {{$facebookURL}}

Please click link or copy-paste link below to confirm your facebook account. Otherwise, ignore this email.

{{$confirmationURL}}