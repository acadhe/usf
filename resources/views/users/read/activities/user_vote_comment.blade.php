<div class="timeline-block left">
	<div class="marker-date"></div>
	<div class="marker"></div>
	<div class="timeline-content">
		<p>{{$notification->getTime()}}</p>
		<div id="wrapper-reply-comment">
			<a href="{{$notification->getUserUrl()}}">
				<img src="{{ $notification->getActorPhotoUrl() }}" class="responsive-img circle pp-timeline">
			</a>
			<a href="{{$notification->getUserUrl()}}">{{$notification->getActorName()}}</a>
			<span>voted your comment</span>
		</div>
		<div class="card">
			<div class="card-content">
				<p class="truncate">{{ $notification->getAdditionalInfo() }}</p>
			</div>
		</div>
		<p>on article <a href="{{$notification->getContextUrl()}}">{{$notification->getContext()}}</a></p>
	</div>
</div>
