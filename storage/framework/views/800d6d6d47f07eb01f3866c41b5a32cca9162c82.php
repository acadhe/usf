<?php $__env->startSection('content'); ?>

<section id="atas-mine">
	<div class="container">
		<div class="row valign-wrapper">
			<div class="col s6 m6"><h3>Your Topics</h3></div>
			<div class="col s6 m6">
				<a href="<?php echo e(route('article.create')); ?>" class="waves-effect btn-flat right" id="write-post">Write Article</a>
			</div>
		</div>
	</div>
</section>

<section id="bawah-mine">
	<div class="container">
		<div class="row">
			<div class="col s12 m12">
				<?php foreach($articles as $article): ?>
					<div class="row wrapper-mine-bawah">
						<div class="col s7 m7" id="mine-kiri">
							<div class="judul">
								<div class="valign-wrapper" id="vw">
									<div class="valign truncate">
										<?php if($article->title == ''): ?>
											<a href="<?php echo e(route('article.read',['article_id'=>$article->id])); ?>">Untitled story</a>
										<?php else: ?>
											<a href="<?php echo e(route('article.read',['article_id'=>$article->id])); ?>"><?php echo e($article->title); ?></a>
										<?php endif; ?>
										<a href="#">
											<p class="title-cards"><?php echo e($article->category); ?></p>
										</a>
										<p class="private">
											<?php echo e($article->privacy); ?> on <?php echo e($article->updated_at->formatLocalized("%d %B %Y")); ?>

										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col s5 m5 valign-wrapper" id="mine-kanan">
							<div class="row">
								<div class="mng" id="delete">
									<form style="display: none;"
										  action="<?php echo e(route('article.delete.post',['article_id'=>$article->id])); ?>"
										  method="post" id="delete-post-<?php echo e($article->id); ?>">
										<?php echo csrf_field(); ?>

									</form>
									<a href="#del-top" class="waves-effect waves-light btn-flat modal-trigger tooltipped" data-activates="dropdown<?php echo e($article->id); ?>" data-position="top" data-delay="50" data-tooltip="Delete This Topic" id="del">
										<i class="material-icons">delete</i>
									</a>
								</div>
								<div class="mng">
									<?php if($article->open): ?>
										<div id="edit">
											<a href="<?php echo e(route('article.update',['article_id'=>$article->id])); ?>" class="waves-effect waves-light btn-flat tooltipped" data-activates="dropdown<?php echo e($article->id); ?>" data-position="top" data-delay="50" data-tooltip="Edit This Topic">
												<i class="material-icons">edit</i>
											</a>
										</div>
									<?php else: ?>
										<div id="edit">
											<a class="waves-effect waves-light btn-flat tooltipped" data-activates="dropdown<?php echo e($article->id); ?>" data-position="top" data-delay="50" data-tooltip="Topic Closed">
												<i class="material-icons">block</i>
											</a>
											<?php /* <a href="<?php echo e(route('article.update_summary',['article_id'=>$article->id])); ?>" class="waves-effect waves-light btn-flat">Write Summary</a> */ ?>
										</div>
									<?php endif; ?>
								</div>
								<?php /* <div class="mng" id="close">
									<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('close',$article)): ?>
										<a href="<?php echo e(route('article.read',['article_id'=>$article->id,'intent_close_article'=>true])); ?>" class="btn-flat waves-effect waves-light">Close Topic</a>
									<?php endif; ?>
								</div> */ ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				<div id="del-top" class="modal">
					<div class="modal-content">
						<p>Do you want to delete this topic?</p>
						<p>This action can’t be undone. <br>
						People will no longer be able to view, share, and have a discussion with this topic.</p>
					</div>
					<div class="modal-footer">
						<a href="#!" class=" modal-action modal-close btn-flat">Cancel</a>
						<a href="javascript:void(0);" class="waves-effect waves-light btn-flat modal-action modal-close" onclick="deletePost('delete-post-<?php echo e($article->id); ?>')">Delete This Topic</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	function deletePost(articleDOMId){
		document.getElementById(articleDOMId).submit();
	}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>