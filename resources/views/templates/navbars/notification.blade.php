<?php
use Illuminate\Support\Facades\Auth;
?>
{{-- this must be encapsulated in auth-guest facade --}}
{{-- since no data about navbar_notification if user is guest--}}
@if(!Auth::guest())

{{-- ============================= yg ini ga ada notif baru ====================== --}}
<li class="hide-on-small-only">
	<a href="#" class="menu lonceng">
		<i class="material-icons">notifications_none</i>
		{{-- <div class="notification-badge">{{$navbar_notifications_count}}</div> --}}
	</a>
</li>
<li>
	<a href="{{url('notification')}}" @if($route_name == 'home.notification') class="menu loncengs valign-wrapper show-on-small hide-on-med-and-up active" @endif class="menu loncengs valign-wrapper show-on-small hide-on-med-and-up">
		<i class="material-icons">notifications_none</i>
		{{-- <div class="notification-badge">{{$navbar_notifications_count}}</div> --}}
	</a>
</li>
{{-- ============================= yg ini ga ada notif baru ====================== --}}

{{-- ============================= yg ini ada notif baru ====================== --}}
{{-- <li> --}}
	<a href="#" class="menu lonceng hide">
		<i class="material-icons">notifications_active</i>
	</a>
{{-- </li> --}}
{{-- ============================= yg ini ada notif baru ====================== --}}


<div class="notification webui-popover-content" id="webui-popover">
	<div class="webui-popover-title valign-wrapper">
		<div class="row">
			<div class="col m6">
				<p>Notification</p>
			</div>
			<div class="col m6">
				<a href="{{route('user.read',['user_id'=>Auth::user()->id])}}">See all activity</a>
			</div>
		</div>
	</div>
	<div class="row" id="content-popover">
		<div class="col m12">
			<div class="collection">
				<ul>
					@foreach($navbar_notifications as $notification)
						<script>
							console.log("notification: {{$notification->getActorPhotoUrl()}} {{$notification->getContextUrl()}} {{$notification->getTime()}} {{$notification->getSentence()}}");
						</script>
						{{-- substr itu karena kalo gak dipake nanti teksnya kepanjangan--}}
						<li>
							<a href="{{$notification->getContextUrl()}}" class="collection-item">
								<div class="row valign-wrapper">
									<div class="col m2">
										@if($notification->getActorPhotoUrl() == null)
											<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="circle responsive-img">
										@else
											<img src="{{$notification->getActorPhotoUrl()}}" alt="" class="circle responsive-img profilep-img">
										@endif
									</div>
									<div class="col m10">
										{{-- <p>{{substr($notification->getSentence(),0,20)}}</p> --}}
										<p>{{$notification->getSentence()}}</p>
										<span>{{$notification->getTime()}}</span>
									</div>
								</div>
							</a>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>
@endif