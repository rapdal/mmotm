<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Divine Souls - any.TV</title>
	
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
	<link rel="stylesheet" href="../css/bootstrap.min.css" />

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../js/general.js?ver=1.02" type="text/javascript"></script>

	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Gudea" />
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Russo+One" />
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Univers" />
    
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	
	<link rel="stylesheet" href="../css/magnific-popup.css"> 
	<script src="../js/jquery.magnific-popup.js"></script>
	
	<script>
		$(function() {
			$( "#tabs" ).tabs();
			$('#tabs ul li a').click(function(){
				$('#tabs ul li a').removeClass('tab-selected');
				$(this).addClass('tab-selected	');
			});
			
			$( "#tabs-s" ).tabs();
			$('#tabs-s ul li a').click(function(){
				$('#tabs-s ul li a').removeClass('tab-selected');
				$(this).addClass('tab-selected	');
			});
			
			$('.popup-gallery').magnificPopup({
				delegate: 'a',
				type: 'image',
				tLoading: 'Loading image #%curr%...',
				mainClass: 'mfp-img-mobile',
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					preload: [0,1] // Will preload 0 - before current, and 1 after the current image
				},
				image: {
					tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
					titleSrc: function(item) {
						return item.el.attr('title') + '<small>divinesouls.mmo.tm</small>';
					}
				}
			});
			
			$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
				disableOn: 700,
				type: 'iframe',
				mainClass: 'mfp-fade',
				removalDelay: 160,
				preloader: false,

				fixedContentPos: false
			});
			
		});
		
		function scrollView(elemID){
			var elem = document.getElementById(elemID);
			elem.scrollIntoView(true);
		}
	</script>
	
</head>

<body>