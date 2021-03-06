<p id="judul">These are topics you have followed</p>
{{-- <div class="dummy-wrapper hide-on-small-only"></div> --}}
	<div class="cardtopics">
		@foreach($articles as $article)
			<div class="row">
				<div class="col s12 m12">
					<div class="card">
						<div class="card-content valign-wrapper">
							<div class="row">
								<div class="col s12 m8 valign-wrapper">
									<div class="row">
									 	<div class="col m12 valign-wrapper" id="info-user-bt">
									 		<div class="row">
										 		<a href="{{route('home.panelist',['user_id'=>$user->id])}}">
													<div class="col s3 m2">
														@if ($article->user->photo_url == '')
															<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="responsive-img circle">
														@else
															<img src="{{$article->user->photo_url}}" class="responsive-img circle">
														@endif
													</div>
													<div class="col s9 m10">
														<p>{{$article->user->name}}</p>
													</div>
												</a>
											</div>
									 	</div>
										<div class="col s12 m12">
											<a href="{{route('article.read',['article_id'=>$article->id])}}">
												<p class="truncate">{{$article->title}}</p>
											</a>
											<a href="{{route('home',['category'=>$article->category])}}">
												<p class="title-cards">{{$article->category}}</p>
											</a>
										</div>
									</div>
								</div>
								<div class="col s12 m4 valign-wrapper">
									<div class="row" id="share">
										<a class="dropdown-button toggle-post btn-flat tooltipped" href="#" data-activates="dropdown{{$article->id}}" data-position="top" data-delay="50" data-tooltip="Share Topic">
											<i class="material-icons">share</i>
										</a>
										<!-- Dropdown Structure -->
										<ul id='dropdown{{$article->id}}' class='dropdown-content'>
											<p>Share this topic to:</p>
											<li>
												<a class="waves-effect btn-flat fb" href="#" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i>Facebook</a>
											</li>
											<li>
												<a class="waves-effect btn-flat tw" href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i>Twitter</a>
											</li>
											<li>
												<a class="waves-effect btn-flat gp" href="#" target="_blank"><i class="fa fa-google" aria-hidden="true"></i>Google Plus</a>
											</li>
										</ul>
										{{-- bookmark --}}
										@if(!Auth::guest())
											@can('mark',$article)
												<a href="{{route('article.mark',['article_id'=>$article->id])}}" class="toggle-post btn-flat bookmark tooltipped" data-position="top" data-delay="50" data-tooltip="Bookmark">
													<i class="material-icons">bookmark_border</i>
												</a>
											@endcan
											@can('unmark',$article)
												<a href="{{route('article.unmark',['article_id'=>$article->id])}}" class="toggle-post btn-flat bookmark tooltipped" data-position="top" data-delay="50" data-tooltip="Unbookmark">
													<i class="material-icons">bookmark</i>
												</a>
											@endcan
										@else
											{{-- redirect ke login pas klik mark --}}
											<a href="{{route('auth.login')}}" class="toggle-post btn-flat bookmark tooltipped" data-position="top" data-delay="50" data-tooltip="Bookmark">
												<i class="material-icons">bookmark</i>
												<span>{{$article->bookmarks_count}}</span>
											</a>
										@endif
										{{-- bookmark --}}
										{{-- vote --}}
										@can('vote',$article)
											<a href="{{route('article.vote',['article_id'=>$article->id])}}" class="toggle-post btn-flat love tooltipped" data-position="top" data-delay="50" data-tooltip="Vote">
												<i class="material-icons">favorite_border</i>
												<span>{{$article->votes_count}}</span>
											</a>
										@endcan
										@can('unvote',$article)
											<a href="{{route('article.unvote',['article_id'=>$article->id])}}" class="toggle-post btn-flat love tooltipped" data-position="top" data-delay="50" data-tooltip="Unvote"
												<i class="material-icons">favorite</i>
												<span>{{$article->votes_count}}</span>
											</a>
										@endcan
										{{-- vote --}}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
