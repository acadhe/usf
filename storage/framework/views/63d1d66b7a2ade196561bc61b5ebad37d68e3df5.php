<?php
use Illuminate\Support\Facades\Auth;
?>
<?php /* this must be encapsulated in auth-guest facade */ ?>
<?php /* since no data about navbar_notification if user is guest*/ ?>
<?php if(!Auth::guest()): ?>

<?php /* ============================= yg ini ga ada notif baru ====================== */ ?>
<li class="hide-on-small-only">
	<a href="#" class="menu lonceng">
		<i class="material-icons">notifications_none</i>
		<?php /* <div class="notification-badge"><?php echo e($navbar_notifications_count); ?></div> */ ?>
	</a>
</li>
<li>
	<a href="<?php echo e(url('notification')); ?>" <?php if($route_name == 'home.notification'): ?> class="menu loncengs valign-wrapper show-on-small hide-on-med-and-up active" <?php endif; ?> class="menu loncengs valign-wrapper show-on-small hide-on-med-and-up">
		<i class="material-icons">notifications_none</i>
		<?php /* <div class="notification-badge"><?php echo e($navbar_notifications_count); ?></div> */ ?>
	</a>
</li>
<?php /* ============================= yg ini ga ada notif baru ====================== */ ?>

<?php /* ============================= yg ini ada notif baru ====================== */ ?>
<?php /* <li> */ ?>
	<a href="#" class="menu lonceng hide">
		<i class="material-icons">notifications_active</i>
	</a>
<?php /* </li> */ ?>
<?php /* ============================= yg ini ada notif baru ====================== */ ?>


<div class="notification webui-popover-content" id="webui-popover">
	<div class="webui-popover-title valign-wrapper">
		<div class="row">
			<div class="col m6">
				<p>Notification</p>
			</div>
			<div class="col m6">
				<a href="<?php echo e(route('user.read',['user_id'=>Auth::user()->id])); ?>">See all activity</a>
			</div>
		</div>
	</div>
	<div class="row" id="content-popover">
		<div class="col m12">
			<div class="collection">
				<ul>
					<?php foreach($navbar_notifications as $notification): ?>
						<script>
							console.log("notification: <?php echo e($notification->getActorPhotoUrl()); ?> <?php echo e($notification->getContextUrl()); ?> <?php echo e($notification->getTime()); ?> <?php echo e($notification->getSentence()); ?>");
						</script>
						<?php /* substr itu karena kalo gak dipake nanti teksnya kepanjangan*/ ?>
						<li>
							<a href="<?php echo e($notification->getContextUrl()); ?>" class="collection-item">
								<div class="row valign-wrapper">
									<div class="col m2">
										<?php if($notification->getActorPhotoUrl() == null): ?>
											<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="" class="circle responsive-img">
										<?php else: ?>
											<img src="<?php echo e($notification->getActorPhotoUrl()); ?>" alt="" class="circle responsive-img profilep-img">
										<?php endif; ?>
									</div>
									<div class="col m10">
										<?php /* <p><?php echo e(substr($notification->getSentence(),0,20)); ?></p> */ ?>
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