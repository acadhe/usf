<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('showActivities',$user)): ?>
	<li>
		<a href="<?php echo e(route('user.read',['user_id'=>$user->id,'tab'=>'activities'])); ?>" class="<?php if($tab=='activities'): ?> active <?php endif; ?>">Activities</a>
	</li>
<?php endif; ?>
<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('showVotedTopics',$user)): ?>
	<li>
		<a href="<?php echo e(route('user.read',['user_id'=>$user->id,'tab'=>'voted_topics'])); ?>" class="<?php if($tab=='voted_topics'): ?>active <?php endif; ?>">Recommended Topics</a>
	</li>
<?php endif; ?>
<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('showBookmarkedTopics',$user)): ?>
	<li>
		<a href="<?php echo e(route('user.read',['user_id'=>$user->id,'tab'=>'followed_topics'])); ?>" class="<?php if($tab=='followed_topics'): ?> active <?php endif; ?>'">Bookmarked Topics</a>
	</li>
<?php endif; ?>
<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('manageUsers',$user)): ?>
	<li>
		<a href="<?php echo e(route('user.read',['user_id'=>$user->id,'tab'=>'manage_users'])); ?>" class="<?php if($tab=='manage_users'): ?> active <?php endif; ?>">Manage Users</a>
	</li>
<?php endif; ?>
<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('addPanelist',$user)): ?>
	<li>
		<a href="<?php echo e(route('user.read',['user_id'=>$user->id,'tab'=>'add_panelist'])); ?>" class="<?php if($tab=='add_panelist'): ?> active <?php endif; ?>">Manage Panelist</a>
	</li>
<?php endif; ?>
<?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('edit',$user)): ?>
	<li>
		<a href="<?php echo e(route('user.read',['user_id'=>$user->id,'tab'=>'edit_profile'])); ?>"  class="<?php if($tab=='edit_profile'): ?> active <?php endif; ?> edprof">Account Settings</a>
	</li>
<?php endif; ?>