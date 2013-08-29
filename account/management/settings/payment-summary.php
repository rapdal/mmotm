<?php
session_start();

if(!isset($_SESSION['userORM'])){
	header("Location: http://mmo.tm/divinesouls");
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

	<link rel="stylesheet" type="text/css" href="../../../css/styles.css">
	<link rel="stylesheet" href="../../../css/bootstrap.min.css" />

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="../../../js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../../../js/paypal-button.min.js" type="text/javascript"></script>
	<script src="../../../js/general.js?ver=1.02" type="text/javascript"></script>

	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Gudea" />
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Russo+One" />
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Univers" />
	
</head>

<body>
	<div class = "body-mgmt">
	<div id="vessel" style="height: 1072px;">
		<?php include("../../../includes/_menu.php"); ?>
		<?php
		if(isset($_SESSION['userORM'])){

			$username = $_SESSION['userORM'];
			
			$amount = $_POST['amount'];
			$imagelink = $_POST['imagelink'];

			mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
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
			</span>
		</div>

		<div class="content-wrap" style="margin-top: 130px;">
			<div class="content">
				
				<nav>
					<div class="nav_2"><img src="../../images/my-account-icon.png"/></div>

					<div class="nav_1" style="width: 95px;"><a style="margin-right: 50px;" href="../../account.php">Summary</a></div>
					<div id="nav_1" class="btn-group dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">

							<span class="userInfoHeader">Settings</span>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li><a href="../settings/account-reset.php">Account Reset</a></li>
							<li><a href="../settings/password-reset.php">Password Reset</a></li>
							<li><a href="../settings/payment-options.php">Payment Options</a></li>
						</ul>
					</div>
					<div id="nav_1" class="btn-group dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">

							<span class="userInfoHeader">Games & Codes</span>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li><a href="../../addgamekey.php">Add a game key</a></li>
							<li><a href="../../downloadgameclient.php">Download game clients</a></li>
						</ul>
					</div>

					<div id="nav_1" class="btn-group dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">

							<span class="userInfoHeader">Transaction History</span>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li><a href="../../orderhistory.php">Order History</a></li>
							<li><a href="../../balancehistory.php">Balance History</a></li>
						</ul>
					</div>
					<div id="account_balance">

						<span>
							<b id="cur_balance"><?php echo $mmoPointBalance; ?></b>
							&nbsp;mmoPts
						</span></br>
						<a href="../../purchase.php" onclick="
						<?php if(!isset($_SESSION['userORM'])){ 
							echo "alert('You need to be logged in to charge points.');return false;";
						}else{
							echo "return true";
						}?>
						">
						<!-- <img src="../../images/charge.png" id="charge_balance" /> -->
						<button type ="submit" class="btn btn-primary" id="btn-chargepts"><strong>CHARGE POINTS</strong></button>
					</a>
				</div>
			</nav>
		</div>
	</div>

	<div class="content-wrap">
		<div id="addgamekey-wrapper">
			<div id="addgamekey">
				<span>ACCOUNT MANAGEMENT</span>
				<h1>Purchasing</h1>
				<hr>
			</div>
			<div>
				<div id ="summarybox">
					<h3>Summary</h3>
					<img src="../../images/<?php echo $imagelink?>" height="70" width="120" style="margin: 10px 10px 0 0; float:left;">
					<h4>MMOTM : DivineSouls</h4>
					<span>You are purchasing MMO points worth <?echo $amount?></span>
					<a href="http://mmo.tm/account/purchase.php">Edit order</a>
					<hr>
					<div class="total-payment">
						Total:
						<strong><?php echo $amount?></strong>
					</div>
				</div>
				<div id ="gamekeybox2" style="float: left; margin-top: 50px;">
					<form method="post" action="../../payment/basicpayment.php">
						<input type="hidden" name="amount" value="<?php echo $amount?>">
						<input type="radio" name="paymentMode" value="Paypal" checked="checked">
						<img src="https://www.paypal.com/en_US/i/logo/PayPal_mark_37x23.gif" style="margin-right:7px; margin-top:2px;"><span style="font-size:11px; font-family: Arial, Verdana; float:none;">The safer, easier way to pay.</span>
						<br/>
						<button type="submit" class="btn btn-primary" id="paymodebutton">CONTINUE</button>
					</form>
				</div>
			</div>
		
	</div>


	<div class="content-wrap" style="margin-top:220px;">
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