@extends('templates.master')
{{-- @section('head')
@parent
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500" rel="stylesheet">
@endsection --}}

@section('navbar')
@endsection

@section('content')
		<section id="usf-pdf">
			<div class="head-usf-pdf">
				<div class="container" id="wrapper-usf-pdf">    
					<div class="row">
						<div class="col m4 s12" id="usf-pdf-logo">
							<img src="{{ asset('frontend/img/logo_USF_2016.jpg') }}" alt="USF Speakers" class="ic responsive-img">
						</div>
						<div class="col m7 s12" id="usf-pdf-info">
							<p>Coming Soon</p>
							<hr>
							<p>December <span>2016</span><br> Semarang, Indonesia</p>
							<div class="row">
								<div class="col m5">
									{{-- <a class="waves-effect waves-light btn modal-trigger" href="#pdf">
										<i class="material-icons left">file_download</i>
										<span>3</span><sup>rd</sup> Urban Social Forum <span>2015</span> Event Report
										<br>
										<span id="dwnld">DOWNLOAD HERE</span>
									</a> --}}
									<a class="waves-effect waves-light btn" href="#">
										Download <span>3</span><sup>rd</sup> Urban Social Forum <span>2015</span> Event Report
									</a>
									<a class="waves-effect waves-light btn" href="http://www.kotakita.org/publications-docs/3rd%20Urban%20Social%20Forum%20Event%20Report_ENG.pdf" target="_blank">
										ENGLISH
									</a>
									<a class="waves-effect waves-light btn" href="http://www.kotakita.org/publications-docs/3rd%20Urban%20Social%20Forum%20Event%20Report_IND.pdf" target="_blank">
										BAHASA
									</a>
								</div>
								<div class="col m7">
									<img src="{{ asset('frontend/img/thumb.jpg')}}" alt="USF Speakers" class="ic responsive-img">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="wrapper-countdown">
				<ul id="countdown">
					<li id="days">
						<div class="number"><p>00</p></div>
						<div class="label">Days</div>
					</li>
					<li class="separator">
						<p>:</p>
					</li>
					<li id="hours">
						<div class="number"><p>00</p></div>
						<div class="label">Hours</div>
					</li>
					<li class="separator">
						<p>:</p>
					</li>
					<li id="minutes">
						<div class="number"><p>00</p></div>
						<div class="label">Minutes</div>
					</li>
					<li class="separator">
						<p>:</p>
					</li>
					<li id="seconds">
						<div class="number"><p>00</p></div>
						<div class="label">Seconds</div>
					</li>
				</ul>
			</div>
		</section>

		<!-- Modal Structure -->
{{-- 		<div class="modal pdf-modal" id="pdf">
			<div class="modal-content center-align">
				<p>Download the 3rd Urban Social Forum event report</p>
				<img src="{{ asset('frontend/img/image_thumbnails.jpg') }}" alt="USF Speakers" class="ic responsive-img">
				<p>Please choose the language of the report</p>
				<a href="http://www.kotakita.org/publications-docs/3rd%20Urban%20Social%20Forum%20Event%20Report_ENG.pdf" class="waves-effect waves-light btn btn-pdf btn-white">English</a>
				<a href="http://www.kotakita.org/publications-docs/3rd%20Urban%20Social%20Forum%20Event%20Report_IND.pdf" class="waves-effect waves-light btn btn-pdf btn-black">Bahasa</a>
			</div>
		</div> --}}
@endsection