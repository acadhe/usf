<?php
use Illuminate\Support\Facades\Auth;
?>
<?php /* this must be encapsulated in auth-guest facade */ ?>
<?php /* since no data about navbar_notification if user is guest*/ ?>
<?php if(!Auth::guest()): ?>
<script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
<script>
    // $(document).ready(function() {
    $('a.lonceng').webuiPopover({
        url:'#webui-popover',
        animation:'fade',
        closeable: false,
        height: 500,
        width: 400,
        title:''
    });
    // });
</script>
<?php endif; ?>