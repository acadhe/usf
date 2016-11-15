@extends('templates.master')

@section('content')
<div>
    <a href="{{route('user.create')}}">Tambah pengguna</a>
</div>
<h1>Cari Pengguna</h1>
<form action="{{route('user')}}">
    <input type="text" name="name" class="form-control"/>
    <button type="submit" class="btn btn-primary">Cari</button>
</form>
@if ($users == null)
    Tidak ada user
@else
<table class="table">
<tr>
    <th>Nama</th>
    <th>Tipe</th>
    <th>Aksi</th>
</tr>
@foreach($users as $user)
<tr>
    <td>{{$user->name}}</td>
    <td>{{$user->type}}</td>
    <td>
        <span><a href="{{route('user.update',['user_id'=>$user->id])}}">Ubah</a></span>
    </td>
</tr>
@endforeach
</table>
{!! $users->appends($filter)->render() !!}
@endif
@endsection



