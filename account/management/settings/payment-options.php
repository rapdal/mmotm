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
				<span>ACCOUNT SETTINGS</span>
				<h1>Payment Options</h1>
				<hr>
				<span>Manage your mode of payment available.</span>
			</div>

			<div class="description">
				<span>Mode of payment</span>
			</div>
			<div id ="gamekeybox" style="min-height: 135px; margin-top: 15px;">

			<?php
			
				$user_id=$_SESSION['userORM'];
				$get_id = mysql_query("SELECT * FROM paymentMethod WHERE email = '$user_id'");
				if(mysql_num_rows($get_id)){
					while($row = mysql_fetch_array($get_id))
					{
						$email = $row['email'];
						$paypal_email = $row['paypal_email'];
						echo"<span style='margin-bottom: 10px;'>ACCOUNT NAME:</span><br><br>
							 <span>".$paypal_email."</span>
							 <a href='../../payment/cancelpreapproval.php' style='margin-left: 10px;'>Delete</a>";
					}
				}
				else{
					echo "<h1>None attached</h1>
					  <span>No mode of payment added.</span><br>";
				}
				
				
				
			?>
				<form method="post" action="../../management/settings/payment-method.php" >
					<button type ="submit" class="btn btn-primary" id="paymodebutton" style="margin-top:20px;">ADD MODE OF PAYMENT</button>
				</form>
			</div>
		
	</div>


	<div class="content-wrap" style="margin-top:265px;">
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