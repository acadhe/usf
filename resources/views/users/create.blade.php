@extends('templates.master')
@section('content')
    <h1>Tambah Pengguna</h1>
    <div class="col-md-6">
        <form action="{{route('user.create.post')}}" method="post">
            @include('users._form',['categories'=>$categories])
        </form>
    </div>
@endsection