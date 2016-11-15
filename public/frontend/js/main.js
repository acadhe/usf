$(document).ready(function() {
	$('select').material_select();
	$('.modal-trigger').leanModal();
	$('.scrollspy').scrollSpy();
	$('.button-collapse').sideNav();
	$('form').dirtyForms();
	$('.dropdown-button').dropdown({
			inDuration: 300,
			outDuration: 225,
			constrain_width: false, // Does not change width of dropdown to that of the activator
			alignment: 'left' // Displays dropdown with edge aligned to the left of button
		}
	);
	$('.dropdown-nav').dropdown({
			inDuration: 300,
			outDuration: 225,
			constrain_width: false, // Does not change width of dropdown to that of the activator
			alignment: 'left' // Displays dropdown with edge aligned to the left of button
		}
	);
	$('.dropdown-publish').dropdown({
			inDuration: 300,
			outDuration: 225,
			constrain_width: false, // Does not change width of dropdown to that of the activator
			alignment: 'left' // Displays dropdown with edge aligned to the left of button
		}
	);
	$('.carousel-panelis').slick({
		dots: false,
		// infinite: false,
		infinite: true,
		autoplay: true,
		autoplaySpeed: 3000,
		speed: 300,
		slidesToShow: 9,
		slidesToScroll: 9,
		responsive: [{
			breakpoint: 1024,
			settings: {
				slidesToShow: 6,
				slidesToScroll: 6,
				infinite: true,
				dots: true
			}
		}, {
			breakpoint: 768,
			settings: {
				slidesToShow: 6,
				slidesToScroll: 6
			}
		}, {
			breakpoint: 600,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 3
			}
		}, {
			breakpoint: 480,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 3
			}
		}]
	});
	$('.carousel-speakers').slick({
		dots: false,
		infinite: false,
		speed: 300,
		slidesToShow: 4,
		slidesToScroll: 4,
		responsive: [{
			breakpoint: 1024,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 3,
				infinite: true,
				dots: true
			}
		}, {
			breakpoint: 600,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			}
		}, {
			breakpoint: 480,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}]
	});
	$('.carousel-discussions').slick({
		dots: false,
		infinite: false,
		speed: 300,
		slidesToShow: 3,
		slidesToScroll: 3,
		responsive: [{
			breakpoint: 1024,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 3,
				infinite: true,
				dots: true
			}
		}, {
			breakpoint: 600,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			}
		}, {
			breakpoint: 480,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}]
	});

	function validateForm() {
		var radios = document.getElementsByName("myForm");
		var formValid = false;

		var i = 0;
		while (!formValid && i < radios.length) {
			if (radios[i].checked) formValid = true;
			i++;
		}

		if (!formValid) alert("Must check some option!");
		return formValid;
	}

	// FUNGSI KETIKA USER GA MASUKIN TEKS APAPUN I TEXT AREA MAKA DIA AKAN AUTO DISABLE
	// SI BUTTON POST NYA --- SORRY CAPS, UDAH TANGGUNG DARI AWAL WEKEKEKEKE
	// $('input[type="submit"], button[type="submit"]').prop('disabled', true);
	// 	$('input[type="text"], input[type="email"], input[type="password"], textarea').keyup(function() {
	// 	if($(this).val() != '') {
	// 		$('input[type="submit"], button[type="submit"]').prop('disabled', false);
	// 	}
	// 	else {
	// 		$('input[type="submit"], button[type="submit"]').prop('disabled', true);
	// 	}
	// });

	// expand jadwal di usf pdf
	$("#btn-expand").click(function(e) {
		if (!$(".wrapper-schedule-timeline").hasClass("expand")) {
			$(".wrapper-schedule-timeline").addClass("expand", 1000, "easeInOutCubic");
			$("#btn-expand").html("See Less Schedule");
		} else {
			$(".wrapper-schedule-timeline").removeClass("expand", 1000, "easeInOutCubic");
			$("#btn-expand").html("Show Full Schedule");
		}
	});
	// countdown timer di usf pdf
	/* --------------------------
	 * GLOBAL VARS
	 * -------------------------- */
	// The date you want to count down to
	var targetDate = new Date("2016/12/04 09:00:00");

	// Other date related variables
	var days;
	var hrs;
	var min;
	var sec;

	/* --------------------------
	 * ON DOCUMENT LOAD
	 * -------------------------- */
	$(function() {
		// Calculate time until launch date
		timeToLaunch();
		// Transition the current countdown from 0 
		numberTransition('#days .number p', days, 1000, 'easeOutQuad');
		numberTransition('#hours .number p', hrs, 1000, 'easeOutQuad');
		numberTransition('#minutes .number p', min, 1000, 'easeOutQuad');
		numberTransition('#seconds .number p', sec, 1000, 'easeOutQuad');
		// Begin Countdown
		setTimeout(countDownTimer, 1001);
	});

	// HIDE ON SCROLL
	;(function(document, window, index) {
		'use strict';

		var elSelector = '#usf-navbar',
		// var elSelector = '.nav-master',
			element = document.querySelector(elSelector);

		if (!element) return true;

		var elHeight = 0,
			elTop = 0,
			dHeight = 0,
			wHeight = 0,
			wScrollCurrent = 0,
			wScrollBefore = 0,
			wScrollDiff = 0;

		window.addEventListener('scroll', function() {
			elHeight = element.offsetHeight;
			dHeight = document.body.offsetHeight;
			wHeight = window.innerHeight;
			wScrollCurrent = window.pageYOffset;
			wScrollDiff = wScrollBefore - wScrollCurrent;
			elTop = parseInt(window.getComputedStyle(element).getPropertyValue('top')) + wScrollDiff;

			if (wScrollCurrent <= 0)
				element.style.top = '0px';

			else if (wScrollDiff > 0)
				element.style.top = (elTop > 0 ? 0 : elTop) + 'px';

			else if (wScrollDiff < 0) {
				if (wScrollCurrent + wHeight >= dHeight - elHeight)
					element.style.top = ((elTop = wScrollCurrent + wHeight - dHeight) < 0 ? elTop : 0) + 'px';

				else
					element.style.top = (Math.abs(elTop) > elHeight ? -elHeight : elTop) + 'px';
			}

			wScrollBefore = wScrollCurrent;
		});

	}(document, window, 0));
	// HIDE ON SCROLL

	/* --------------------------
	 * FIGURE OUT THE AMOUNT OF 
	   TIME LEFT BEFORE LAUNCH
	 * -------------------------- */
	function timeToLaunch() {
		// Get the current date
		var currentDate = new Date();

		// Find the difference between dates
		var diff = (currentDate - targetDate) / 1000;
		var diff = Math.abs(Math.floor(diff));

		// Check number of days until target
		days = Math.floor(diff / (24 * 60 * 60));
		sec = diff - days * 24 * 60 * 60;

		// Check number of hours until target
		hrs = Math.floor(sec / (60 * 60));
		sec = sec - hrs * 60 * 60;

		// Check number of minutes until target
		min = Math.floor(sec / (60));
		sec = sec - min * 60;
	}

	/* --------------------------
	 * DISPLAY THE CURRENT 
	   COUNT TO LAUNCH
	 * -------------------------- */
	function countDownTimer() {

		// Figure out the time to launch
		timeToLaunch();

		// Write to countdown component
		$("#days .number p").text(days);
		$("#hours .number p").text(hrs);
		$("#minutes .number p").text(min);
		$("#seconds .number p").text(sec);

		// Repeat the check every second
		setTimeout(countDownTimer, 1000);
	}

	/* --------------------------
	 * TRANSITION NUMBERS FROM 0
	   TO CURRENT TIME UNTIL LAUNCH
	 * -------------------------- */
	function numberTransition(id, endPoint, transitionDuration, transitionEase) {
		// Transition numbers from 0 to the final number
		$({ numberCount: $(id).text() }).animate({ numberCount: endPoint }, {
			duration: transitionDuration,
			easing: transitionEase,
			step: function() {
				$(id).text(Math.floor(this.numberCount));
			},
			complete: function() {
				$(id).text(this.numberCount);
			}
		});
	};
});

/*
 * Replace all SVG images with inline SVG
 */
jQuery('img.svg-black').each(function() {
	var $img = jQuery(this);
	var imgID = $img.attr('id');
	var imgClass = $img.attr('class');
	var imgURL = $img.attr('src');

	jQuery.get(imgURL, function(data) {
		// Get the SVG tag, ignore the rest
		var $svg = jQuery(data).find('svg');

		// Add replaced image's ID to the new SVG
		if (typeof imgID !== 'undefined') {
			$svg = $svg.attr('id', imgID);
		}
		// Add replaced image's classes to the new SVG
		if (typeof imgClass !== 'undefined') {
			$svg = $svg.attr('class', imgClass + ' replaced-svg');
		}

		// Remove any invalid XML tags as per http://validator.w3.org
		$svg = $svg.removeAttr('xmlns:a');

		// Replace image with new SVG
		$img.replaceWith($svg);

	}, 'xml');
});

jQuery('img.ic').each(function() {
	var $img = jQuery(this);
	var imgID = $img.attr('id');
	var imgClass = $img.attr('class');
	var imgURL = $img.attr('src');

	jQuery.get(imgURL, function(data) {
		// Get the SVG tag, ignore the rest
		var $svg = jQuery(data).find('svg');

		// Add replaced image's ID to the new SVG
		if (typeof imgID !== 'undefined') {
			$svg = $svg.attr('id', imgID);
		}
		// Add replaced image's classes to the new SVG
		if (typeof imgClass !== 'undefined') {
			$svg = $svg.attr('class', imgClass + ' replaced-svg');
		}

		// Remove any invalid XML tags as per http://validator.w3.org
		$svg = $svg.removeAttr('xmlns:a');

		// Replace image with new SVG
		$img.replaceWith($svg);

	}, 'xml');

});
var mark = function() {

	// Read the keyword
	var keyword = $("input[name='keyword']").val();

	// Determine selected options
	var options = {};
	$("input[name='opt[]']").each(function() {
	  options[$(this).val()] = $(this).is(":checked");
	});

	// Remove previous marked elements and mark
	// the new keyword inside the context
	$(".context").unmark().mark(keyword, options);
  };
$("input[name='keyword']").on("input", mark);

$('.cari-box input').on('keypress', function(e) {
	return e.which !== 13;
});