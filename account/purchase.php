<?php
session_start();

if(!isset($_SESSION['userORM'])){
	header("Location: http://mmo.tm/divinesouls");
}

if(isset($_SESSION['payKey'])){
	mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
	mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database. 
	
	$email = $_SESSION['userORM'];
	$ItemName = "mmoPointBalance";
	$ItemTotalPrice = $_SESSION['amount'];
	$result = mysql_query("SELECT * FROM Users WHERE email = '$email'") or die(mysql_error());


	while($row = mysql_fetch_array($result))
	{
		$user_id = $row['id'];
		$email = $row['email'];
		$fullName = $row['fullName'];
		$mmoTag = $row['mmoTag'];
		$country = $row['country'];
		$divineSoulsActive = $row['keyActive'];
		
		switch($ItemTotalPrice){
			case '2.89':
				$mmoPointBalance =$row['mmoPointBalance']+390;
				break;
			case '4.89':
				$mmoPointBalance = $row['mmoPointBalance']+625;
				break;
			case '9.89':
				$mmoPointBalance = $row['mmoPointBalance']+1240;
				break;
			case '19.89':
				$mmoPointBalance = $row['mmoPointBalance']+2540;
				break;
			case '29.89':
				$mmoPointBalance = $row['mmoPointBalance']+4200;
				break;
			default:
				break;
		}
		
		$query_return = mysql_query("UPDATE Users SET mmoPointBalance='$mmoPointBalance' WHERE email='$email'") or die(mysql_error());
				
		if($query_return && ($anytv_transaction_id = $row['transaction_id']))
		{
		  $postback_url = "http://play.any.tv/aff_goal?a=lsr&goal_id=2&transaction_id=$anytv_transaction_id&amount=$ItemTotalPrice";
		  $postback_url_result = file_get_contents( $postback_url );  
		  unset($postback_url_result); // use for testing    
		}
		
		$result_or = mysql_query("SELECT * FROM trans_hist WHERE user_id = '$user_id'") or die(mysql_error());
		while($row_or = mysql_fetch_array($result_or))
		{
			$order_num = $row_or['order_num'];
		}
		
		mysql_query("INSERT INTO trans_hist(product,unit_price,user_id,qty) values('$ItemName','$ItemTotalPrice','$user_id','1')") or die(mysql_error());
		mysql_query("INSERT INTO balance_hist(user_id,ordernum,product,amount,balance) values('$user_id','$order_num','$ItemName','$ItemTotalPrice','$mmoPointBalance')") or die(mysql_error());
	}
	
	unset($_SESSION['payKey']);
	unset($_SESSION['amount']);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<html xmlns="http://w3.org/1999/xhtml">
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
	<div class = "body-mgmt">
		<div id="vessel" style="height: 1072px;">
			<?php include("../includes/_menu.php"); ?>
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
				<!--<form action="http://mmo.tm/account/account.php" method="#" >
					<input id="submitmgmtsearch" type="text" placeholder="Search" id="pass" required/>
					<input id="submitmgmt2" type="submit" value="" name="submit" />
				</form>-->
			</span>
		</div>

		<div class="content-wrap" style="margin-top: 130px;">
			<div class="content">
				
				<nav>
					<div class="nav_2"><img src="images/my-account-icon.png"/></div>

					<div class="nav_1"><a style="margin-right: 21px;" href="../account/account.php">Summary</a></div>

					<div id="nav_1" class="btn-group dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								
								<span class="userInfoHeader">Settings</span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
								<li><a href="../account/management/settings/account-reset.php">Account Reset</a></li>
								<li><a href="../account/management/settings/password-reset.php">Password Reset</a></li>
								<li><a href="../account/management/settings/payment-options.php">Payment Options</a></li>
							</ul>
						</div>

					<div id="nav_1" class="btn-group dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								
								<span class="userInfoHeader">Games & Codes</span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
								<li><a href="../account/addgamekey.php">Add a game key</a></li>
								<li><a href="../account/downloadgameclient.php">Download game clients</a></li>
							</ul>
					</div>

					<div id="nav_1" class="btn-group dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								
								<span class="userInfoHeader">Transaction History</span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
								<li><a href="../account/orderhistory.php">Order History</a></li>
								<li><a href="../account/balancehistory.php">Balance History</a></li>
							</ul>
					</div>
					<div id="account_balance">
						<span>
							<b id="cur_balance"><?php echo $mmoPointBalance; ?></b>
							&nbsp;mmoPts
						</span></br>
						<a href="purchase.php">
						<!-- <img src="images/charge.png" id="charge_balance" /> -->
						<button type ="submit" class="btn btn-primary" id="btn-chargepts"><strong>CHARGE POINTS</strong></button>
					</a>
				</div>
			</nav>
		</div>
	</div>

	<div class="content-wrap" style="margin: 50px 22px 0px 0px; width: 1010px;">
		
		<div class="content-wrap">
		<div  id="main-content" style="width: 960px;">
			<div id="box-4">
			<a href="../account/addgamekey.php">
				<!-- <img src="images/add-game-key.png"/> -->
				<button type ="submit" class="btn btn-danger" id="btn-gamekey"><strong>ADD A GAME KEY</strong></button>
			</a>
			</div>
			<div id="box-1">
				<div style="margin-left: 200px;">
					<img src="images/game-recharge.png"/>
				</div>
				<ul id="purchase-wrap">
					<li>
						<form action="management/settings/payment-summary.php" method="post" name="frmPayPal1">
						<input type="hidden" name="itemnumber" value="1">
						<input type="hidden" name="amount" value="2.89">
						<input type="hidden" name="imagelink" value="90.png">
						<input type="image" src="images/90.png">
						<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</li>
					<li>
						<form action="management/settings/payment-summary.php" method="post" name="frmPayPal1">
						<input type="hidden" name="itemnumber" value="2">
						<input type="hidden" name="amount" value="4.89">
						<input type="hidden" name="imagelink" value="125.png">
						<input type="image" src="images/125.png">
						<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</li>
					<li>
						<form action="management/settings/payment-summary.php" method="post" name="frmPayPal1">
						<input type="hidden" name="itemnumber" value="3">
						<input type="hidden" name="amount" value="9.89">
						<input type="hidden" name="imagelink" value="240.png">
						<input type="image" src="images/240.png">
						<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</li>
					<li style="margin-left: 137px;">
						<form action="management/settings/payment-summary.php" method="post" name="frmPayPal1">
						<input type="hidden" name="itemnumber" value="4">
						<input type="hidden" name="amount" value="19.89">
						<input type="hidden" name="imagelink" value="540.png">
						<input type="image" src="images/540.png">
						<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</li>
					<li>
						<form action="management/settings/payment-summary.php" method="post" name="frmPayPal1">
						<input type="hidden" name="itemnumber" value="5">
						<input type="hidden" name="amount" value="29.89">
						<input type="hidden" name="imagelink" value="1200.png">
						<input type="image" src="images/1200.png">
						<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</li>
				</ul>
			</div>			
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
						<a href="../account/account.php">Account Summary</a><br/>
				</div>
		</div>
	</div>

<div class="content-wrap">
	<div id="footer">
		<div id="amanytv">
			part of the <a href="http://any.tv" title="any.TV" id="amanytvlogo" >any.TV</a> family
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