@extends('templates.master')
@section('content')
<section id="upd-sum">
	<div class="container">
		<div class="row">
			<div class="col m12">
				<h3>Update summary</h3>
				<span>Title: <p>{{$article->title}}</p></span>
				<form method="post" action="{{route('article.update_summary.post',['article_id'=>$article->id])}}">
					{!! csrf_field() !!}
					<textarea id="komen-atas" name="summary" class="materialize-textarea" placeholder="Write your summary to this topic...">{{$article->summary}}</textarea>
					<button class="waves-effect btn-flat right comment-submit" type="submit">Post Summary</button>
				</form>
			</div>
		</div>
</div>
</section>
@endsection