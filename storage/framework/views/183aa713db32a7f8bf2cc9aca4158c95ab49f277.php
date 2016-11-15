<?php if(isset($alert_message_success)): ?>
<script>
    var message = '<?php echo e($alert_message_success); ?>';
    Materialize.toast(message,4000);
</script>
<?php endif; ?>
<?php if(isset($alert_message_warning)): ?>
<script>
    var message = '!! <?php echo e($alert_message_warning); ?> !!';
    Materialize.toast(message,4000);
</script>
<?php endif; ?>
<?php if(isset($alert_message_error)): ?>
<script>
    console.log('error');
    var message = 'ERROR: <?php echo e($alert_message_error); ?>';
    Materialize.toast(message,4000);
</script>
<?php endif; ?>
