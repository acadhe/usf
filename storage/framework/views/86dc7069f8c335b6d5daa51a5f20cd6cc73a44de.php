<div class="timeline-block left">
	<div class="marker-date"></div>
	<div class="marker"></div>
	<div class="timeline-content">
		<p><?php echo e($notification->getTime()); ?></p>
		<div class="valign-wrapper" id="wrapper-close-subscribe">
			<a href="<?php echo e($notification->getUserUrl()); ?>" class="valign-wrapper">
				<?php /* <img src="<?php echo e($notification->getActorPhotoUrl()); ?>" class="responsive-img circle pp-timeline"> */ ?>
				<?php if($notification->getActorPhotoUrl() == ''): ?>
					<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="" class="responsive-img circle pp-timeline">
				<?php else: ?>
					<img src="<?php echo e($notification->getActorPhotoUrl()); ?>" alt="" class="responsive-img circle pp-timeline">
				<?php endif; ?>
			</a>
			<a href="<?php echo e($notification->getUserUrl()); ?>">
				<?php echo e($notification->getActorName()); ?>

			</a>
			<span> closed a discussion you followed </span>
		</div>
		<div class="card">
			<div class="card-content">
				<p class="truncate"><?php echo e($notification->getContext()); ?></p>
			</div>
		</div>
		<p><a href="<?php echo e($notification->getContextUrl()); ?>">view summary</a></p>
	</div>
</div>