<p class="mp" id="judul">Manage Panelist</p>
{{-- <div class="dummy-wrapper hide-on-small-only"></div> --}}
<div id="add-pan">
	<a class="waves-effect waves-light btn-flat modal-trigger" href="#add-pan-modal">+ add new panelist</a>
</div>
<div id="add-pan-modal" class="modal">
	<p>Add New Panelist</p>
	<form method="post" action="{{route('user.create_panelist.post')}}" enctype="multipart/form-data" id="create-panelist-form">
		{!! csrf_field() !!}
		<div class="row">
			{{-- yang perlu dipindah2.--}}
			<div class="input-field col s12 m5 valign-wrapper">

				@if($user->photo_url == '')
					<img src="" class="responsive-img circle" id="photo-preview" title="Choose your header image">
					<div class="up-btn">
						<div class="btn">
							<span>Browse File</span>
							<input name="photo" type="file" title="Choose your header image">
						</div>
					</div>
				@else
					<img src="{{asset('frontend/img/pp/default.jpg')}}" class="responsive-img circle" id="photo-preview" title="Choose your header image">
					<div class="up-btn">
						<div class="btn">
							<span>Browse File</span>
							<input name="photo" type="file" title="Choose your header image">
						</div>
					</div>
				@endif

				{{-- <label for="photo">Photo (Optional. Max 2MB, gif, jpeg, png, or bmp)</label> --}}
				@if($errors->has('photo'))
					{{$errors->first('photo')}}
				@endif
			</div>
			<div class="col s12 m7">
				<div class="row">
					<div class="input-field col s12 m12">
						<input type="email" name="email" class="validate" value="{{old('email','')}}">
						<label for="email">Email</label>
						@if($errors->has('email'))
							{{$errors->first('email')}}
						@endif
					</div>
					<div class="input-field col s12 m12">
						<input type="password" name="password" class="validate">
						<label for="password">Add password for the panelist</label>
						@if($errors->has('password'))
							{{$errors->first('password')}}
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12 m12">
				<input id="icon_prefix" name="name" type="text" class="validate" value="{{old('name','')}}">
				<label for="name">Name of the panelist</label>
				@if($errors->has('name'))
					{{$errors->first('name')}}
				@endif
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12 m12">
				<input id="icon_prefix" name="tagline" type="text" class="validate" value="{{old('tagline','')}}">
				<label for="tagline">Who is this panelist?</label>
				@if($errors->has('tagline'))
					{{$errors->first('tagline')}}
				@endif
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12 m12">
				<input id="icon_prefix" name="description" type="text" class="validate" value="{{old('description','')}}">
				<label for="description">Add short descriptions for this panelist</label>
				@if($errors->has('description'))
					{{$errors->first('description')}}
				@endif
			</div>
		</div>

		<button class="btn-flat waves-effect waves-yellow btn-save-profile right" id="save" type="submit">Add Panelist</button>
	</form>
</div>
<ul class="collection mng-user mng-panelist">
	@foreach($managed_users as $user)
		<li class="collection-item avatar valign-wrapper">
			<div class="row valign-wrapper">
				<div class="col s12 m7">
					<a href="{{route('home.panelist',['user_id'=>$user->id])}}">
					@if($user->photo_url == '')
						<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="circle responsive-img profilep-img">
					@else
						<img src="{{$user->photo_url}}" alt="" class="circle responsive-img profilep-img">
					@endif
					<div id="info-prof">
						<span>{{$user->name}}</span>
						<span>{{$user->tagline}}</span>
					</div>
					</a>
				</div>
				<div class="col s12 m3 hide-on-small-only">
					<span class="right grey-text">{{$user->email}}</span>
				</div>
					<form action="{{route('user.delete.post',['user_id'=>$user->id])}}" method="post" id="delete-form-{{$user->id}}">
						{{csrf_field()}}
					</form>
				<div class="col s12 m2">
					<a class="waves-effect waves-light btn-flat modal-trigger del-btn-profile secondary-content" id="" href="#modal-{{$user->id}}">Delete</a>
				</div>
			</div>
			<div id="modal-{{$user->id}}" class="modal">
				<div class="modal-content">
					<div class="row">
						<div class="container" id="modal-confirm">
							<div class="col s12 m12">
								<h5>Data pengguna yang Anda pilih akan dihapus (berikut dengan artikel yang di-post oleh panelist)</h5>
								<a class="waves-effect btn-flat modal-close">Cancel</a>
								<a class="waves-effect btn-flat" onclick="deleteUser({{$user->id}})">Delete</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</li>
	@endforeach
</ul>