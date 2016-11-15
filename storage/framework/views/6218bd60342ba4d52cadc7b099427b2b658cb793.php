<p class="mp" id="judul">Manage Panelist</p>
<?php /* <div class="dummy-wrapper hide-on-small-only"></div> */ ?>
<div id="add-pan">
	<a class="waves-effect waves-light btn-flat modal-trigger" href="#add-pan-modal">+ add new panelist</a>
</div>
<div id="add-pan-modal" class="modal">
	<p>Add New Panelist</p>
	<form method="post" action="<?php echo e(route('user.create_panelist.post')); ?>" enctype="multipart/form-data" id="create-panelist-form">
		<?php echo csrf_field(); ?>

		<div class="row">
			<?php /* yang perlu dipindah2.*/ ?>
			<div class="input-field col s12 m5 valign-wrapper">

				<?php if($user->photo_url == ''): ?>
					<img src="" class="responsive-img circle" id="photo-preview" title="Choose your header image">
					<div class="up-btn">
						<div class="btn">
							<span>Browse File</span>
							<input name="photo" type="file" title="Choose your header image">
						</div>
					</div>
				<?php else: ?>
					<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" class="responsive-img circle" id="photo-preview" title="Choose your header image">
					<div class="up-btn">
						<div class="btn">
							<span>Browse File</span>
							<input name="photo" type="file" title="Choose your header image">
						</div>
					</div>
				<?php endif; ?>

				<?php /* <label for="photo">Photo (Optional. Max 2MB, gif, jpeg, png, or bmp)</label> */ ?>
				<?php if($errors->has('photo')): ?>
					<?php echo e($errors->first('photo')); ?>

				<?php endif; ?>
			</div>
			<div class="col s12 m7">
				<div class="row">
					<div class="input-field col s12 m12">
						<input type="email" name="email" class="validate" value="<?php echo e(old('email','')); ?>">
						<label for="email">Email</label>
						<?php if($errors->has('email')): ?>
							<?php echo e($errors->first('email')); ?>

						<?php endif; ?>
					</div>
					<div class="input-field col s12 m12">
						<input type="password" name="password" class="validate">
						<label for="password">Add password for the panelist</label>
						<?php if($errors->has('password')): ?>
							<?php echo e($errors->first('password')); ?>

						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12 m12">
				<input id="icon_prefix" name="name" type="text" class="validate" value="<?php echo e(old('name','')); ?>">
				<label for="name">Name of the panelist</label>
				<?php if($errors->has('name')): ?>
					<?php echo e($errors->first('name')); ?>

				<?php endif; ?>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12 m12">
				<input id="icon_prefix" name="tagline" type="text" class="validate" value="<?php echo e(old('tagline','')); ?>">
				<label for="tagline">Who is this panelist?</label>
				<?php if($errors->has('tagline')): ?>
					<?php echo e($errors->first('tagline')); ?>

				<?php endif; ?>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12 m12">
				<input id="icon_prefix" name="description" type="text" class="validate" value="<?php echo e(old('description','')); ?>">
				<label for="description">Add short descriptions for this panelist</label>
				<?php if($errors->has('description')): ?>
					<?php echo e($errors->first('description')); ?>

				<?php endif; ?>
			</div>
		</div>

		<button class="btn-flat waves-effect waves-yellow btn-save-profile right" id="save" type="submit">Add Panelist</button>
	</form>
</div>
<ul class="collection mng-user mng-panelist">
	<?php foreach($managed_users as $user): ?>
		<li class="collection-item avatar valign-wrapper">
			<div class="row valign-wrapper">
				<div class="col s12 m7">
					<a href="<?php echo e(route('home.panelist',['user_id'=>$user->id])); ?>">
					<?php if($user->photo_url == ''): ?>
						<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="" class="circle responsive-img profilep-img">
					<?php else: ?>
						<img src="<?php echo e($user->photo_url); ?>" alt="" class="circle responsive-img profilep-img">
					<?php endif; ?>
					<div id="info-prof">
						<span><?php echo e($user->name); ?></span>
						<span><?php echo e($user->tagline); ?></span>
					</div>
					</a>
				</div>
				<div class="col s12 m3 hide-on-small-only">
					<span class="right grey-text"><?php echo e($user->email); ?></span>
				</div>
					<form action="<?php echo e(route('user.delete.post',['user_id'=>$user->id])); ?>" method="post" id="delete-form-<?php echo e($user->id); ?>">
						<?php echo e(csrf_field()); ?>

					</form>
				<div class="col s12 m2">
					<a class="waves-effect waves-light btn-flat modal-trigger del-btn-profile secondary-content" id="" href="#modal-<?php echo e($user->id); ?>">Delete</a>
				</div>
			</div>
			<div id="modal-<?php echo e($user->id); ?>" class="modal">
				<div class="modal-content">
					<div class="row">
						<div class="container" id="modal-confirm">
							<div class="col s12 m12">
								<h5>Data pengguna yang Anda pilih akan dihapus (berikut dengan artikel yang di-post oleh panelist)</h5>
								<a class="waves-effect btn-flat modal-close">Cancel</a>
								<a class="waves-effect btn-flat" onclick="deleteUser(<?php echo e($user->id); ?>)">Delete</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</li>
	<?php endforeach; ?>
</ul>