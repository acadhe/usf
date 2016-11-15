<?php $__env->startSection('navbar'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
	<script type="text/javascript" src="<?php echo e(asset('frontend/js/materialize.min.js')); ?>"></script>
	<!-- <script type="text/javascript" src="<?php echo e(asset('frontend/js/bootstrap.min.js')); ?>"></script> -->
	<script type="text/javascript" src="<?php echo e(asset('frontend/js/main.js')); ?>"></script>
	<script>
		$(document).ready(function(){
		    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
		    $('.modal-trigger').leanModal();
		});
	</script>
	<?php /* script for toast */ ?>
	<?php echo $__env->make('templates.messages.toast_scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldSection(); ?>

<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>