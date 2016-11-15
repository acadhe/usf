<?php
use Illuminate\Support\Facades\Auth;
?>
@extends('templates.master')
@section('content')
	{{-- this must be encapsulated in auth-guest facade --}}
	{{-- since no data about navbar_notification if user is guest--}}
	@if(!Auth::guest())

	<div class="notification" id="notif-mobile">
		<div class="valign-wrapper">
			<div class="row" id="notif-mobile-header">
				<div class="col s6 m6">
					<p>Notification</p>
				</div>
				<div class="col s6 m6">
					<a href="{{route('user.read',['user_id'=>Auth::user()->id])}}">See all activity</a>
				</div>
			</div>
		</div>
		<div class="row" id="content-popover">
			<div class="col s12 m12">
				<div class="">
					<ul>
						@foreach($navbar_notifications as $notification)
							<script>
								console.log("notification: {{$notification->getActorPhotoUrl()}} {{$notification->getContextUrl()}} {{$notification->getTime()}} {{$notification->getSentence()}}");
							</script>
							<li>
								<a href="{{$notification->getContextUrl()}}">
									<div class="row valign-wrapper">
										<div class="col s3 m2">
											@if($notification->getActorPhotoUrl() == null)
												<img src="{{asset('frontend/img/pp/default.jpg')}}" alt="" class="circle responsive-img">
											@else
												<img src="{{$notification->getActorPhotoUrl()}}" alt="" class="circle responsive-img profilep-img">
											@endif
										</div>
										<div class="col s9 m10">
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
@endsection

@section('scripts')
@parent
@endsection