			<div class="col s12 m4" id="card-home-over">
				<div class="card">
					<div class="card-image waves-effect waves-block waves-light">
						<a href="{{route('article.read',['article_id'=>$article->id])}}">
						@if ($article->header_image_url != null)
							<img class="activator card-img" src="{{$article->header_image_url}}">
						@else
							<img class="activator card-img" src="{{asset('frontend/img/default_header.jpg')}}">
						@endif
						</a>
					</div>
					<div class="card-content">
						<div class="row valign-wrapper">
							<div class="col s2 m2" id="card-photo">
								<a href="{{route('home.panelist',['user_id'=>$user->id])}}">
									@if($user->photo_url == '')
										<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="circle responsive-img card-pp">
									@else
										<img src="{{$user->photo_url}}" alt="" class="circle responsive-img card-pp">
									@endif
								</a>
							</div>
							<div class="col s10 m10" id="card-author">
								<span class="card-title activator grey-text text-darken-4" id="aut-name">
									<a href="{{route('home.panelist',['user_id'=>$user->id])}}">
										{{$user->name}}
									</a>
									<span class="right" id="post-hour">
										{{$article->created_at->diffForHumans()}}
									</span>
								</span>
							</div>
						</div>
						<p class="title-cards"><a href="{{route('home',['category'=>$article->category])}}">{{$article->category}}</a></p>
						<p class="judul"><a href="{{route('article.read',['article_id'=>$article->id])}}">{{$article->title}}</a></p>
					</div>

					<div class="card-action">
						<div class="row">
							<div class="col s3 m3">
								<div class="left bkmrks">
									@if(!Auth::guest())
										@can('vote',$article)
											<a href="{{route('article.vote',['article_id'=>$article->id])}}" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Vote">
												<i class="material-icons share">favorite_border</i>
												<span>{{$article->votes_count}}</span>
											</a>
										@endcan
										@can('unvote',$article)
											<a href="{{route('article.unvote',['article_id'=>$article->id])}}" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Unvote">
												<i class="material-icons share">favorite</i>
												<span>{{$article->votes_count}}</span>
											</a>
										@endcan
									@else
										<a href="{{route('auth.login')}}" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Vote">
											<i class="material-icons">favorite_border</i>
											<span>{{$article->votes_count}}</span>
										</a>
									@endif
								</div>
							</div>
							<div class="col s9 m9">
								<div class="cmt-shr right">
									@if(!Auth::guest())
										@can('mark',$article)
											<a href="{{route('article.mark',['article_id'=>$article->id])}}" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Bookmark">
												<i class="material-icons">bookmark_border</i>
											</a>
										@endcan
										@can('unmark',$article)
											<a href="{{route('article.unmark',['article_id'=>$article->id])}}" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="unbookmark">
												<i class="material-icons">bookmark</i>
											</a>
										@endcan
									@else
										{{-- redirect ke login pas klik mark --}}
										<a href="{{route('auth.login')}}" class="toggle-post btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Bookmark">
											<i class="material-icons">bookmark_border</i>
										</a>
									@endif
									<a class="dropdown-button toggle-post btn-flat tooltipped" href='#' data-position="top" data-delay="50" data-tooltip="Share" data-activates='dropdown{{$article->id}}'>
										<i class="material-icons">share</i>
									</a>
									<!-- Dropdown Structure -->
									<ul id='dropdown{{$article->id}}' class='dropdown-content'>
										<p>Share this topic to:</p>
										<li>
											<a class="waves-effect btn-flat fb" href="{{$article->facebook_share_url}}" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i>Facebook</a>
										</li>
										<li>
											<a class="waves-effect btn-flat tw" href="{{$article->twitter_share_url}}" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i>Twitter</a>
										</li>
										<li>
											<a class="waves-effect btn-flat gp" href="{{$article->google_plus_share_url}}" target="_blank"><i class="fa fa-google" aria-hidden="true"></i>Google Plus</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>