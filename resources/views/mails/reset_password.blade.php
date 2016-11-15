<?php
$url = route('auth.reset_password',['token'=>$token]);
?>
Hi,

Somebody request a reset password for your email.

If you want to reset the password, use this link

{{$url}}

Otherwise, ignore this email.