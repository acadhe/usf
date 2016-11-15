@extends('templates.master')
@section('content')
<h1>Tambah kategori</h1>
<form action="{{route('article_category.create')}}" method="post">
    {!! csrf_field() !!}
    @include("article_categories._form",['articleCategory'=>$articleCategory])
</form>
@endsection