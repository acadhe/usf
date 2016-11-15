<div class="timeline-block left">
	<div class="marker-date"></div>
	<div class="marker"></div>
	<div class="timeline-content">
		<p><?php echo e($notification->getTime()); ?></p>
		<div class="valign-wrapper" id="wrapper-reply-comment">
			<a href="<?php echo e($notification->getUserUrl()); ?>" class="valign-wrapper">
				<?php if($notification->getActorPhotoUrl() == ''): ?>
					<img src="<?php echo e(asset('frontend/img/pp/default.jpg')); ?>" alt="" class="responsive-img circle pp-timeline">
				<?php else: ?>
					<img src="<?php echo e($notification->getActorPhotoUrl()); ?>" alt="" class="responsive-img circle pp-timeline">
				<?php endif; ?>
			</a>
			<a href="<?php echo e($notification->getUserUrl()); ?>"><?php echo e($notification->getActorName()); ?></a>
			<span>replied your comment</span>
		</div>
		<div class="card">
			<div class="card-content">
				<p class="truncate"><?php echo e($notification->getAdditionalInfo()); ?></p>
			</div>
		</div>
		<p>on article <a href="<?php echo e($notification->getContextUrl()); ?>"><?php echo e($notification->getContext()); ?></a></p>
	</div>
</div>