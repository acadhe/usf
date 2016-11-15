@extends('templates.master')
@section('content')
<h1>Ubah Pengguna</h1>
<div class="col-md-6">
    <form action="{{route('user.update.post',['user_id'=>$user->id])}}" method="post">
    @include('users._form',['user'=>$user,'categories'=>$categories])
    </form>
</div>
@endsection