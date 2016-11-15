<?php
	use App\Models\Article;
?>
@extends('templates.master')
@section('content')
	<section id="share" class="valign-wrapper">
		<div class="container valign" id="wrapper-login">
			<div class="row">
				<div class="col s12 m12 l12">
					<div class="row" id="wrapper-share">
						@if (Session::has('error_message'))
							<p>{{Session::get('error_message')}}</p>
						@endif
						<div class="col s12 m12 l12">
							<h4>Share Your Topic</h4>
							<p>Get more audience to your topic by sharing <br> topic to your social media account.</p>
						</div>
						<div class="col s12 m12 l12">
							<ul id="sosmed">
								<li>
									<a href="https://www.facebook.com/sharer/sharer.php?u={{$share_link}}" class="waves-effect waves-light btn" id="fb"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
								</li>
								<li>
									<a href="https://twitter.com/home?status={{$share_link}}" class="waves-effect waves-light btn" id="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
								</li>
								<li>
									<a href="https://plus.google.com/share?url={{$share_link}}" class="waves-effect waves-light btn" id="gmail"><i class="fa fa-google" aria-hidden="true"></i></a>
								</li>
							</ul>
						</div>
						<div class="col s12 m12 l12">
							<p id="below-share">or copy link in the box below to share your topic</p>
							<div class="valign-wrapper" id="wrapper-share-link">
								{{-- <div class="valign"> --}}
									<input id="select-this" type="share" value="{{$share_link}}">
									<button id="clickMe" class="btn-share-link" data-clipboard-target="#select-this">COPY</button>
								{{-- </div> --}}
							</div>
							<a href="{{$share_link}}" id="bt-sh">GO TO YOUR ARTICLE</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@section('scripts')
@parent
	<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>
	<script>
		$(function() {

		  var clipboard = new Clipboard('.btn-share-link');
		  clipboard.on('success', function(e) {
		    console.info('Action:', e.action);
		    console.info('Text:', e.text);
		    console.info('Trigger:', e.trigger);
		    e.clearSelection();
		  });

		  $("span#status").css("opacity", 0);

		  $("#clickMe").click(function() {
		    $(this).html("Copied!");
		    $("span#status").css("opacity", 1);
		    setTimeout(function() {
		      $("#clickMe").html("COPY");
		      $("#clickMe").prop('disabled', false);
		      $("span#status").css("opacity", 0);
		    }, 1750);
		  });
		  return false;
		});
	</script>
@endsection