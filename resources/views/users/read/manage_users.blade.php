<p id="judul">Manage Users</p>
{{-- <div class="dummy-wrapper hide-on-small-only"></div> --}}
<ul class="collection mng-user">	
	@foreach($managed_users as $user)
		<li class="collection-item avatar valign-wrapper">
			<div class="row valign-wrapper">
				<div class="col s12 m5">
					<a href="{{route('home.panelist',['user_id'=>$user->id])}}">
						@if($user->photo_url == '')
							<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="circle responsive-img">
						@else
							<img src="{{$user->photo_url}}" alt="" class="circle responsive-img">
						@endif
						<div id="info-prof">
							<span>{{$user->name}}</span>
							<span>{{$user->tagline}}</span>
						</div>
					</a>
				</div>
				<div class="col s12 m5 hide-on-small-only">
					<span class="right">{{$user->email}}</span>
				</div>
					<form action="{{route('user.delete.post',['user_id'=>$user->id])}}" method="post" id="delete-form-{{$user->id}}">
						{{csrf_field()}}
					</form>
				<div class="col s12 m2">
					<a class="waves-effect waves-light btn-flat modal-trigger del-btn-profile secondary-content" id="" href="#modal-{{$user->id}}">Delete</a>
				</div>
			</div>
			<div id="modal-{{$user->id}}" class="modal modal-layout">
				<div class="modal-content">
					<div class="row">
						<div class="container" id="modal-confirm">
							<div class="col m12">
								<p>Do you want to delete this account?</p>
								<p>This action can’t be undone. <br>
									People will no longer be able to view, share, and have a discussion with this account. All data about this account also will be deleted.
								</p>
								<a class="waves-effect btn-flat modal-close">Cancel</a>
								<a class="waves-effect btn-flat" onclick="deleteUser({{$user->id}})">Delete This User</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</li>
	@endforeach
</ul>
{{-- <ul class="collapsible popout mng-user" data-collapsible="accordion">	
	@foreach($managed_users as $user)
		<li>
			<div class="collapsible-header collaps">
				<div class="mng-user-kiri">
					<img src='{{$user->photo_url}}' class="responsive-img circle">
					<p>{{$user->name}}</p>
				</div>
				<div class="mng-user-kanan">
					<form action="{{route('user.delete.post',['user_id'=>$user->id])}}" method="post" id="delete-form-{{$user->id}}">
						{{csrf_field()}}
					</form>
					<a class="waves-effect waves-light btn-flat modal-trigger del-btn-profile" id="" href="#modal-{{$user->id}}"><i class="material-icons">delete</i></a>
				</div>
			</div>
			<div id="modal-{{$user->id}}" class="modal">
				<div class="modal-content">
					<div class="row">
						<div class="container" id="modal-confirm">
							<div class="col m12">
								<h5>Data pengguna yang Anda pilih akan dihapus (berikut dengan artikel yang di-post oleh panelist)</h5>
								<a class="waves-effect btn-flat ">Cancel</a>
								<a class="waves-effect btn-flat" onclick="deleteUser({{$user->id}})">Delete</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</li>
	@endforeach
</ul> --}}