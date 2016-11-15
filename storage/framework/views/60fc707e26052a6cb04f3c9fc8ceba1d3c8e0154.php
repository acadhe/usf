<?php $__env->startSection('content'); ?>
	<section id="form">
		<form action="<?php echo e(route('article.update.post',['article_id'=>$article->id])); ?>" method="post" id="form" enctype="multipart/form-data">
			<?php echo $__env->make('articles._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		</form>
	</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master-articles', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>