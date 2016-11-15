<p id="judul">These are topics you have created</p>
<div class="dummy-wrapper"></div>
	<div class="row cardtopics">
		@foreach($articles as $article)
			@include('templates.articles.card-moderated',compact('article'))
		@endforeach
	</div>
