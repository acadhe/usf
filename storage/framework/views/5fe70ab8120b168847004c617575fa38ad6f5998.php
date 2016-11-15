<p id="judul">These are topics you have created</p>
<div class="dummy-wrapper"></div>
	<div class="row cardtopics">
		<?php foreach($articles as $article): ?>
			<?php echo $__env->make('templates.articles.card-moderated',compact('article'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php endforeach; ?>
	</div>
