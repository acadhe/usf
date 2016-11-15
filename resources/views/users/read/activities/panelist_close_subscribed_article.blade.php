<div class="timeline-block left">
	<div class="marker-date"></div>
	<div class="marker"></div>
	<div class="timeline-content">
		<p>{{$notification->getTime()}}</p>
		<div class="valign-wrapper" id="wrapper-close-subscribe">
			<a href="{{$notification->getUserUrl()}}" class="valign-wrapper">
				{{-- <img src="{{$notification->getActorPhotoUrl()}}" class="responsive-img circle pp-timeline"> --}}
				@if($notification->getActorPhotoUrl() == '')
					<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="responsive-img circle pp-timeline">
				@else
					<img src="{{$notification->getActorPhotoUrl()}}" alt="" class="responsive-img circle pp-timeline">
				@endif
			</a>
			<a href="{{$notification->getUserUrl()}}">
				{{$notification->getActorName()}}
			</a>
			<span> closed a discussion you followed </span>
		</div>
		<div class="card">
			<div class="card-content">
				<p class="truncate">{{ $notification->getContext() }}</p>
			</div>
		</div>
		<p><a href="{{$notification->getContextUrl()}}">view summary</a></p>
	</div>
</div>