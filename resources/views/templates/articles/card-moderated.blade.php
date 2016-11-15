			<div class="col s6 m6">
				<div class="card">
					<div class="card-image waves-effect waves-block waves-light">
						<a href="{{route('article.read',['article_id'=>$article->id])}}">
						<img class="activator card-img" src="{{asset('frontend/img/post.jpg')}}">
						</a>
					</div>
					<div class="card-content card-moderated">
						<div class="row valign-wrapper wrapper-card-moderated">
							<div class="col m2" id="card-photo">
								<img src="{{$article->user->photo_url}}" alt="" class="circle responsive-img card-pp">
							</div>
							<div class="col m10" id="card-author">
								<span class="card-title activator grey-text text-darken-4" id="aut-name">
									<a href="{{route('user.read',['user_id'=>$article->user->id])}}">{{$article->user->name}}</a>
									<span class="right" id="post-hour">{{$article->created_at->diffForHumans()}}</span>
								</span>
							</div>
						</div>
						<p class="truncate"><a href="{{route('article.read',['article_id'=>$article->id])}}">{{$article->title}}</a></p>
						<p class="title-cards"><a href="#">{{$article->category}}</a></p>
					</div>

					<div class="card-action">
						<div class="row">
							<div class="col m12">
								<span class="cmt-shr">
									<a href="#">
										<i class="material-icons">comment</i>
										<span>{{$article->comments_count}}</span>
									</a>
								</span>
								<span class="cmt-shr">
									<a href="#">
										<i class="material-icons">share</i>
										<span>{{$article->shares_count}}</span>
									</a>
								</span>
							</div>
						</div>
					</div>

					<div class="card-reveal" id="reveal">
						<div class="card-content card-moderated">
							<div class="row valign-wrapper wrapper-card-moderated">
								<div class="col m2" id="card-photo">
									<img src="{{$user->photo_url}}" alt="" class="circle responsive-img card-pp">
								</div>
								<div class="col m10" id="card-author">
									<span class="card-title activator grey-text text-darken-4" id="aut-name">
										<a href="{{route('user.read',['user_id'=>$user->id])}}">{{$user->name}}</a>
										<span class="card-title activator right" id="post-hour">
											2 Hours Ago
										</span>
									</span>
								</div>
							</div>
							<p><a href="{{route('article.read',['article_id'=>$article->id])}}">{{$article->title}}</a></p>
							<!-- <p class="title-cards"><a href="#">public places</a></p> -->
							<p class="title-cards"><a href="{{route('home',['category'=>$article->category])}}">{{$article->category}}</a></p>
						</div>
						<p class="reveal-content">Here is some more information about this product that is only revealed once clicked on.</p>
						<p class="read-more-content"><a href="{{route('article.read',['article_id'=>$article->id])}}">read full story</a></p>
					</div>
				</div>
			</div>