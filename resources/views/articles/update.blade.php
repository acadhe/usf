@extends('templates.master-articles')
@section('content')
	<section id="form">
		<form action="{{route('article.update.post',['article_id'=>$article->id])}}" method="post" id="form" enctype="multipart/form-data">
			@include('articles._form')
		</form>
	</section>
@endsection