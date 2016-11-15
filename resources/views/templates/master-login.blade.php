@extends('templates.master')
@section('navbar')
@endsection

@section('scripts')
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
	<script type="text/javascript" src="{{asset('frontend/js/materialize.min.js')}}"></script>
	<!-- <script type="text/javascript" src="{{ asset('frontend/js/bootstrap.min.js') }}"></script> -->
	<script type="text/javascript" src="{{asset('frontend/js/main.js')}}"></script>
	<script>
		$(document).ready(function(){
		    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
		    $('.modal-trigger').leanModal();
		});
	</script>
	{{-- script for toast --}}
	@include('templates.messages.toast_scripts')
@show
