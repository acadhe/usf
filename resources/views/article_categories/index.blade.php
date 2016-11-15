@extends('templates.master')
@section('content')
<h1>Daftar kategori</h1>
<a href="{{route('article_category.create')}}">Tambah kategori</a>
<table class="table">
<tr>
    <th>Nama</th>
    <th>Aksi</th>
</tr>
@foreach($categories as $category)
<tr>
    <td>{{$category->name}}</td>
    <td>
        <a href="{{route('article_category.update',['article_category_id'=>$category->id])}}">Ubah</a>
        <a href="{{route('article_category.delete',['article_category_id'=>$category->id])}}">Hapus</a>
    </td>
</tr>
@endforeach
</table>
@endsection