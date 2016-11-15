@extends('templates.master-articles')
@section('content')
	<section id="form">
		<form action="{{route('article.create.post')}}" method="post" class="forms">
			@include('articles._form')
		</form>
	</section>
@endsection