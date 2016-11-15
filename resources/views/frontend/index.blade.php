@extends('templates.master')
@section('head')
{{-- @parent --}}
{{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
<meta name="csrf_token" content="{{csrf_token()}}"/>
<title>Urban Social Forum 2016</title>
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/slick.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/slick-theme-ucp.css') }}"/>
<link rel="stylesheet" href="{{asset('frontend/css/styles.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/img/faviconss/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" href="{{ asset('frontend/img/faviconss/favicon-32x32.png') }}" sizes="32x32">
<link rel="icon" type="image/png" href="{{ asset('frontend/img/faviconss/favicon-16x16.png') }}" sizes="16x16">
<link rel="manifest" href="{{ asset('frontend/img/faviconss/manifest.json') }}">
<link rel="mask-icon" href="{{ asset('frontend/img/faviconss/safari-pinned-tab.svg') }}" color="#5bbad5">
<meta name="theme-color" content="#ffffff">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
@endsection

@section('navbar')
<nav class="nav-master" id="usf-navbar">
	<div class="container nav-wrapper">
		<a href="#!" class="show-on-md-down hide-lg mobile-header">Urban Social Forum 2016</a>
		<a href="#" data-activates="mobile-demo" class="button-collapse">
			<i class="material-icons">menu</i>
		</a>
		<ul id="nav-mobile" class="hide-on-med-and-down">
			<li><a href="#usf">home</a></li>
			<li><a href="#bawah-usf-about">about</a></li>
			<li><a href="#part">participate</a></li>
			<li><a href="#sch">schedule</a></li>
			<li><a href="#loc">Location</a></li>
			<li><a href="#ach">archive</a></li>
			<li><a href="#wrapper-org-part-header">organizer &amp; partners</a></li>
			<li><a href="#cu">contact us</a></li>
		</ul>
		<ul class="side-nav" id="mobile-demo">
			<li><a href="#usf">home</a></li>
			<li><a href="#bawah-usf-about">about</a></li>
			<li><a href="#part">participate</a></li>
			<li><a href="#schedule">schedule</a></li>
			<li><a href="#location">Location</a></li>
			<li><a href="#archieve">archive</a></li>
			<li><a href="#wrapper-org-part-header">organizer &amp; partners</a></li>
			<li><a href="#card-contact-soon">contact us</a></li>
		</ul>
	</div>
</nav>
@endsection

@section('content')
	<section class="scrollspy" id="usf">
		<div class="bg-usf">
			<div class="container cards" id="headusf-bg-layer">
				<div class="row">
					<div class="col s12 m12 card-headusf">
						<div class="card">
							<div class="card-content">
								<div class="wrapper-card-headusf">
									<div class="row">
										<div class="col s12 m6">
											<div id="wrapper-usf-logo">
												<img src="{{asset('frontend/img/header.png')}}" class="img-responsive" alt="USF Logo" id="usf-logo">
											</div>
										</div>
										<div class="col s12 m6">
											<div id="wrapper-usf-reg">
												<p>The 4<sup>th</sup> Urban Social Forum</p>
												<p>December 3<sup>rd</sup>, 2016</p>
												<p>Semarang, Indonesia</p>
												<p>The Urban Social Forum is an annual event that provides an open and inclusive space for exchanging of knowledge, debating ideas, and networking between civil society organisations, activists, academics, and students working on pressing urban issues. Ultimately, the Forum is a truly public and democratic space for people to put forward alternative ideas and imagine ‘Another City is Possible!’<br>We invite you to be a part of the movement.</p>
												{{-- <a href="http://bit.ly/RegistrasiUSF2016" class="btn btn-usf" target="_blank">JOIN AS A PARTICIPANT</a> --}}
												<a href="https://bit.ly/usfsmg16" class="btn btn-usf" target="_blank">JOIN AS A PARTICIPANT</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="hide-on-small-only" id="bg-usf">
		<img src="{{asset('frontend/img/bg_21.png')}}" alt="mic">
	</div>

	<section id="countdown">
		<div class="row">
			<div class="wrapper-countdown col s12 m12">
				<ul id="countdown">
					<li id="days">
						<div class="number"><p>00</p></div>
						<div class="label">Days</div>
					</li>
					<li id="hours">
						<div class="number"><p>00</p></div>
						<div class="label">Hours</div>
					</li>
					<li id="minutes">
						<div class="number"><p>00</p></div>
						<div class="label">Mins</div>
					</li>
					<li id="seconds">
						<div class="number"><p>00</p></div>
						<div class="label">Secs</div>
					</li>
				</ul>
			</div>
		</div>
	</section>

	<section class="scrollspy" id="usf-about">
		<div class="container" id="usf-about-wrapper">
			<div class="row">
				<div class="col s12 m12 scrollspy" id="atas-usf-about">
					<p>
						Join us in imagining, creating, and affirming<br>
						<span>'Another City is Possible!’</span>
					</p>
				</div>
				<div class="col s12 m12 scrollspy" id="bawah-usf-about">
					<div id="wrapper-bawah-usf-about">
						<p>
							Greetings from the Organizing Committee of the 4<sup>th</sup> Urban Social Forum!  Year after year the Urban Social Forum grows, in doing so it expands the conversation about better cities to include more and more people, communities, and ideas. The Forum believes in the need to urgently advocate for and promote a more socially just, sustainable and democratic city, and that active citizen participation is needed to achieve these goals.
						</p>
						<p>
							We would like to invite you and your organisation to play an active role in this year’s Forum. There will be different ways you can participate, but ultimately you will have the opportunity to raise the awareness of, and connect with, people from across Indonesia about the issue that you care about, and promote new perspectives, ideas, and innovations.
						</p>
					</div>
				</div>

			</div>
		</div>
	</section>

	<section class="scrollspy" id="participate">
		<div class="container" id="participate-wrapper">
			<div class="row">
				<div class="col s12 m12 scrollspy" id="card-participate">
					<div class="card">
						<div class="card-content" id="card-participate-content">
							<div class="wrapper-card-participate">
								<div class="row">
									<div class="col s12 m12">
										<div id="wrapper-participate-header">
											<div class="row">
												<div class="col s2 m2">
													<div class="card card-round">
														<div class="card-content card-round-content">
															<i class="fa fa-bullhorn" aria-hidden="true"></i>
														</div>
													</div>
												</div>
												<div class="col s10 m10">
													<p>
														how to participate
													</p>
													<span class="scrollspy" id="part">There will be different ways you can participate in this year’s Forum. Find out how in the following buttons:</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col s12 m12 scrollspy" id="pat">
										<div id="wrapper-participate-choice">
											<ul>
												<li>
													<div class="choice-round">
														{{-- <a href="http://bit.ly/OrganiserUSF2016" target="_blank"> --}}
														<a href="http://bit.ly/organiserusf2016" target="_blank">
															<div id="choice-round-oren">
																<div class="card-round-content valign-wrapper">
																	<div class="card-round-content-line valign-wrapper">
																		<p class="valign">Panel <br> Organizer</p>
																	</div>
																</div>
															</div>
														</a>
													</div>
												</li>
												<li>
													<div class="choice-round">
														{{-- <a href="http://bit.ly/VolunteerUSF2016" target="_blank"> --}}
														<a href="http://bit.ly/volunteerusf2016" target="_blank">
															<div id="choice-round-biru">
																<div class="card-round-content valign-wrapper">
																	<div class="card-round-content-line valign-wrapper">
																		<p class="valign">volunteer</p>
																	</div>
																</div>
															</div>
														</a>
													</div>
												</li>
												<li>
													<div class="choice-round">
														{{-- <a href="http://bit.ly/BoothUSF2016" target="_blank"> --}}
														<a href="http://bit.ly/boothusf2016" target="_blank">
															<div id="choice-round-ungu">
																<div class="card-round-content valign-wrapper">
																	<div class="card-round-content-line valign-wrapper">
																		<p class="valign">exhibitor</p>
																	</div>
																</div>
															</div>
														</a>
													</div>
												</li>
												<li>
													<div class="choice-round">
														{{-- <a href="http://bit.ly/KontributorUSF2016" target="_blank"> --}}
														<a href="http://bit.ly/kontributorusf2016" target="_blank">
															<div id="choice-round-merah">
																<div class="card-round-content valign-wrapper">
																	<div class="card-round-content-line valign-wrapper">
																		<p class="valign">other roles</p>
																	</div>
																</div>
															</div>
														</a>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	{{-- <div id="bg-participate">
		<img src="{{asset('frontend/img/bg_11.png')}}" alt="mic">
	</div> --}}

{{-- 	<section class="scrollspy" id="schedule-soon">
		<div class="container" id="schedule-wrapper">
			<div class="row">
				<div class="col s12 m12" id="header-schedule">
					<div id="wrapper-schedule-header">
						<div class="row">
							<div class="col m2">
								<div class="card card-round">
									<div class="card-content card-round-content">
										<i class="material-icons">event_note</i>
									</div>
								</div>
							</div>
							<div class="col m10">
								<p>
									schedule
								</p>
								<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti quia aperiam</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="valign-wrapper" id="wrapper-schedule-soon">
			<div class="row valign">
				<div class="col m12">
					<p>Coming soon!</p>
					<p> We're preparing the fun stuff for you</p>
				</div>
			</div>
		</div>
	</section> --}}

{{--    <section class="scrollspy" id="speakers">
		<div class="row">
			<div class="container cards" id="wrapper-speakers">
				<div class="row">
					<div class="col m2" id="speakers-badge">
						<img src="{{ asset('frontend/img/ic_speaker_2.svg') }}" alt="USF Speakers" class="ic">
					</div>
					<div class="col m8" id="speakers-slider">
						<p class="speakers-intro">Awesome, dedicated, and inspirational people; Expertise on city issues. Sharing their thoughts on current issues.</p>
						<div class="row" id="wrapper-slider">
							<div class="carousel-speakers">
							
								<div class="row">
									<div class="container">
										<div class="row center-card">
											<div class="card">
												<div class="card-content">
													<div class="wrapper-card-speakers">
														<div>
															<div class="img-carousel">
																<a href=""><img src="{{asset('frontend/img/pp1.png')}}" alt="" class="responsive-img circle"></a>
															</div>
															<div class="info-carousel">
																<p>Vasilenka</p>
																<p>CCO Meridian.id</p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							
							
								<div class="row">
									<div class="container">
										<div class="row center-card">
											<div class="card">
												<div class="card-content">
													<div class="wrapper-card-speakers">
														<div>
															<div class="img-carousel">
																<a href=""><img src="{{asset('frontend/img/pp2.jpg')}}" alt="" class="responsive-img circle"></a>
															</div>
															<div class="info-carousel">
																<p>Vasilenka</p>
																<p>CCO Meridian.id</p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							
							
								<div class="row">
									<div class="container">
										<div class="row center-card">
											<div class="card">
												<div class="card-content">
													<div class="wrapper-card-speakers">
														<div>
															<div class="img-carousel">
																<a href=""><img src="{{asset('frontend/img/pp3.jpg')}}" alt="" class="responsive-img circle"></a>
															</div>
															<div class="info-carousel">
																<p>Vasilenka</p>
																<p>CCO Meridian.id</p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							
							
								<div class="row">
									<div class="container">
										<div class="row center-card">
											<div class="card">
												<div class="card-content">
													<div class="wrapper-card-speakers">
														<div>
															<div class="img-carousel">
																<a href=""><img src="{{asset('frontend/img/pp4.jpg')}}" alt="" class="responsive-img circle"></a>
															</div>
															<div class="info-carousel">
																<p>Vasilenka</p>
																<p>CCO Meridian.id</p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							
							
								<div class="row">
									<div class="container">
										<div class="row center-card">
											<div class="card">
												<div class="card-content">
													<div class="wrapper-card-speakers">
														<div>
															<div class="img-carousel">
																<a href=""><img src="{{asset('frontend/img/pp5.jpg')}}" alt="" class="responsive-img circle"></a>
															</div>
															<div class="info-carousel">
																<p>Vasilenka</p>
																<p>CCO Meridian.id</p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							
							
								<div class="row">
									<div class="container">
										<div class="row center-card">
											<div class="card">
												<div class="card-content">
													<div class="wrapper-card-speakers">
														<div>
															<div class="img-carousel">
																<a href=""><img src="{{asset('frontend/img/pp6.png')}}" alt="" class="responsive-img circle"></a>
															</div>
															<div class="info-carousel">
																<p>Vasilenka</p>
																<p>CCO Meridian.id</p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							
							
								<div class="row">
									<div class="container">
										<div class="row center-card">
											<div class="card">
												<div class="card-content">
													<div class="wrapper-card-speakers">
														<div>
															<div class="img-carousel">
																<a href=""><img src="{{asset('frontend/img/pp7.jpg')}}" alt="" class="responsive-img circle"></a>
															</div>
															<div class="info-carousel">
																<p>Vasilenka</p>
																<p>CCO Meridian.id</p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> --}}

	{{-- <div id="bg-mic">
		<img src="{{asset('frontend/img/img_mic.svg')}}" alt="mic" class="ic">
	</div> --}}

{{--    <section class="scrollspy" id="discussions">
		<div class="row">
			<div class="container cards" id="wrapper-discussions">
				<div class="row">
					<div class="col m9" id="discussions-info">
						<p>Count down to the event day</p>
						<p>Follow the discussions on Urban Communities of Practice and contribute your ideas and thoughts on current city issues.</p>
						<p>Popular discussions on UCP</p>
					</div>
					<div class="col m3" id="discussions-badge">
						<img src="{{ asset('frontend/img/ic_discussion.svg') }}" alt="USF Speakers" class="ic">
					</div>
				</div>
				<div class="row">
					<div class="col m12">
						<div class="row" id="wrapper-slider">
							<div class="carousel-discussions">
								
								<div class="row">
									<div class="container discussions-card-usf">
										<div class="row center-card">
											<div class="card">
												<div class="card-image">
													<img src="{{asset('frontend/img/post.jpg')}}" alt="">
												</div>
												<div class="card-content">
													<p>Vasilenka</p>
													<a href="#" class="truncate">I am a very simple card.</a>
												</div>
												<div class="card-action">
													<a href="#">Read more on UCP</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								
								<div class="row">
									<div class="container discussions-card-usf">
										<div class="row center-card">
											<div class="card">
												<div class="card-image">
													<img src="{{asset('frontend/img/post.jpg')}}" alt="">
												</div>
												<div class="card-content">
													<p>Vasilenka</p>
													<a href="#" class="truncate">I am a very simple card.</h5>
												</div>
												<div class="card-action">
													<a href="#">Read more on UCP</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								
								<div class="row">
									<div class="container discussions-card-usf">
										<div class="row center-card">
											<div class="card">
												<div class="card-image">
													<img src="{{asset('frontend/img/post.jpg')}}" alt="">
												</div>
												<div class="card-content">
													<p>Vasilenka</p>
													<a href="#" class="truncate">I am a very simple card.</h5>
												</div>
												<div class="card-action">
													<a href="#">Read more on UCP</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								
								<div class="row">
									<div class="container discussions-card-usf">
										<div class="row center-card">
											<div class="card">
												<div class="card-image">
													<img src="{{asset('frontend/img/post.jpg')}}" alt="">
												</div>
												<div class="card-content">
													<p>Vasilenka</p>
													<a href="#" class="truncate">I am a very simple card.</h5>
												</div>
												<div class="card-action">
													<a href="#">Read more on UCP</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								
								<div class="row">
									<div class="container discussions-card-usf">
										<div class="row center-card">
											<div class="card">
												<div class="card-image">
													<img src="{{asset('frontend/img/post.jpg')}}" alt="">
												</div>
												<div class="card-content">
													<p>Vasilenka</p>
													<a href="#" class="truncate">I am a very simple card.</h5>
												</div>
												<div class="card-action">
													<a href="#">Read more on UCP</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								
								<div class="row">
									<div class="container discussions-card-usf">
										<div class="row center-card">
											<div class="card">
												<div class="card-image">
													<img src="{{asset('frontend/img/post.jpg')}}" alt="">
												</div>
												<div class="card-content">
													<p>Vasilenka</p>
													<a href="#" class="truncate">I am a very simple card.</h5>
												</div>
												<div class="card-action">
													<a href="#">Read more on UCP</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								
								<div class="row">
									<div class="container discussions-card-usf">
										<div class="row center-card">
											<div class="card">
												<div class="card-image">
													<img src="{{asset('frontend/img/post.jpg')}}" alt="">
												</div>
												<div class="card-content">
													<p>Vasilenka</p>
													<a href="#" class="truncate">I am a very simple card.</h5>
												</div>
												<div class="card-action">
													<a href="#">Read more on UCP</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
							</div>
							<a href="#" id="visit-ucp">Visit urban communities of practice (UCP)</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> --}}

	<section class="scrollspy" id="schedule-soon">
		<div class="container" id="schedule-wrapper">
			<div class="row">
				<div class="col s12 m12" id="header-schedule">
					<div id="wrapper-schedule-header">
						<div class="row">
							<div class="col s2 m2">
								<div class="card card-round">
									<div class="card-content card-round-content">
										<i class="material-icons">event_note</i>
									</div>
								</div>
							</div>
							<div class="col s10 m10">
								<p>
									schedule
								</p>
								<span>The forum will have different panel discussions, workshops, performances, and exhibiting organizations</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="scrollspy" id="sch"></div>
		</div>
	</section>
	<section class="scrollspy" id="schedule">
		<div class="container" id="wrapper-schedule">
			{{-- <div class="row">
				<div class="col m4">
					<img src="{{ asset('frontend/img/ic_schedule.svg') }}" alt="USF Speakers" class="ic">
				</div>
			</div> --}}
			<div class="row">
				<div class="col s12 m7" id="schedule-timeline">
					<div class="wrapper-schedule-timeline expand">
						<ul class="timeline">
							<li>
								<div class="timeline-block">
									<p class="timeline-date">07.30 – 09.00</p>
									<div class="timeline-content">
										<p>Registration</p>
									</div>
								</div>
							</li>
							<li>
								<div class="timeline-block">
									<p class="timeline-date">09.00 – 09.30</p>
									<div class="timeline-content">
										<p>Opening Remarks</p>
									</div>
								</div>
							</li>
							<li>
								<div class="timeline-block">
									<p class="timeline-date">09.30 – 10.30</p>
									<div class="timeline-content">
										<p>Plenary I Urban Social Forum 2016</p>
									</div>
								</div>
							</li>
							<li>
								<div class="timeline-block">
									<p class="timeline-date">10.30 -  12.00</p>
									<div class="timeline-content">
										<p>Parallel Session 1</p>
									</div>
								</div>
							</li>
							<li>
								<div class="timeline-block">
									<p class="timeline-date">12.00 – 13.00</p>
									<div class="timeline-content">
										<p>Lunch Break</p>
									</div>
								</div>
							</li>
							<li>
								<div class="timeline-block">
									<p class="timeline-date">13.00 – 14.30</p>
									<div class="timeline-content">
										<p>Parallel Session 2</p>
									</div>
								</div>
							</li>
							<li>
								<div class="timeline-block">
									<p class="timeline-date">14.30 – 16.00</p>
									<div class="timeline-content">
										<p>Parallel Session 3</p>
									</div>
								</div>
							</li>
							<li>
								<div class="timeline-block">
									<p class="timeline-date">16.00 – 16.15</p>
									<div class="timeline-content">
										<p>Break</p>
									</div>
								</div>
							</li>
							<li>
								<div class="timeline-block">
									<p class="timeline-date">16.15 – 17.30</p>
									<div class="timeline-content">
										<p>Plenary II Urban Social Forum 2016</p>
									</div>
								</div>
							</li>
							<li>
								<div class="timeline-block">
									<p class="timeline-date">17.30 – 18.30</p>
									<div class="timeline-content">
										<p>Break</p>
									</div>
								</div>
							</li>
							<li>
								<div class="timeline-block">
									<p class="timeline-date">18.30 – 21.00</p>
									<div class="timeline-content">
										<p>Art Performance</p>
									</div>
								</div>
							</li>
						</ul>
					</div>
					{{-- <div class="wrapper-btn-expand">
						<div class="timeline-child-content">
							<a class="waves-effect waves-teal btn-flat" id="btn-expand">show Full Schedule</a>
						</div>
					</div> --}}
				</div>
				<div class="col s12 m5 valign-wrapper" id="schedule-info">
					<div class="valign">
						<p>Saturday</p>
						<p>December 3<sup>rd</sup>, 2016</p>
						{{-- <p>All day long, awesome events awaits for you.</p> --}}
						<a href="http://bit.ly/bookletUSF2016" class="btn btn-usf" target="_blank">Download Informational Booklet</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="scrollspy" id="venue">
		{{-- <div class="container" id="wrapper-venue">
			<div class="row">
				<div class="col m8" id="venue-info">
					<p>UNTAG <br><span>Universitas Tujuh Belas Agustus</span></p>
					<p>Jalan Semolowaru, Menur Pumpungan, Sukolilo, Kota Surabaya<br>
					Jawa Timur, Indonesia</p>
					<p><a class="waves-effect waves-teal btn-flat" id="btn-expand">VIEW ON GOOGLE MAPS</a></p>
				</div>
				<div class="col m4" id="venue-logo">
					<img src="{{ asset('frontend/img/ic_venue.svg') }}" alt="USF Venue" class="ic">
				</div>
			</div>
		</div> --}}
		<div class="scrollspy" id="location">
			<div class="container" id="location-wrapper">
				<div class="row">
					<div class="col s12 m12" id="header-location">
						<div id="wrapper-location-header">
							<div class="row">
								<div class="col s2 m2">
									<div class="card card-round">
										<div class="card-content card-round-content">
											<i class="material-icons">place</i>
										</div>
									</div>
								</div>
								<div class="col s10 m10">
									<p>
										location
									</p>
									<span>The Forum will be taking place in a heritage school building located in the heart of Semarang city</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="scrollspy" id="loc"></div>
		<div class="card" id="info-loc">
			<div class="card-stacked">
				<div class="card-content">
					<p>sman 1 semarang <br> <span>(Smansa Semarang)</span></p>
					<p>Jl. Taman Menteri Supeno No.1
					<br>Mugassari, Semarang Selatan
					<br>Kota Semarang
					<br>Indonesia</p>
					<a href="https://www.google.co.id/maps/dir//Sman+1+Semarang,+Jl.+Pandanaran+2+No.2,+Mugassari,+Semarang+Sel.,+Kota+Semarang,+Jawa+Tengah+50249/@-6.9919337,110.4167142,17z/data=!4m16!1m7!3m6!1s0x2e708b5e84f673a3:0x95bc3bb5fa8469d9!2sSman+1+Semarang!3b1!8m2!3d-6.9919337!4d110.4189029!4m7!1m0!1m5!1m1!1s0x2e708b5e84f673a3:0x95bc3bb5fa8469d9!2m2!1d110.4189029!2d-6.9919337" class="btn btn-usf" target="_blank">GET DIRECTION</a>
				</div>
			</div>
		</div>
		<div id="map"></div>
	</section>

	<section class="scrollspy" id="archieve">
		<div class="container" id="archieve-wrapper">
			<div class="row">
				<div class="col s12 m12">
					<div class="card" id="card-archieve">
						<div class="card-content" id="card-archieve-content">
							<div class="wrapper-card-archieve">
								<div class="row">
									<div class="col s12 m12">
										<div id="wrapper-archieve-header">
											<div class="row">
												<div class="col s2 m2">
													<div class="card card-round">
														<div class="card-content card-round-content">
															<i class="material-icons">archive</i>
														</div>
													</div>
												</div>
												<div class="col s10 m10">
													<p>
														archive
													</p>
												</div>
											</div>
										</div>
									</div>
									<div class="scrollspy" id="ach"></div>
									<div class="col s12 m12">
										<div id="wrapper-archieve-choice">
											<ul>
												<li>
													<div class="grayscale">
														<div>
															<a href="http://bit.ly/usf_report" target="_blank">
																<figure>
																	<img src="{{asset('frontend/img/archive_report.png')}}" alt="USF Logo" id="usf-logo">
																	<span>
																		event report 2015
																	</span>
																</figure>
															</a>
														</div>
													</div>
												</li>
												<li>
													<div class="grayscale">
														<div>
															<a href="http://bit.ly/usf_photos" target="_blank">
																<figure>
																	<img src="{{asset('frontend/img/archive_foto.png')}}" alt="USF Logo" id="usf-logo">
																	<span>
																		Photo gallery
																	</span>
																</figure>
															</a>
														</div>
													</div>
												</li>
												<li>
													<div class="grayscale">
														<div>
															<a href="http://bit.ly/usf_video" target="_blank">
																<figure>
																	<img src="{{asset('frontend/img/archive_video.png')}}" alt="USF Logo" id="usf-logo">
																	<span>
																		Video
																	</span>
																</figure>
															</a>
														</div>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="scrollspy" id="org-part">
		<div class="container" id="org-part-wrapper">
			<div class="row">
				<div class="col s12 m12">
					<div class="wrapper-card-org-part">
						<div class="row">
							<div class="col s12 m12">
								<div id="wrapper-org-part-header">
									<div class="row">
										<div class="col s2 m2">
											<div class="card card-round">
												<div class="card-content card-round-content">
													<i class="material-icons">grade</i>
												</div>
											</div>
										</div>
										<div class="col s10 m10">
											<p>
												organizer &amp; partners
											</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col s12 m12">
								<div id="wrapper-org-part-choice">
									<div class="row">
										<ul>
											<li>
												<img src="{{asset('frontend/img/logo/1.png')}}" alt="" class="responsive-img materialboxed" data-caption="Kota Kita" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/2.png')}}" alt="" class="responsive-img materialboxed" data-caption="Kota Semarang" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/3.png')}}" alt="" class="responsive-img materialboxed" data-caption="Diponegoro University" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/4.png')}}" alt="" class="responsive-img materialboxed" data-caption="P5 Universitas Diponegoro" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/5.png')}}" alt="" class="responsive-img materialboxed" data-caption="IUCCE" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/6.png')}}" alt="" class="responsive-img materialboxed" data-caption="Hysteria" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/7.png')}}" alt="" class="responsive-img materialboxed" data-caption="Peka Kota" width="250">
											</li>
										{{-- </ul>
									</div>
									<div class="row">
										<ul> --}}
											<li>
												<img src="{{asset('frontend/img/logo/8.png')}}" alt="" class="responsive-img materialboxed" data-caption="Komunitas Sahabat Difabel" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/9.png')}}" alt="" class="responsive-img materialboxed" data-caption="ITDP" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/10.png')}}" alt="" class="responsive-img materialboxed" data-caption="Program Peduli" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/11.png')}}" alt="" class="responsive-img materialboxed" data-caption="ASB" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/12.png')}}" alt="" class="responsive-img materialboxed" data-caption="Mercy Corps Indonesia" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/13.png')}}" alt="" class="responsive-img materialboxed" data-caption="ACCRN" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/14.png')}}" alt="" class="responsive-img materialboxed" data-caption="IYMM" width="250">
											</li>
										{{-- </ul>
									</div>
									<div class="row">
										<ul> --}}
											<li>
												<img src="{{asset('frontend/img/logo/15.png')}}" alt="" class="responsive-img materialboxed" data-caption="ARI National University of Singapore" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/16.png')}}" alt="" class="responsive-img materialboxed" data-caption="UNESCO Jakarta" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/17.png')}}" alt="" class="responsive-img materialboxed" data-caption="UBAYA" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/18.png')}}" alt="" class="responsive-img materialboxed" data-caption="Charter for Compassion" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/19.png')}}" alt="" class="responsive-img materialboxed" data-caption="Disaster Goverment Asia" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/20.png')}}" alt="" class="responsive-img materialboxed" data-caption="UrbanLab" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/21.png')}}" alt="" class="responsive-img materialboxed" data-caption="Generation Foundation" width="250">
											</li>
										{{-- </ul>
									</div>
									<div class="row">
										<ul> --}}
											<li>
												<img src="{{asset('frontend/img/logo/22.png')}}" alt="" class="responsive-img materialboxed" data-caption="" width="250" data-caption="Kampungnesia" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/23.png')}}" alt="" class="responsive-img materialboxed" data-caption="Subcylist" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/24.png')}}" alt="" class="responsive-img materialboxed" data-caption="Tanah Indie" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/25.png')}}" alt="" class="responsive-img materialboxed" data-caption="Peta Bencana" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/26.png')}}" alt="" class="responsive-img materialboxed" data-caption="GPR2C" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/27.png')}}" alt="" class="responsive-img materialboxed" data-caption="Subcyclist" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/28.png')}}" alt="" class="responsive-img materialboxed" data-caption="Tanah Indie" width="250">
											</li>
										{{-- </ul>
									</div>
									<div class="row">
										<ul> --}}
											<li>
												<img src="{{asset('frontend/img/logo/29.png')}}" alt="" class="responsive-img materialboxed" data-caption="Indonesian Heritage Inventory"" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/30.png')}}" alt="" class="responsive-img materialboxed" data-caption="Ternate Heritage Society"" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/31.png')}}" alt="" class="responsive-img materialboxed" data-caption="Rumah Kartini Jepara" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/32.png')}}" alt="" class="responsive-img materialboxed" data-caption="Warga Berdaya - Yogyakarta" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/33.png')}}" alt="" class="responsive-img materialboxed" data-caption="Lasem Heritage Society" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/34.png')}}" alt="" class="responsive-img materialboxed" data-caption="Kampoeng Bogor" width="250">
											</li>
											<li>
												<img src="{{asset('frontend/img/logo/35.png')}}" alt="" class="responsive-img materialboxed" data-caption="Kota Toea Magelang" width="250">
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="scrollspy" id="contact-soon">
		<div class="container" id="contact-soon-wrapper">
			<div class="row">
				<div class="col s12 m12">
					<div class="card scrollspy" id="card-contact-soon">
						<div class="card-content" id="card-contact-soon-content">
							<div class="wrapper-card-contact-soon">
								<div class="row">
									<div class="col s12 m12">
										<div id="wrapper-contact-soon-header">
											<div class="row">
												<div class="col s2 m2">
													<div class="card card-round">
														<div class="card-content card-round-content">
															<i class="material-icons">call</i>
														</div>
													</div>
												</div>
												<div class="col s10 m10">
													<p>
														Contact Us
													</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								 <div class="scrollspy" id="cu"></div>
								<div class="row">
									<div class="col s12 m12" id="email">
										<p>Email</p>
										<p>usf.indonesia@gmail.com</p>
									</div>
								</div>
								<div class="row">
									<div class="col s12 m12" id="cp">
										<p id="head">Contact Person</p>
										<div class="row">
											<div class="col s12 m3">
												<p>Nisa Thamrin</p>
												<p>+62 856 4197 1371</p>
												<p>icha@kotakita.org</p>
											</div>
											<div class="col s12 m3">
												<p>Paulista Surjadi</p>
												<p>+62 815 1004 6907</p>
												<p>paulista@kotakita.org</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col s12 m12">
					<ul id="social-icons">
						<li>
							<a href="https://www.facebook.com/urban.social.forum" id="fb" target="_blank">
								<img src="{{asset('frontend/img/facebook.svg')}}" alt="phone" class="ic">
							</a>
						</li>
						<li>
							<a href="https://www.twitter.com/urban_forum" id="tw" target="_blank">
								<img src="{{asset('frontend/img/twitter.svg')}}" alt="phone" class="ic">
							</a>
						</li>
						<li>
							<a href="https://www.instagram.com/urbansocialforum" id="insta" target="_blank">
								<img src="{{asset('frontend/img/igs.png')}}" alt="phone">
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<section class="valign-wrapper" id="footer-usf">
		<p class="center-align valign">Copyright &copy; <span>Urban Social Forum</span> 2016</p>
	</section>

{{-- 	<section class="scrollspy" id="contact">
		<div id="bg-phone">
			<img src="{{asset('frontend/img/img_phone.svg')}}" alt="phone" class="ic">
		</div>
		<div class="container" id="wrapper-contact">
			<div class="row">
				<div class="col m12" id="contact-logo">
					<img src="{{ asset('frontend/img/ic_contact.svg') }}" alt="USF Speakers" class="ic">
				</div>
			</div>
			<div class="row">
				<div class="col m6" id="contact-form">
					<div class="card">
						<div class="card-content">
							<div class="row">
								<form action="#" method="post">
									<div class="col m12" id="header-form">
										<p>Feel free to ask your question</p>
									</div>
									<div class="wrapper-form">
										<div class="col m12">
											<input name="name" type="text" class="validate" placeholder="Your name here">
										</div>
										<div class="col m12">
											<input type="email" name="email" class="validate" placeholder="Your email here">
										</div>
										<div class="col m12">
											<input type="text" name="text" class="validate" placeholder="Your question here">
										</div>
										<div class="col m12" id="btn-ask">
											<a class="waves-effect waves-teal btn-flat" id="btn-expand">ASK YOUR QUESTION</a>
											<i class="material-icons">send</i>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col m6" id="contact-us">
					<div id="inner-contact-us">
						<p>Or contact us on</p>
						<p>EMAIL</p>
						<p>usf.indonesia@gmail.com</p>
						<p>PHONE</p>
						<p>+62 8151 0046 907 <span>(Paulista)</span></p>
						<p>+62 8564 1971 371 <span>(Nisa)</span></p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="scrollspy" id="partners">
		<div class="container" id="wrapper-partner">
			<div class="row">
				<div class="col m12" id="partner-logo">
					<img src="{{ asset('frontend/img/ic_partner.svg') }}" alt="USF Speakers" class="ic">
				</div>
			</div>
			<div class="row" id="partner-img">
				<ul>
					<li>
						<img src="{{asset('frontend/img/logo/')}}" alt="" class="responsive-img">
					</li>
					<li>
						<img src="{{asset('frontend/img/logo/')}}" alt="" class="responsive-img">
					</li>
					<li>
						<img src="{{asset('frontend/img/logo/')}}" alt="" class="responsive-img">
					</li>
					<li>
						<img src="{{asset('frontend/img/logo/')}}" alt="" class="responsive-img">
					</li>
					<li>
						<img src="{{asset('frontend/img/logo/')}}" alt="" class="responsive-img">
					</li>
				</ul>
			</div>
			<div class="row" id="partner-img-2">
				<ul>
					<li>
						<img src="{{asset('frontend/img/logo/')}}" alt="" class="responsive-img">
					</li>
					<li>
						<img src="{{asset('frontend/img/logo/')}}" alt="" class="responsive-img">
					</li>
					<li>
						<img src="{{asset('frontend/img/logo/')}}" alt="" class="responsive-img">
					</li>
					<li>
						<img src="{{asset('frontend/img/logo/')}}" alt="" class="responsive-img">
					</li>
				</ul>
			</div>
			<p>Copyright &copy; <span>Urban Social Forum</span> 2016</p>
		</div>
	</section> --}}
@endsection

@section('scripts')
@parent
<script>
	$('.button-collapse').sideNav();
	function initMap() {
		var myLatLing = {lat: -6.9919811, lng: 110.4188267};
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 18,
			scrollwheel: false,
			center: myLatLing
		});

		var image = '../../frontend/img/pointer.png';
		var beachMarker = new google.maps.Marker({
			position: myLatLing,
			map: map,
			icon: image
		});
	}
	</script>

	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCEaWVBIZGlS2PamvpJIxF1leIopmPfeU&callback=initMap">
	</script>
@endsection