<div class="timeline-block left">
	<div class="marker-date"></div>
	<div class="marker"></div>
	<div class="timeline-content">
		<p>{{$notification->getTime()}}</p>
		<div class="valign-wrapper" id="wrapper-comment-article">
			<a href="{{$notification->getUserUrl()}}" class="valign-wrapper">
				@if($notification->getActorPhotoUrl() == '')
					<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="responsive-img circle pp-timeline">
				@else
					<img src="{{$notification->getActorPhotoUrl()}}" alt="" class="responsive-img circle pp-timeline">
				@endif
			</a>
			<a href="{{$notification->getUserUrl()}}">
				{{$notification->getActorName()}}
			</a>
			<span> commented on an article you created</span>
		</div>
		<div class="card">
			<div class="card-content">
				<p class="truncate">{{ $notification->getAdditionalInfo() }}</p>
			</div>
		</div>
		<div class="notif-source">
			<i class="material-icons">chrome_reader_mode</i>
			<a href="{{$notification->getContextUrl()}}" class="truncate">{{$notification->getContext()}}</a>
		</div>
	</div>
</div>