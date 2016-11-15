@extends('templates.master')
@section('head')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/slick-theme.css') }}"/>
@endsection

@section('content')
		<section id="atas-panelis">
			<div class="container" id="wrapper-atas-panelis">
				<div class="row">
					<div class="col s12 m8" id="head-utama-panelis">
						<p>Panelist</p>
						<p>Experts on the city issues</p>
					</div>
				</div>
			</div>
			<div class="container" id="wrapper-atas-panelis-carousel">
				<div class="row" id="wrapper-atas-panelis-inner">
					<div class="carousel-panelis">
						@foreach($users as $panelist)
						<div>
							<a href="{{route('home.panelist',['user_id'=>$panelist->id])}}">
								@if($panelist->photo_url == '')
								{{--gambar belum diatur, default gambar pp pengguna--}}
									<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="Panelis" class="circle responsive-img">
								@else
									<img src="{{$panelist->photo_url }}" alt="Panelis" class="circle responsive-img">
								@endif
							</a>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</section>

		<section id="bawah-panelis">
			<div class="container" id="wrapper-bawah-panelis">
				<div class="row">
					<div class="col s12 m12" id="wrapper-card-panelist">
						<p id="pan">Select a panelist to view full details about the panelist <br>and topic(s) moderated</p>

						@if(isset($user) && $user != null)
						<div class="card">
							<div class="card-content" id="card-panelist">
								<div class="row">
									<div class="col s12 m12">
										<div class="content-panelist">
											<div class="row valign-wrapper">
												<div class="col s12 m2" id="img">
													<a href="{{route('user.read',['id'=>$user->id])}}">
														@if ($user->photo_url == '')
															<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="Panelis" class="circle responsive-img" id="content-panelist-img">
														@else
															<img src="{{$user->photo_url}}" alt="Panelis" class="circle responsive-img" id="content-panelist-img">
														@endif
													</a>
												</div>
												<div class="col s12 m10" id="desc">
													<a href="{{route('user.read',['id'=>$user->id])}}">
														<p>{{$user->name}}</p>
													</a>
													<a href="{{route('user.read',['id'=>$user->id])}}">
														<p>{{$user->tagline}}</p>
													</a>
													<p>{{$user->description}}</p>
												</div>
											</div>

											<p id="tp">Topics Moderated</p>
											@foreach($articles as $article)
												<div class="row tm valign-wrapper">
													<div class="col s12 m2">
														@if($article->header_image_url == '')
														<img class="responsive-img" src="{{ asset('frontend/img/default_header.jpg') }}">
														@else
														<img class="responsive-img" src="{{$article->header_image_url}}"/>
														@endif
													</div>
													<div class="col s12 m10">
														<div class="row valign-wrapper" id="vw">
															<div class="col s12 m12 valign">
																<a href="{{route('article.read',['article_id'=>$article->id])}}">
																	 <p>{{$article->title}}</p>
																</a>
																<a href="{{route('home',['category'=>$article->category])}}">
																	<p class="title-cards">{{$article->category}}</p>
																</a>
															</div>
														</div>
													</div>
												</div>
											@endforeach
										</div>
									</div>
								</div>
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</section>
@endsection