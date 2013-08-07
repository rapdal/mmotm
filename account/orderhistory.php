<?php
session_start();

if(!isset($_SESSION['userORM'])){
	header("Location: http://localhost/mmo.tm/divinesouls");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<style> 
	/* Start of "Micro clearfix" */
	
	.cf { zoom: 1; }
	.cf:before,
	.cf:after { content: ""; display: table; }
	.cf:after { clear: both; }
	
	/* End of "Micro clearfix" */

	body { width: 100%; margin: 0 auto;}
	</style>

	<title>Management</title>

	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />

	<link rel="stylesheet" type="text/css" href="../css/styles.css">
	<link rel="stylesheet" href="../css/bootstrap.min.css" />

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../js/paypal-button.min.js" type="text/javascript"></script>
	<script src="../js/general.js?ver=1.02" type="text/javascript"></script>

	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Gudea" />
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Russo+One" />
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Univers" />
	
</head>

<!-- Account Verification View -->
<?php if($_GET['view'] == 2) { ?>
<body>
	<div class="background">
		<img class="background" src="images/MMO_TM_Logo.png" width="100%"  alt="mmo.TM" />
	</div>

	<?php			  
	if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){  
		// Verify data  
		$email = $_GET['email']; // Set email variable  
		$hash = $_GET['hash']; // Set hash variable  

		$search = mysql_query("SELECT email, verifyHash, verifyActive FROM Users WHERE email='".$email."' AND verifyHash='".$hash."' AND verifyActive='0'") or die(mysql_error());   
		$match  = mysql_num_rows($search);  

		if($match > 0){  
			// We have a match, activate the account  
			mysql_query("UPDATE Users SET verifyActive='1' WHERE email='".$email."' AND verifyHash='".$hash."' AND verifyActive='0'") or die(mysql_error());  
			echo '<div id="intro"><h1>Your account has been activated <br /><span>And is ready for use</span></h1></div>';  
		}else{  
			// No match -> invalid url or account has already been activated.  
			echo '<div id="intro"><h1>Verified Already? <br /><span>The url is either invalid or you already have activated your account</span></h1></div>';  
		}  

	}else{  
		// Invalid approach  
		echo '<div id="intro" style="color: #000;"><h1>Invalid Link<br /><span>Please use the link that has been sent to your email</span></h1></div>';  
	} 
	?>

	<div class="two-col self-clear">
		<div class="col-1">
			<div class="boxleft-top"></div>
			<div class="boxleft-mid">
				<a href="http://www.mmo.tm/divinesouls" alt="Divine Souls Portal"><span class="gradient">Continue to Divine Souls</span></a>
			</div>
			<div class="boxleft-bottom"></div>
		</div>
		<div class="col-2">
			<div class="boxright-top"></div>
			<div class="boxright-mid" style="float: right;">
				<span class="gradient-text-style">mmo.TM</span>
			</div>
			<div class="boxright-bottom"></div>
		</div>
	</div>
</body>
<?php } ?>

<!-- Account Reset View -->
<?php if($_GET['view'] == 3) { 
	$resetState = 1; 
	$verificationCode = ""; 
	?>
	<body>
		<div class="body03">
			<div id="container03">
				<div id="header03" style="height: 45px;">
					<div id="header03-wrap">
						<?php include("../includes/_menu.php"); ?>
					</div>
				</div><!--end header-->

				<div id="logo03">
					<h1>Logo</h1>
				</div><!--end logo-->

				<?php
				if(isset($_POST['email'])){
					$email = $_POST['email'];

					$username = $_SESSION['userORM'];

				mysql_connect("localhost", "root", "") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
				mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database. 
			}

			if (isset($_POST['startAccountReset'])) {

				$search = mysql_query("SELECT email, password FROM Users WHERE email='".$email."'") or die(mysql_error());   
				$match  = mysql_num_rows($search); 

				if($match > 0) {

					if ($resetState == 1){

						$resetState = 2;
						$verificationCode = md5( rand(0,1000) );
						
						$message = ' 

						We have recieved your password reset request.

						The reset process has been started. Please paste the verification code below into your browser to finalize your request.

						------------------------ 
						Verification Code: '.$verificationCode.'
						------------------------ 

						If this email is in error and you have not inititated this request, please contact Account Support immediately for assistance.

						Have a great day!

						'; // Our message above including the link  
						$headers = 'From:noreply@mmo.tm' . "\r\n"; // Set from headers  
						$to = $email; // Send email to our user  
						$subject = 'mmoTM | Account Reset'; // Give the email a subject   

						mail($to, $subject, $message, $headers); // Send our email

						echo "
						<div id='resetlabel'>
						<p id='acc03'>Account Reset Started</p>
						<p id='acc2'>Check your email for verification code</p>
						</div>
						<div id='divider'>
						<h1>Divider</h1>
						</div>
						<!--end divider-->
						";

						?>

						<div id="input02">

							<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
								<input type="text" name="code" id="pass" placeholder="Verification Code" />
								<?php echo '<input type="text" name="storedCode"  style="visibility: hidden" value="' . $verificationCode . '">'; ?>
								<?php echo '<input type="text" name="email"  style="visibility: hidden" value="' . $email . '">'; ?>
								<button type="submit" name="verifyCode" id="submit3"></button>
							</form>

						</div><!--end input-->
						<?php

					}


				}else{
					$resetState=0;
					echo "<div id='resetlabel'><p id='acc03'>Account Not Found</p><p id='acc2'>Please go back and try again</p></div><div id='divider'><h1>Divider</h1></div><!--end divider-->";
				}

			}

			if(isset($_POST['verifyCode'])){

				$resetState = 3;

				if($_POST['storedCode'] == $_POST['code']) {
					echo "<div id='resetlabel'><p id='acc03'>Reset Request Verified</p><p id='acc2'>Please choose a strong password</p></div><div id='divider'><h1>Divider</h1></div><!--end divider-->";
					?>

					<div id="input02">

						<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
							<input type="password" id="passe" name="pass1" placeholder="New Password" />
							<input type="password" id="passv" name="pass2" placeholder="Verify Password" />
							<?php echo '<input type="text" name="email"  style="visibility: hidden" value="' . $email . '">'; ?>
							<button type="submit" name="submitNewPassword" id="submit2"></button>
							</form
							>
						</div><!--end input-->
						<?php 
					}
					if($_POST['storedCode'] != $_POST['code']){
						echo "<div id='resetlabel'><p id='acc03'>Reset Aborted</p><p id='acc2'>Verification codes do not match</p></div><div id='divider'><h1>Divider</h1></div><!--end divider-->";
					}
				}

				if(isset($_POST['submitNewPassword'])){

					$resetState = 4;

					$email = $_POST['email'];

					if($_POST['pass1'] == $_POST['pass2']) {
						echo "<div id='resetlabel'><p id='acc03'>Reset Request Finished</p><p id='acc2'>Keep your account safe</p></div><div id='divider'><h1>Divider</h1></div><!--end divider-->";
						$_POST['pass1'] = md5($_POST['pass1']);
						if (!get_magic_quotes_gpc()) {
							$_POST['pass1'] = addslashes($_POST['pass1']);
							$pass = $_POST['pass1'];
						}

						mysql_query("UPDATE Users SET password='$pass' WHERE email='$email'");
						?>

						<?php 
					}
					else{
						echo "<div id='resetlabel'><p id='acc03'>Go Back</p><p id='acc2'>Passwords do not match</p></div><div id='divider'><h1>Divider</h1></div><!--end divider-->";
					}

				}



				?>

				<?php if($resetState == 1) { //include('includes/_acctreset.php'); ?><?php } ?>
				<?php if($resetState == 1) { ?>

				<div id="resetlabel">
					<p id="acc03">PASSWORD RESET</p>
					<p id="acc2">please provide the information below</p>
				</div><!--end resetlabel-->
				
				<div id="divider">
					<h1>Divider</h1>
				</div><!--end divider-->

				<div id="input02">
					<form class="form-inline" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
						<input type="email" class="input-large" name="email" id="pass" placeholder="Email" />
						<button type="submit" name="startAccountReset" id="submit01"></button>
					</form>
				</div><!--end input-->

				<div id="continue03">
					<p id="cont03">continue to</p>
					<a href="http://www.mmo.tm/divinesouls" title="Divine Souls" id="dslogo">Divine Souls</a>
				</div><!--end continue-->

				<?php } ?>

				<?php if($resetState == 4) { ?>

				<div id="continue03">
					<p id="cont03">continue to</p>
					<a href="http://www.mmo.tm/divinesouls" title="Divine Souls" id="dslogo">Divine Souls</a>
				</div><!--end continue-->

				<?php } ?>

				<div id="anytv">
					part of the <a href="http://www.any.tv" title="any.TV" id="anytvlogo">any.TV</a> family
				</div><!--end anytv-->

				<div id="footer">
					Copyright &copy; 2013 any.TV. All Rights Reserved.
				</div><!--end footer-->

			</div><!--end container-->
		</div>
		<body>
			<?php } ?>


			<!-- Game Management View -->
			<?php if($_GET['view'] == 4) { 	?>
			<body>
				<div class = "body-mgmt">
					<div id="vessel" style="height: 1072px;">
						<?php include("../includes/_menu.php"); ?>
						<?php
						if(isset($_SESSION['userORM'])){

							$username = $_SESSION['userORM'];

			mysql_connect("localhost", "root", "") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
			mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database. 

			$result = mysql_query("SELECT * FROM Users WHERE email = '$username'") or die(mysql_error());

			while($row = mysql_fetch_array($result))
			{
				$email = $row['email'];
				$fullName = $row['fullName'];
				$mmoTag = $row['mmoTag'];
				$country = $row['country'];
				$mmoPoints = $row['mmoPointBalance'];
				$divineSoulsActive = $row['keyActive'];
				$mmoPointBalance = $row['mmoPointBalance'];
			}
		}
		?>
		<div id="seek" >
			<span id="scout1" >
				<form action="http://www.mmo.tm/account/account.php?view=1" method="#" >
					<input id="submitmgmtsearch" type="text" placeholder="Search" id="pass" required/>
					<input id="submitmgmt2" type="submit" value="" name="submit" />
				</form>
			</span>
		</div>

		<div class="content-wrap" style="margin-top: 130px;">
			<div class="content">
				
				<nav>
					<div class="nav_2"><img src="images/my-account-icon.png"/></div>

					<div class="nav_1" style="width: 95px;"><a style="margin-right: 50px;" href="/mmo.tm/account/account.php?view=4">Summary</a></div>
					<div id="nav_1" class="btn-group dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">

							<span class="userInfoHeader">Settings</span>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li><a href="/mmo.tm/account/management/settings/account-reset.php">Account Reset</a></li>
							<li><a href="/mmo.tm/account/management/settings/password-reset.php">Password Reset</a></li>
						</ul>
					</div>
					<div id="nav_1" class="btn-group dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">

							<span class="userInfoHeader">Games & Codes</span>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li><a href="/mmo.tm/account/addgamekey.php?view=4">Add a game key</a></li>
							<li><a href="/mmo.tm/account/downloadgameclient.php?view=4">Download game clients</a></li>
						</ul>
					</div>

					<div id="nav_1" class="btn-group dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">

							<span class="userInfoHeader">Transaction History</span>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li><a href="/mmo.tm/account/orderhistory.php?view=4">Order History</a></li>
							<li><a href="/mmo.tm/account/balancehistory.php?view=4">Balance History</a></li>
						</ul>
					</div>
					<div id="account_balance">
						<span>
							<b id="cur_balance"><?php echo $mmoPointBalance; ?></b>
							&nbsp;mmoPts
						</span></br>
						<a href="purchase.php" onclick="
						<?php if(!isset($_SESSION['userORM'])){ 
							echo "alert('You need to be logged in to charge points.');return false;";
						}else{
							echo "return true";
						}?>
						">
						<img src="images/charge.png" id="charge_balance" />
					</a>
				</div>
			</nav>
		</div>
	</div>

	<div class="content-wrap">
		<div id="ordergame-wrapper">
			<div id="ordergame">
				<span>TRANSACTION HISTORY</span>
				<h1>Your Order History</h1>
				<hr>
			</div>
			<div id="order-header">
				<div id="order-area">
						<!-- <div class="btn-group">
						  <button type="button" class="btn btn-default">America</button>
						  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu">
						    <li><a href="#">Asia</a></li>
						    <li><a href="#">Europe</a></li>
						    <li><a href="#">Southeast Asia</a></li>
						    <li><a href="#">India</a></li>
						  </ul>
						</div>
						<label>Area:</label> -->
						<table class="table table-hover">
							<tr>
								<th>ORDER#</th>
								<th>DATE</th>
								<th>PRODUCT</th>
								<th>UNIT PRICE</th>
								<th>QUANTITY</th>
								<th>STATUS</th>
								<th>TOTAL</th>
								</tr><?php
								$email1 = $_SESSION['userORM'];
								$result1 = mysql_query("SELECT * FROM users WHERE email='$email1'");

								while($row2 = mysql_fetch_array($result1))
								{
									$user_email = $row2['id'];
								}

								$result2 = mysql_query("SELECT * FROM trans_hist WHERE user_id='$user_email'");

								while($row1 = mysql_fetch_array($result2))
								{
									$x=$row1['qty'];
									$y=$row1['unit_price'];
									$z=$x*$y;
									echo "<tr><td>".$row1['order_num']."</td><td>".$row1['date']."</td><td>".$row1['product']."</td><td>".$row1['unit_price']."</td><td>".$row1['qty']."</td><td><a href='https://www.sandbox.paypal.com/cgi-bin/webscr'>".$row1['status']."</a></td><td>".$z."</td></tr>";
								}

								?>
							</table>
						</div>
					</div>
				</div>
			</div>


			<div class="content-wrap" style="margin-top:380px;">
				<div id="pre_footer">
					<div id="supplinks"><p>Support</p>
						<p id="cantlog"><a href="../divinesouls/forum/index.php">Forum Support</a><br/>
							<a href="mailto:sheldon@any.tv?Subject=Help" target="_top">Help!</a><br/>
						</div>
						<div id="acchead"></p>Account</p>
							<p id="cantlog"><a href="mailto:sheldon@any.tv?Subject=Can't%20Login" target="_top">Can't log in?</a><br/>
								<a href="../divinesouls/signup.php">Create Account</a><br/>
								<a href="../account/account.php?view=1">Account Summary</a><br/>

							</div>
						</div>
					</div>


					<div class="content-wrap">
						<div id="footer">
							<div id="amanytv">
								part of the <a href="http://www.any.tv" title="any.TV" id="amanytvlogo" >any.TV</a> family
							</div><!--end anytv-->
							<div id="amfooter">
								Copyright &copy; 2013 any.TV. All Rights Reserved.					
							</div>
							<!--end footer-->
						</div>
					</div>
				</div>
			</div>
		</body>

		<?php } ?>

		</html>