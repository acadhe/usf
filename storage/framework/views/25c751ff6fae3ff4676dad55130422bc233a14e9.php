<?php $__env->startSection('content'); ?>
<section id="upd-sum">
	<div class="container">
		<div class="row">
			<div class="col m12">
				<h3>Update summary</h3>
				<span>Title: <p><?php echo e($article->title); ?></p></span>
				<form method="post" action="<?php echo e(route('article.update_summary.post',['article_id'=>$article->id])); ?>">
					<?php echo csrf_field(); ?>

					<textarea id="komen-atas" name="summary" class="materialize-textarea" placeholder="Write your summary to this topic..."><?php echo e($article->summary); ?></textarea>
					<button class="waves-effect btn-flat right comment-submit" type="submit">Post Summary</button>
				</form>
			</div>
		</div>
</div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>