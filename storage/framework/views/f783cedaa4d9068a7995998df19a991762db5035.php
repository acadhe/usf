<?php
use Illuminate\Support\Facades\Auth;
?>

<?php $__env->startSection('content'); ?>
	<?php /* this must be encapsulated in auth-guest facade */ ?>
	<?php /* since no data about navbar_notification if user is guest*/ ?>
	<?php if(!Auth::guest()): ?>

	<div class="notification" id="notif-mobile">
		<div class="valign-wrapper">
			<div class="row" id="notif-mobile-header">
				<div class="col s6 m6">
					<p>Notification</p>
				</div>
				<div class="col s6 m6">
					<a href="<?php echo e(route('user.read',['user_id'=>Auth::user()->id])); ?>">See all activity</a>
				</div>
			</div>
		</div>
		<div class="row" id="content-popover">
			<div class="col s12 m12">
				<div class="">
					<ul>
						<?php foreach($navbar_notifications as $notification): ?>
							<script>
								console.log("notification: <?php echo e($notification->getActorPhotoUrl()); ?> <?php echo e($notification->getContextUrl()); ?> <?php echo e($notification->getTime()); ?> <?php echo e($notification->getSentence()); ?>");
							</script>
							<li>
								<a href="<?php echo e($notification->getContextUrl()); ?>">
									<div class="row valign-wrapper">
										<div class="col s3 m2">
											<?php if($notification->getActorPhotoUrl() == null): ?>
												<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="" class="circle responsive-img">
											<?php else: ?>
												<img src="<?php echo e($notification->getActorPhotoUrl()); ?>" alt="" class="circle responsive-img profilep-img">
											<?php endif; ?>
										</div>
										<div class="col s9 m10">
											<p><?php echo e($notification->getSentence()); ?></p>
											<span><?php echo e($notification->getTime()); ?></span>
										</div>
									</div>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
@parent
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>