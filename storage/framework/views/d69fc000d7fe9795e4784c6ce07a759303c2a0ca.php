<div class="timeline-block left">
	<div class="marker-date"></div>
	<div class="marker"></div>
	<div class="timeline-content">
		<p><?php echo e($notification->getTime()); ?></p>
		<div id="wrapper-comment-article">
			<a href="<?php echo e($notification->getUserUrl()); ?>">
				<img src="<?php echo e($notification->getActorPhotoUrl()); ?>" class="responsive-img circle pp-timeline">
			</a>
			<a href="<?php echo e($notification->getUserUrl()); ?>">
				<?php echo e($notification->getActorName()); ?>

			</a>
			<span> commented on an article you created</span>
		</div>
		<div class="card">
			<div class="card-content">
				<p class="truncate"><?php echo e($notification->getAdditionalInfo()); ?></p>
			</div>
		</div>
		<div class="notif-source">
			<i class="material-icons">chrome_reader_mode</i>
			<a href="<?php echo e($notification->getContextUrl()); ?>" class="truncate"><?php echo e($notification->getContext()); ?></a>
		</div>
	</div>
</div>