@extends('templates.master')
@section('content')
<p>Please check your inbox/spam folder <b>({{$confirmationToken->user->email}})</b> to confirm your account. If you don't get your account confirmation
    email, please click the <b>resend confirmation email</b> button</p>
<form method="post" action="{{route('auth.resend_confirmation_email.post',['id'=>$confirmationToken->id])}}">
    {!! csrf_field() !!}
    <button type="submit">Resend Confirmation Email</button>
</form>
@endsection