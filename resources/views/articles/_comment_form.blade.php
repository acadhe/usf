<form action="{{route('comment.create.post',['article_id'=>$article->id])}}" method="post" class="forms">
	{!! csrf_field() !!}
		<div class="row" id="wrapper-popout">
			@if(!isset($replied_comment_id))
				<div class="card">
            		<div class="card-content">
						<div class="row" id="wrapper-comment-form">
							<div class="col s4 m3 hide-on-small-only">
								<div id="comment-header-kiri">
									<a href="{{route('home.panelist',['user_id'=>$user->id])}}">
										@if(Auth::user()->photo_url == '')
											<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="circle responsive-img">
										@else
											<img src="{{Auth::user()->photo_url}}" alt="" class="circle responsive-img">
										@endif
									</a>
								</div>
							</div>
							<div class="col s12 m9">
								<div id="comment-header-kanan">
								<div class="row">
									<div class="col s12 m6">
										<p>Pendapat Anda tentang topik ini</p>
									</div>
									<div class="col s12 m6">
										<form name="myForm" onsubmit="return validateForm()" novalidate>
											<div class="radio-btn-group">
												<div class="radio">
													<input type="radio" name="support" value="pro" id="pro" required>
													<label class="pro" for="pro">pro</label>
												</div>
												<div class="radio">
													<input type="radio" name="support" value="contra" id="kontra" required>
													<label class="kontra" for="kontra">kontra</label>
												</div>
											</div>
										</form>
									</div>
								</div>
								</div>
							</div>
						</div>
							<textarea id="komen-atas" name='content' class="materialize-textarea" placeholder="Write your response to this topic..." length="8000"></textarea>
							<button class="waves-effect btn-flat right comment-submit" type="submit">Post Comment</button>
					</div>
				</div>
			@else
				<div class="col s12 m12 left" id="comment-bodypost">
					<i class="material-icons grey-text"></i>
					<textarea id="textarea1" name='content' class="materialize-textarea" placeholder="Write your response to this topic" length="8000" autofocus></textarea>
					<input type="hidden" name="replied_comment_id" value="{{$replied_comment_id}}"/>
				</div>
				<button class="waves-effect btn-flat right" type="submit">Comment</button>
			@endif
		</div>
	</form>
