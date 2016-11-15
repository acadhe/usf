<?php
	use App\Models\Article;
	use Illuminate\Support\Facades\Request;
	use Illuminate\Support\Facades\Auth;
	$route_name = Request::route()->getName();
?>
	<div class="mobile-ui show-on-medium-and-down hide-on-large-only">
		<div class="valign-wrapper">
			<a href="#" data-activates="mobile-demo" class="button-collapse">
				<i class="material-icons">menu</i>
			</a>
			<a href="{{route('home')}}" class="brand-logo">
				<img src="{{ asset('frontend/img/logo.svg') }}" alt="UCP Logo" class="svg-black">
			</a>
			<div id="nav-mobile" class="valign-wrapper">
				@if(!Auth::guest())
				<ul class="side-nav" id="mobile-demo">
					@can('create',new Article())
						<li>
							<a href="{{route('article.create')}}" class="menu">Write Topic</a>
						</li>
					@endcan
				  	@can('update',$article)
					<li>
						<a href="{{route('article.update',['article_id'=>$article->id])}}" class="menu">Edit Topic</a>
					</li>
					@endcan
					@can('close',$article)
					<li>
						<a href="#close-modal-topic" class="menu modal-trigger">Close Topic</a>
					</li>
					@endcan
				</ul>
				@endif

				@if(!Auth::guest())
					<ul class="side-nav" id="mobile-demo">
						<li>
							<p>Topic Status: {{$article->privacy}}</p>
						</li>
						<li class="divider"></li>
						<li>
							<a class="waves-effect btn-flat right publish-btn" id="draft-post">Save as Draft</a>
						</li>
						<li>
							<a href="#" class="waves-effect btn-flat" id="publish-post-submit">Publish</a>
						</li>
						<li class="divider"></li>
						<li>
							<a class="waves-effect waves-light modal-trigger" href="#ets">Edit Topic Status</a>
						</li>
						<li>
							<a class="waves-effect waves-light modal-trigger" href="#ct">Close Topic</a>
						</li>
						<li>
							<a class="modal-trigger" href="#del-top">Delete Topic</a>
						</li>
					</ul>

					<ul class="right" id="sign-mobile">
						<li>
							<a class="button-collapse valign-wrapper" href="#" data-activates="mobile-profile-menu" id="mobile-prof-sidemenu">
								@if(Auth::user()->photo_url == '')
									<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="circle responsive-img profilep-img">
								@else
									<img src="{{Auth::user()->photo_url}}" alt="" class="circle responsive-img profilep-img">
								@endif
							</a>
						</li>
						@include('templates.navbars.notification',compact('navbar_notifications'))
						<ul class="side-nav" id="mobile-profile-menu">
							@can('create',new Article())
								<li><a href="{{route('article.mine')}}" class="menu">Your Topic</a></li>
							@endcan
							<li><a href="{{route('user.read',['user_id'=>Auth::user()->id])}}">Profile</a></li>
							<li class="valign-wrapper">
								<form method="post" action="{{route('auth.logout.post')}}" id="logout">
									{!! csrf_field() !!}
									<button class="btn-flat" type="submit">Sign Out</button>
								</form>
							</li>
						</ul>
					</ul>
				@else
					<ul id="sign-mobile" class="right show-on-medium-and-down hide-on-large-only">
						<li>
							<a href="{{route('auth.login')}}" class="valign-wrapper">
								<i class="material-icons">person</i>
							</a>
						</li>
					</ul>
				@endif

			</div>
		</div>
	</div>