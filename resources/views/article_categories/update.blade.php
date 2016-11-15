@extends('templates.master')
@section('content')
<h1>Ubah kategori</h1>
<form action="{{route('article_category.update.post',['article_category_id'=>$articleCategory->id])}}" method="post">
    {!! csrf_field() !!}
    @include("article_categories._form",['articleCategory'=>$articleCategory])
</form>
@endsection