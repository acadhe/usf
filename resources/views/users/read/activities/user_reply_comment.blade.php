<div class="timeline-block left">
	<div class="marker-date"></div>
	<div class="marker"></div>
	<div class="timeline-content">
		<p>{{$notification->getTime()}}</p>
		<div class="valign-wrapper" id="wrapper-reply-comment">
			<a href="{{$notification->getUserUrl()}}" class="valign-wrapper">
				@if($notification->getActorPhotoUrl() == '')
					<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="responsive-img circle pp-timeline">
				@else
					<img src="{{$notification->getActorPhotoUrl()}}" alt="" class="responsive-img circle pp-timeline">
				@endif
			</a>
			<a href="{{$notification->getUserUrl()}}">{{$notification->getActorName()}}</a>
			<span>replied your comment</span>
		</div>
		<div class="card">
			<div class="card-content">
				<p class="truncate">{{ $notification->getAdditionalInfo() }}</p>
			</div>
		</div>
		<p>on article <a href="{{$notification->getContextUrl()}}">{{$notification->getContext()}}</a></p>
	</div>
</div>