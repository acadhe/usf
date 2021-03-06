<p id="judul">Select the field to edit your profile</p>
<?php /* <div class="dummy-wrapper hide-on-small-only"></div> */ ?>
<div id="mob-wrap">
	<div class="card wrapper-card-tabs" id="edit-prof ">
		<div class="card-content wrapper-info-user">
			<p class="head-info-user">Edit Profile</p>
			<div class="row" id="forms-info">
				<form method="post" action="<?php echo e(route('user.edit_profile.name.post',['user_id'=>$user->id])); ?>" class="col s12 m12">
					<?php echo csrf_field(); ?>

					<div class="row">
						<div class="input-field col s12 m12">
							<i class="material-icons prefix">person</i>
							<input id="icon_prefix" name="name" type="text" class="validate" id="name" value="<?php echo e(old('name',$user->name)); ?>">
							<label for="name">Name</label>
							<?php if($errors->has('name')): ?>
								<?php echo e($errors->first('name')); ?>

							<?php endif; ?>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12 m12">
							<i class="material-icons prefix">account_circle</i>
							<input id="icon_prefix" name="tagline" type="text" class="validate" id="tagline" value="<?php echo e(old('tagline',$user->tagline)); ?>">
							<label for="tagline">You are a/an</label>
							<?php if($errors->has('tagline')): ?>
								<?php echo e($errors->first('tagline')); ?>

							<?php endif; ?>
						</div>
					</div>
					<?php if(!$user->isUser()&&!$user->isAdmin()): ?>
						<div class="row">
							<div class="input-field col s12 m12">
								<i class="material-icons prefix">short_text</i>
								<input id="icon_prefix" name="description" type="text" class="validate" id="description" value="<?php echo e(old('description',$user->description)); ?>">
								<label for="description">About you</label>
								<?php if($errors->has('description')): ?>
									<?php echo e($errors->first('description')); ?>

								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
					<button class="btn-flat waves-effect waves-yellow" id="save" type="submit">Save Data</button>
				</form>
			</div>
		</div>
	</div>

	<div class="card wrapper-card-tabs" id="acc-creds">
		<div class="card-content wrapper-info-user">
			<p class="head-info-user">Accoount Credential</p>
			<div class="row" id="forms-cred">
				<form method="post" action="<?php echo e(route('user.edit_profile.email.post',['user_id'=>$user->id])); ?>" class="col s12 m12">
						<?php echo csrf_field(); ?>

						<div class="row">
							<div class="input-field col s12 m12">
								<i class="material-icons prefix">email</i>
								<input type="email" id="email" name="email" class="validate" value="<?php echo e(old('email',$user->email)); ?>">
								<label for="email">Email</label>
								<?php if($errors->has('email')): ?>
									<?php echo e($errors->first('email')); ?>

								<?php endif; ?>
							</div>
						</div>

						<?php /* ADD PASSWORD, KALO MAU DI HIDE/SHOW SEGINI */ ?>
					<?php if($user->password==''): ?>
						<div class="row" id="add-pass">
							<div class="input-field col s12 m12">
								<i class="material-icons prefix">lock</i>
								<a class="waves-effect waves-yellow btn-flat modal-trigger" href="#tbh-pass">&plus; Add password to your account</a>
							</div>
						</div>
						<p id="pass-info">You signed in to UCP using your social media account. By adding password to your account, you can also sign in to UCP by entering your email address and password. And you can still sign in to UCP when your social media account disconnected from UCP.</p>
						<?php /* ADD PASSWORD, KALO MAU DI HIDE/SHOW SEGINI */ ?>
					<?php else: ?>
						<?php /* CHANGE PASSWORD, INI DEFAULTNYA HIDE TINGGAL HAPUS AJA CLASS HIDE NYA. KALO MAU DI HIDE/SHOW SEGINI */ ?>
						<div class="row" id="change-pass">
							<div class="input-field col s12 m12">
								<i class="material-icons prefix">lock</i>
								<a class="waves-effect waves-yellow btn-flat modal-trigger" href="#ch-pass">Change Password</a>
							</div>
						</div>
						<?php /* CHANGE PASSWORD, KALO MAU DI HIDE/SHOW SEGINI */ ?>
					<?php endif; ?>
					<button class="btn-flat waves-effect waves-yellow" id="save" type="submit">Save Data</button>
				</form>
			</div>
		</div>
	</div>

	<div class="card wrapper-card-tabs" id="sosmed">
		<div class="card-content wrapper-info-user">
			<div class="linked-sosmed">
				<p>Linked social media accounts</p>
				<ul>
					<li>
						<?php if($user->facebook_id != null): ?>
							<div class="row valign-wrapper">
								<div class="col s9 m9 valign-wrapper">
									<i class="fa fa-facebook-official active" aria-hidden="true"></i>
									<a href="https://www.facebook.com/<?php echo e($user->facebook_id); ?>" id="fb"><?php echo e($user->facebook_name); ?></a>
								</div>
								<div class="col s3 m3">
									<a href="<?php echo e(route('user.disconnect_socmed',['source'=>'facebook'])); ?>" class="activity-btn">Disconnect</a>
								</div>
							</div>
						<?php else: ?>
							<div class="row valign-wrapper">
								<div class="col s9 m9 valign-wrapper">
									<i class="fa fa-facebook-official" aria-hidden="true"></i>
									<p id="fb">Connect to your Facebook account</p>
								</div>
								<div class="col s3 m3">
									<a href="<?php echo e(route('auth.facebook_redirect',['after_sync_account_url'=>route('user.read',['user_id'=>$user->id,'tab'=>'edit_profile']),'after_callback_url'=>route('user.sync_facebook_account',['user_id'=>$user->id])])); ?>" class="activity-btn">Connect</a>
								</div>
						<?php endif; ?>
					</li>
					<li>
						<?php if($user->twitter_id != null): ?>
							<div class="row valign-wrapper">
								<div class="col s9 m9 valign-wrapper">
									<i class="fa fa-twitter active" aria-hidden="true"></i>
									<a href="https://www.twitter.com/<?php echo e($user->twitter_name); ?>" id="tw">&commat;<?php echo e($user->twitter_name); ?></a>
								</div>
								<div class="col s3 m3">
									<a href="<?php echo e(route('user.disconnect_socmed',['source'=>'twitter'])); ?>" class="activity-btn">Disconnect</a>
								</div>
							</div>
						<?php else: ?>
							<div class="row valign-wrapper">
								<div class="col s9 m9 valign-wrapper">
									<i class="fa fa-twitter" aria-hidden="true"></i>
									<p id="tw">Connect to your Twitter account</p>
								</div>
								<div class="col s3 m3">
									<a href="<?php echo e(route('auth.redirect_twitter',['after_callback_url'=>route('user.sync_twitter_account',['user_id'=>$user->id]),'after_sync_account_url'=>route('user.read',['user_id'=>$user->id,'tab'=>'edit_profile'])])); ?>" class="activity-btn">Connect</a>
								</div>
						<?php endif; ?>
					</li>
					<li>
						<?php if($user->google_plus_id != null): ?>
							<div class="row valign-wrapper">
								<div class="col s9 m9 valign-wrapper">
									<i class="fa fa-google active" aria-hidden="true"></i>
									<a href="https://plus.google.com/<?php echo e($user->google_plus_id); ?>" id="gp"><?php echo e($user->name); ?></a>
								</div>
								<div class="col s3 m3">
									<a href="<?php echo e(route('user.disconnect_socmed',['source'=>'google_plus'])); ?>" class="activity-btn">Disconnect</a>
								</div>
							</div>
						<?php else: ?>
							<div class="row valign-wrapper">
								<div class="col s9 m9 valign-wrapper">
									<i class="fa fa-google" aria-hidden="true"></i>
									<p id="gp">Connect to your Google Plus account</p>
								</div>
								<div class="col s3 m3">
									<a href="<?php echo e(route('auth.google_plus_redirect',['after_callback_url'=>route('user.sync_google_plus_account',['user_id'=>$user->id]),'after_sync_account_url'=>route('user.read',['user_id'=>$user->id,'tab'=>'edit_profile'])])); ?>" class="activity-btn">Connect</a>
								</div>
							</div>
						<?php endif; ?>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('delete',$user)): ?>
		<div class="card wrapper-card-tabs" id="deactive">
			<div class="card-content wrapper-info-user">
				<div class="deactive-area">
					<p>Dangerous Area</p>
					<div class="row">
					<form action="" class="valign-wrapper">
						<i class="material-icons">delete</i>
						<a class="modal-trigger" href="#del-top">Delete My Account</a>
					</form>
					</div>
				</div>
			</div>
		</div>

		<div id="del-top" class="modal">
			<div class="modal-content">
				<p>Do you want to delete this account?</p>
				<p>This action can’t be undone. <br>
				People will no longer be able to view, share, and have a discussion with this account. All data about this account also will be deleted.</p>
			</div>
			<div class="modal-footer">
				<form action="<?php echo e(route('user.delete.post',['user_id'=>$user->id])); ?>" method="post">
				<?php echo csrf_field(); ?>

					<a href="#!" class=" modal-action modal-close btn-flat">Cancel</a>
					<button type="submit" class=" modal-action modal-close btn-flat">Delete My Account</button>
				</form>
			</div>
		</div>
	<?php endif; ?>
</div>


<div id="tbh-pass" class="modal">
	<form action="<?php echo e(route('user.edit_profile.new_password.post',['user_id'=>$user->id])); ?>" method="post">
		<p>Add password to your account</p>
		<?php echo csrf_field(); ?>

		<div class="row">
			<div class="input-field col s12 m12">
				<input type="password" name="password" class="validate">
				<label for="password">Type your password here</label>
			</div>
			<div class="input-field col s12 m12">
				<input type="password" name="repeat_password" class="validate">
				<label for="repeat_password">Re-type your password here</label>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class=" modal-action modal-close waves-effect waves-yellow btn-flat">Save</button>
			<a href="#!" class=" modal-action modal-close waves-effect waves-yellow btn-flat">Cancel</a>
		</div>
	</form>
</div>

<div id="ch-pass" class="modal">
	<form action="<?php echo e(route('user.edit_profile.change_password.post',['user_id'=>$user->id])); ?>" method="post">
		<p>Change Password</p>
		<?php echo csrf_field(); ?>

		<div class="row">
			<div class="input-field col s12 m12">
				<input type="password" name="old_password" class="validate">
				<label for="password">Type your old password here</label>
			</div>
			<div class="input-field col s12 m12">
				<input type="password" name="password" class="validate">
				<label for="password">Type your password here</label>
			</div>
			<div class="input-field col s12 m12">
				<input type="password" name="repeat_password" class="validate">
				<label for="password">Re-type your password here</label>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class=" modal-action modal-close waves-effect waves-yellow btn-flat">Save</button>
			<a href="#!" class=" modal-action modal-close waves-effect waves-yellow btn-flat">Cancel</a>
		</div>
	</form>
</div>