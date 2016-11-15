<?php
use App\Models\NotificationObject;
?>
@extends('templates.master-profile')
@section('content')
	<section id="user">

		<div class="container" id="wrapper-user">
			<div class="row" id="wrapper-user-row">

				<div class="col s12 m3 hide-on-small-only" id="card-user">
					<div id="aside">
						<div class="card">
							<div class="card-content" id="wrapper-info-user">
								<div id="sect-atas">
									<figure>
										<a href="#" id="profile-picture">
											@if($user->photo_url == '')
												<img src="{{asset('frontend/img/pp/default.jpg')}}" class="responsive-img def" id="img-pp">
												<span>
													Add Profile Picture (Max. 2MB)
													<i class="material-icons">add_a_photo</i>
												</span>
											@else
												<img src="{{$user->photo_url}}" class="responsive-img" id="img-pp">
												<span>
													Change Profile Picture <br>(Max. 2MB)
													<i class="material-icons">photo_camera</i>
												</span>
											@endif
										</a>
										<form method="post" enctype="multipart/form-data" id="change-pp-form" action="{{route('user.update_picture.post')}}">
											{!! csrf_field() !!}
											<input type="file" name="image" style="display: none;"/>
										</form>
									</figure>
								</div>
									<div class="divider"></div>

								<div class="about-profile">
									@if ($user->isAdmin())
										<p>Admin</p>
									@elseif($user->isPanelist())
										<p>Panelist</p>
									@else
										<p>General User</p>
									@endif
										<p>{{$user->name}}</p>

									@if($user->isAdmin())
									@elseif($user->isPanelist())
										<p>{{$user->tagline}}</p>
										<p>{{$user->description}}</p>
									@elseif($user->isUser())
										<p>{{$user->tagline}}</p>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>

				{{-- mobile view --}}
				<div class="col s12 m3 show-on-small hide-on-med-and-up" id="card-user-mobile">
					<div id="aside">
						<div class="card">
							<div class="card-content" id="wrapper-info-user">
								<div id="sect-atas">
									<figure>
										<a href="#" id="profile-picture">
											@if($user->photo_url == '')
												<img src="{{asset('frontend/img/pp/default.jpg')}}" class="responsive-img def" id="img-pp">
												<span>
													Add Profile Picture (Max. 2MB)
													<i class="material-icons">add_a_photo</i>
												</span>
											@else
												<img src="{{$user->photo_url}}" class="responsive-img" id="img-pp">
												<span>
													Change Profile Picture <br>(Max. 2MB)
													<i class="material-icons">photo_camera</i>
												</span>
											@endif
										</a>
										<form method="post" enctype="multipart/form-data" id="change-pp-form" action="{{route('user.update_picture.post')}}">
											{!! csrf_field() !!}
											<input type="file" name="image" style="display: none;"/>
										</form>
									</figure>
								</div>
									<div class="divider"></div>

								<div class="about-profile">
									@if ($user->isAdmin())
										<p>Admin</p>
									@elseif($user->isPanelist())
										<p>Panelist</p>
									@else
										<p>General User</p>
									@endif
										<p>{{$user->name}}</p>

									@if($user->isAdmin())
									@elseif($user->isPanelist())
										<p>{{$user->tagline}}</p>
										<p>{{$user->description}}</p>
									@elseif($user->isUser())
										<p>{{$user->tagline}}</p>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
				{{-- mobile view --}}

				<div class="col s12 m9" id="card-user-kanan">
					@if($tab == 'followed_topics')
						@can('showBookmarkedTopics',$user)
							@include('users.read.bookmarked_topics',['articles'=>$articles])
						@endcan
					@elseif ($tab == 'activities')
						@can('showActivities',$user)
							@include('users.read.activities',['notifications'=>$notifications])
						@endcan
					@elseif ($tab == 'moderated_topics')
						@can('showModeratedTopics',$user)
							@include('users.read.moderated_topics',['articles'=>$articles])
						@endcan
					@elseif ($tab == 'voted_topics')
						@can('showVotedTopics',$user)
							@include('users.read.voted_topics',['articles' => $articles])
						@endcan
					@elseif ($tab == 'edit_profile')
						@can('edit',$user)
							@include('users.read.edit_profile',['user'=>$user])
						@endcan
					@elseif ($tab == 'add_panelist')
						@can('addPanelist',$user)
							@include('users.read.add_panelist',[])
						@endcan
					@elseif ($tab == 'manage_users')
						@can('manageUsers',$user)
							@include('users.read.manage_users',['managed_users'=>$managed_users])
						@endcan
					@endif
				</div>
			</div>
		</div>

	</section>
@endsection

@section('scripts')
@parent
	<script src="http://malsup.github.com/jquery.form.js"></script>
	<script>
		var deleteUser = function(user_id){
			$("#delete-form-"+user_id).submit();
		};
		$("#profile-picture").click(function(e){
			e.preventDefault();
			$("input[name=image]").trigger('click');
		});
		$("input[name=image]").change(function(e){
			$("#change-pp-form").submit();
		});
		{{--image preview for add panelsit --}}
		@if($tab == 'add_panelist')
			$("input[name=photo]").change(function(e){
				var f = e.target.files[0];
				// Only process image files.
				if (!f.type.match('image.*')) {
					return;
				}
				var reader = new FileReader();


				// Closure to capture the file information.
				reader.onload = (function(theFile) {
					return function(e) {
						// Render thumbnail.
						$("#photo-preview").attr('src',e.target.result);
					};
				})(f);

				// Read in the image file as a data URL.
				reader.readAsDataURL(f);
			});
		@endif
	</script>
@endsection