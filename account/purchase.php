<?php
session_start();

if(!isset($_SESSION['userORM'])){
	header("Location: http://localhost/mmo.tm/divinesouls");
}

?>
<?php
$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; // Test Paypal API URL
$paypal_id='uekigx@gmail.com'; // Business email ID
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

	<title>Purchase</title>

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

<body>
	<?php
	$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; // Test Paypal API URL
	$paypal_id='uekigx@gmail.com'; // Business email ID
	?>
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
					<input id="submitmgmt2" type="submit" value="" name="submit" />
					<input id="submitmgmtsearch" type="text" placeholder="Search" id="pass" required/>
				</form>
			</span>
		</div>

		<div class="content-wrap" style="margin-top: 130px;">
			<div class="content">
				
				<nav>
					<div class="nav_2"><img src="images/my-account-icon.png"/></div>

					<div class="nav_1"><a style="margin-right: 50px;" href="/mmo.tm/account/account.php?view=4">Summary</a>
						<div class="btn-group dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								
								<span class="userInfoHeader">Settings</span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
								<li><a href="/mmo.tm/account/management/settings/account-reset.php">Account Reset</a></li>
								<li><a href="/mmo.tm/account/management/settings/password-reset.php">Password Reset</a></li>
							</ul>
						</div>
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
		<div id="box-4">
			<img src="images/add-game-key.png"/>
		</div>
	</div>
	
	<div class="content-wrap">
		<div  id="main-content" style="width: 960px;">
			<div id="box-1">
				<div style="margin-left: 200px;">
					<img src="images/game-recharge.png"/>
				</div>
				<ul id="purchase-wrap">
					<li>
						<form action="<?php echo $paypal_url; ?>" method="post" name="frmPayPal1">
							<input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
							<input type="hidden" name="cmd" value="_xclick">
							<input type="hidden" name="item_name" value="mmoPointBalance">
							<input type="hidden" name="item_number" value="1">
							<input type="hidden" name="amount" value="2.89">
							<input type="hidden" name="notify_url" value="http://staging.mmo.tm/account/ipn.php" />
							<input type="hidden" name="currency_code" value="USD">
							<input type="hidden" name="cancel_return" value="http://staging.mmo.tm/account/account.php?view=4">
							<input type="hidden" name="return" value="http://staging.mmo.tm/account/success.php">
							<input type="image" src="images/90.png">
							<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</li>
					<li>
						<form action="<?php echo $paypal_url; ?>" method="post" name="frmPayPal1">
							<input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
							<input type="hidden" name="cmd" value="_xclick">
							<input type="hidden" name="item_name" value="mmoPointBalance">
							<input type="hidden" name="item_number" value="2">
							<input type="hidden" name="amount" value="4.89">
							<input type="hidden" name="notify_url" value="http://staging.mmo.tm/account/ipn.php" />
							<input type="hidden" name="currency_code" value="USD">
							<input type="hidden" name="cancel_return" value="http://staging.mmo.tm/account/account.php?view=4">
							<input type="hidden" name="return" value="http://staging.mmo.tm/account/success.php">
							<input type="image" src="images/125.png">
							<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</li>
					<li>
						<form action="<?php echo $paypal_url; ?>" method="post" name="frmPayPal1">
							<input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
							<input type="hidden" name="cmd" value="_xclick">
							<input type="hidden" name="item_name" value="mmoPointBalance">
							<input type="hidden" name="item_number" value="3">
							<input type="hidden" name="amount" value="9.89">
							<input type="hidden" name="notify_url" value"http://staging.mmo.tm/account/ipn.php" />
							<input type="hidden" name="currency_code" value="USD">
							<input type="hidden" name="cancel_return" value="http://staging.mmo.tm/account/account.php?view=4">
							<input type="hidden" name="return" value="http://staging.mmo.tm/account/success.php">
							<input type="image" src="images/240.png">
							<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</li>
					<li style="margin-left: 137px;">
						<form action="<?php echo $paypal_url; ?>" method="post" name="frmPayPal1">
							<input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
							<input type="hidden" name="cmd" value="_xclick">
							<input type="hidden" name="item_name" value="mmoPointBalance">
							<input type="hidden" name="item_number" value="4">
							<input type="hidden" name="amount" value="19.89">
							<input type="hidden" name="notify_url" value="http://staging.mmo.tm/account/ipn.php" />
							<input type="hidden" name="currency_code" value="USD">
							<input type="hidden" name="cancel_return" value="http://staging.mmo.tm/account/account.php?view=4">
							<input type="hidden" name="return" value="http://staging.mmo.tm/account/success.php">
							<input type="image" src="images/540.png">
							<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</li>
					<li>
						<form action="<?php echo $paypal_url; ?>" method="post" name="frmPayPal1">
							<input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
							<input type="hidden" name="cmd" value="_xclick">
							<input type="hidden" name="item_name" value="mmoPointBalance">
							<input type="hidden" name="item_number" value="5">
							<input type="hidden" name="amount" value="29.89">
							<input type="hidden" name="notify_url" value="http://staging.mmo.tm/account/ipn.php" />
							<input type="hidden" name="currency_code" value="USD">
							<input type="hidden" name="cancel_return" value="http://staging.mmo.tm/account/account.php?view=4">
							<input type="hidden" name="return" value="http://staging.mmo.tm/account/success.php">
							<input type="image" src="images/1200.png">
							<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</li>
				</ul>
			</div>			
		</div>
	</div>

	<div class="content-wrap" style="margin-top:70px;">
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

</html>
<?php

?>