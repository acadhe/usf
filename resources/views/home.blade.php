@extends('templates.master')
@section('content')

<section id="atas-home">
	<div class="row">
		<div class="col s12 m12" id="wrapper-card">
			<div id="wrapper-home-img">
				<div class="container wrapper-card-content">
					<h5>A home for urban enthusiasts to explore urban issues, discover ideas, and exchange perspectives.</h5>
					@if(Auth::guest())
						<h5>Sign up to read and interact with what matters most to you</h5>
						<a href="{{route('auth.login')}}" class="waves-effect waves-light btn signup">Join the discussions</a>
					@endif
					<a href="{{route('home.about')}}" class="waves-effect waves-light btn lhiw">Learn More</a>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="bawah-home">
	<div class="container cards" id="height-bg-layer">
		<div class="row">
			<div class="col s12 m12" id="wrapper-card">
				<div class="card">
					<div class="card-content">
						<form action="{{route("home")}}" method="get" id="form">
							<div class="row" id="row-cards">
								<div class=" input-field col s12 m3">
									<div class="asd">
										<p class="select-p">Sort Discussion</p>
										<select name="sort" class="form-control onchange-submit-form">
											<option value="most_recent" @if($filter['sort'] == 'most_recent') selected @endif>Most Recent</option>
											<option value="most_popular" @if($filter['sort'] == 'most_popular') selected @endif>Most Popular</option>
										</select>
									</div>
								</div>
								<div class="input-field col s12 m2">
									<div class="asd">
										<p class="select-p">Panelists {{old('panelist')}}</p>
										<select name="panelist_id" class="form-control onchange-submit-form">
											<option value="all" @if(request('panelist')=="all") selected @endif>All</option>
											@foreach($panelists as $panelist)
												<option value="{{$panelist->id}}" @if(request('panelist_id')==$panelist->id) selected @endif>{{$panelist->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="input-field col s12 m4" id="cat">
									<div class="asd">
										<p class="select-p">Categories</p>
										<select name="category" class="form-control onchange-submit-form" >
											<option value="all" @if(request('category')=="all") selected @endif >All</option>
											@foreach($categories as $category)
												<option value="{{$category->name}}" @if(request('category')==$category->name) selected @endif>{{$category->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								{{-- <div class="input-field col s12 m3">
									<nav id="nav-search">
										<div class="nav-wrapper">
											<div class="input-field" id="cari-dpn">
												<i class="material-icons" id="cari-mask">search</i>
												<input id="search" name='search' type="search" value="{{request('search')}}" class="cari" placeholder="Search for discussion title or panelist name">
												<label for="search"><i class="material-icons" id="cari-hid">search</i></label>
												<i class="material-icons" id="close">close</i>
												<input type="submit" value="Cari" style="display: none"/>
											</div>
										</div>
									</nav>
								</div> --}}
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container cards" id="bawah-home-cards">
		<div class="row">
			@foreach($articles as $article)
				@include("templates.articles.card",['article'=>$article,'user'=>$article->user])
			@endforeach
		</div>
	</div>
	{{--{!! $articles->appends($filter)->render() !!}--}}
</section>
@endsection
@section('scripts')
@parent
<script>
$(".onchange-submit-form").change(function(){
	console.log("woi");
	$("#form").submit();
});
</script>
@endsection