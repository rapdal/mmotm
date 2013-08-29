<?php
session_start();

if(!isset($_SESSION['error'])){
	//This code runs if the form has been submitted
	if (isset($_POST['username_s']) && isset($_POST['pass_s'])) { 
		
		 // Connects to your Database 
		mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); 
		mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); 

		// checks if the username is in use
		$usercheck = $_POST['username_s'];
		$check = mysql_query("SELECT email FROM Users WHERE email = '$usercheck'") or die(mysql_error());
		$check2 = mysql_num_rows($check);

		 //if the name exists it gives an error
		if ($check2 != 0) {
			$_SESSION['error'] = "Sorry, the email is already in use.";
		}

		// this makes sure both passwords entered match
		if ($_POST['pass_s'] != $_POST['pass2_s']) {
			$_SESSION['error'] = "Password does not match.";
		}

		// create activation hash
		$hash = md5( rand(0,1000) );

		// now we insert it into the database
		$anytv_transaction_id = '';
		if(isset($_SESSION['anytv_transaction_id']))
		{
			$anytv_transaction_id = $_SESSION['anytv_transaction_id'];
		}
		
		
		if(!isset($_SESSION['error'])){
			$pass_s = md5($_POST['pass_s']);
			
			$insert = "INSERT INTO Users (email, password, fullName, betaExperience, dsExperience, DOB, verifyHash, keyAssigned, mmoTag, transaction_id) 
			VALUES ('".$_POST['username_s']."', '$pass_s', '".$_POST['fullName_s']."', '".$_POST['betaExperience_s']."', '".$_POST['dsExperience_s']."', '".$_POST['DOB_s']."', '$hash', '', '', '$anytv_transaction_id')";
			$add_member = mysql_query($insert) or die(mysql_error());;
			
			
			// postback to dashboard for conversion
			if($anytv_transaction_id)
			{
				$postback_url = "http://play.any.tv/aff_lsr?offer_id=296&transaction_id=$anytv_transaction_id";
				$postback_url_result = file_get_contents( $postback_url );  
			  unset($postback_url_result); // use for testing
			  
			  if(isset($_SESSION['anytv_transaction_id']))
			  {
			  	unset($_SESSION['anytv_transaction_id']);
			  }
			}
			
			if(!$add_member)
			{
				$_SESSION['error'] = "An error occurred. Please try again.";
			}else{
				header("Location: http://mmo.tm/divinesouls/submit-beta-signup.php");
			}
			
			
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://w3.org/1999/xhtml">
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