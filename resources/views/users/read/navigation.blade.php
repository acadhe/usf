<div class="row" id="navigation-sidebar">
	<div id="wrapper-activity-btn">
		<ul id="nav-mobile" class="left hide-on-med-and-down">
			@can('showActivities',$user)
				<li>
					<a href="{{route('user.read',['user_id'=>$user->id,'tab'=>'activities'])}}" class="@if($tab=='activities') active @endif">Activities</a>
				</li>
			@endcan
			@can('showVotedTopics',$user)
				<li>
					<a href="{{route('user.read',['user_id'=>$user->id,'tab'=>'voted_topics'])}}" class="@if($tab=='voted_topics')active @endif">Recommended Topics</a>
				</li>
			@endcan
			@can('showBookmarkedTopics',$user)
				<li>
					<a href="{{route('user.read',['user_id'=>$user->id,'tab'=>'followed_topics'])}}" class="@if($tab=='followed_topics') active @endif'">Bookmarked Topics</a>
				</li>
			@endcan
			@can('manageUsers',$user)
				<li>
					<a href="{{route('user.read',['user_id'=>$user->id,'tab'=>'manage_users'])}}" class="@if($tab=='manage_users') active @endif">Manage Users</a>
				</li>
			@endcan
			@can('addPanelist',$user)
				<li>
					<a href="{{route('user.read',['user_id'=>$user->id,'tab'=>'add_panelist'])}}" class="@if($tab=='add_panelist') active @endif">Manage Panelist</a>
				</li>
			@endcan
		</ul>
		<ul class="right hide-on-med-and-down">
			<li>
				@can('edit',$user)
					<a href="{{route('user.read',['user_id'=>$user->id,'tab'=>'edit_profile'])}}"  class="@if($tab=='edit_profile') active @endif edprof right">Account Settings</a>
				@endcan
			</li>
		</ul>
	</div>
</div>