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
		<!--<form action="http://mmo.tm/account/account.php?view=1" method="#" >
			<input id="submitmgmtsearch" type="text" placeholder="Search" id="pass" required/>
			<input id="submitmgmt2" type="submit" value="" name="submit" />
		</form>-->
	</span>
</div>

<div class="content-wrap" style="margin-top: 130px;">
	<div class="content">
		
		<nav>
			<div class="nav_2"><img src="images/my-account-icon.png"/></div>

			<div class="nav_1" style="width: 95px;"><a style="margin-right: 50px;" href="../account/account.php">Summary</a></div>
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
				<a href="purchase.php" onclick="
				<?php if(!isset($_SESSION['userORM'])){ 
					echo "alert('You need to be logged in to charge points.');return false;";
				}else{
					echo "return true";
				}?>
				">
				<!-- <img src="images/charge.png" id="charge_balance" /> -->
				<button type ="submit" class="btn btn-primary" id="btn-chargepts"><strong>CHARGE POINTS</strong></button>
			</a>
		</div>
	</nav>
</div>
</div>

<div class="content-wrap">
	<div id="downloadgame-wrapper">
		<div id="downloadgame">
			<span>GAME MANAGEMENT</span>
			<h1>Download Games</h1>
			<hr>
			<div id="downloadgame-filter">
				<a href="">All Games</a> /
				<a href="">Divine Souls</a> /
			</div>
		</div>
		<div id="downloadgame-body">
			<div id="downloadgame-header">
				<img src="images/ds_logo.png">
				<span>GAME CLIENT DOWNLOADS</span>
				<h2>Divine Souls</h2>
			</div>
			<table>
				<thead>
					<tr>
						<th scope="col"></th>
						<th scope="col"></th>
						<th scope="col"></th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th scope="row" colspan="2" class="gamedl-padding">
							<img src="images/png/32x32/lock.png" class="gameclient-icon">
							<h4>Game Client</h4>
							<p class="language-selection">
								<!-- <span class="region">America</span> /  -->
								<span class="language">English (US) </span>
								<!-- <a onclick="document.getElementById('divinesouls-full').style.display='block';return false;" href="#" class="change-language" style="color: #0072a3;">(Change)</a> -->
							</p>
							<div id ="divinesouls-full" class="region-select-div-show">
								<!-- <p>Available Regions</p>
								<p class="region-selector">
									<a href="#" class="active">Asia </a> / 
									<a href="#"> Philippines </a> / 
									<a href="#"> Japan </a> / 
									<a href="#">Korea</a>
								</p>
									<div class="available-languages">
										<p>Available Languages for America</p>
										<p class="language-selector">
											<a href="#">Tagalog </a> / 
											<a href="#"> Bisaya </a> /
											<a href="#"> Abakada</a>

										</p> 
									</div> -->
									<p class = "save">
										<a onclick="document.getElementById('divinesouls-full').style.display='none';return false;" href="#" style="color: #0072a3;">SAVE</a>
									</p>
								</div>
							</th>
							<td class="gamedl-link">
								<span ><img src="images/win7.png" class="dl-icon"></span>
								<a href="http://download.mmo.tm/">Windows</a>
							</td>
							<td class="gamedl-link">
								<span ><img src="images/macicon.png" class="dl-icon"></span>
								<a href="#">Mac</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>


	<div class="content-wrap" style="top: 880px; position: absolute;">
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

				<div class="content-wrap" style="position: absolute; bottom: -100px;">
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
	</div>
</body>
</html>