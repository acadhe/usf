<?php
use App\Models\NotificationObject;
?>

<?php $__env->startSection('content'); ?>
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
											<?php if($user->photo_url == ''): ?>
												<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" class="responsive-img def" id="img-pp">
												<span>
													Add Profile Picture (Max. 2MB)
													<i class="material-icons">add_a_photo</i>
												</span>
											<?php else: ?>
												<img src="<?php echo e($user->photo_url); ?>" class="responsive-img" id="img-pp">
												<span>
													Change Profile Picture <br>(Max. 2MB)
													<i class="material-icons">photo_camera</i>
												</span>
											<?php endif; ?>
										</a>
										<form method="post" enctype="multipart/form-data" id="change-pp-form" action="<?php echo e(route('user.update_picture.post')); ?>">
											<?php echo csrf_field(); ?>

											<input type="file" name="image" style="display: none;"/>
										</form>
									</figure>
								</div>
									<div class="divider"></div>

								<div class="about-profile">
									<?php if($user->isAdmin()): ?>
										<p>Admin</p>
									<?php elseif($user->isPanelist()): ?>
										<p>Panelist</p>
									<?php else: ?>
										<p>General User</p>
									<?php endif; ?>
										<p><?php echo e($user->name); ?></p>

									<?php if($user->isAdmin()): ?>
									<?php elseif($user->isPanelist()): ?>
										<p><?php echo e($user->tagline); ?></p>
										<p><?php echo e($user->description); ?></p>
									<?php elseif($user->isUser()): ?>
										<p><?php echo e($user->tagline); ?></p>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php /* mobile view */ ?>
				<div class="col s12 m3 show-on-small hide-on-med-and-up" id="card-user-mobile">
					<div id="aside">
						<div class="card">
							<div class="card-content" id="wrapper-info-user">
								<div id="sect-atas">
									<figure>
										<a href="#" id="profile-picture">
											<?php if($user->photo_url == ''): ?>
												<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" class="responsive-img def" id="img-pp">
												<span>
													Add Profile Picture (Max. 2MB)
													<i class="material-icons">add_a_photo</i>
												</span>
											<?php else: ?>
												<img src="<?php echo e($user->photo_url); ?>" class="responsive-img" id="img-pp">
												<span>
													Change Profile Picture <br>(Max. 2MB)
													<i class="material-icons">photo_camera</i>
												</span>
											<?php endif; ?>
										</a>
										<form method="post" enctype="multipart/form-data" id="change-pp-form" action="<?php echo e(route('user.update_picture.post')); ?>">
											<?php echo csrf_field(); ?>

											<input type="file" name="image" style="display: none;"/>
										</form>
									</figure>
								</div>
									<div class="divider"></div>

								<div class="about-profile">
									<?php if($user->isAdmin()): ?>
										<p>Admin</p>
									<?php elseif($user->isPanelist()): ?>
										<p>Panelist</p>
									<?php else: ?>
										<p>General User</p>
									<?php endif; ?>
										<p><?php echo e($user->name); ?></p>

									<?php if($user->isAdmin()): ?>
									<?php elseif($user->isPanelist()): ?>
										<p><?php echo e($user->tagline); ?></p>
										<p><?php echo e($user->description); ?></p>
									<?php elseif($user->isUser()): ?>
										<p><?php echo e($user->tagline); ?></p>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php /* mobile view */ ?>

				<div class="col s12 m9" id="card-user-kanan">
					<?php if($tab == 'followed_topics'): ?>
						<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('showBookmarkedTopics',$user)): ?>
							<?php echo $__env->make('users.read.bookmarked_topics',['articles'=>$articles], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						<?php endif; ?>
					<?php elseif($tab == 'activities'): ?>
						<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('showActivities',$user)): ?>
							<?php echo $__env->make('users.read.activities',['notifications'=>$notifications], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						<?php endif; ?>
					<?php elseif($tab == 'moderated_topics'): ?>
						<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('showModeratedTopics',$user)): ?>
							<?php echo $__env->make('users.read.moderated_topics',['articles'=>$articles], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						<?php endif; ?>
					<?php elseif($tab == 'voted_topics'): ?>
						<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('showVotedTopics',$user)): ?>
							<?php echo $__env->make('users.read.voted_topics',['articles' => $articles], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						<?php endif; ?>
					<?php elseif($tab == 'edit_profile'): ?>
						<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('edit',$user)): ?>
							<?php echo $__env->make('users.read.edit_profile',['user'=>$user], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						<?php endif; ?>
					<?php elseif($tab == 'add_panelist'): ?>
						<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('addPanelist',$user)): ?>
							<?php echo $__env->make('users.read.add_panelist',[], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						<?php endif; ?>
					<?php elseif($tab == 'manage_users'): ?>
						<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('manageUsers',$user)): ?>
							<?php echo $__env->make('users.read.manage_users',['managed_users'=>$managed_users], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>

	</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
		<?php /*image preview for add panelsit */ ?>
		<?php if($tab == 'add_panelist'): ?>
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
		<?php endif; ?>
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master-profile', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>