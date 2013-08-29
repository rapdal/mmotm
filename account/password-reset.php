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

<?php


?>
<body>
	<div class="body03">
		<div id="container03">
			<div id="header03" style="height: 45px;">
				<div id="header03-wrap">
					<?php include("../../../includes/_menu.php"); ?>
				</div>
			</div><!--end header-->
			
			<div id="logo03">
				<h1>Logo</h1>
			</div><!--end logo-->
			<?php if(!isset($_POST['oldpass'])){?>
			<div id="resetlabel">
				<p id="acc03">PASSWORD RESET</p>
				<p id="acc2">please provide the information below</p>
			</div><!--end resetlabel-->

			<div id="divider">
				<h1>Divider</h1>
			</div><!--end divider-->

			<div id="new_reset">
				<form class="form-inline" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
					<table>
						<tr id="tabletr"><td style="text-align:right;padding-right:8px;">Old Password*: </td><td><input type="password" name="oldpass" placeholder="Enter Old Password" pattern=".{6,}" required/></td></tr>
						<tr id="tabletr"><td style="text-align:right;padding-right:8px;">New Password*: </td><td><input type="password" name="newpass" placeholder="Enter New Password" pattern=".{6,}" title="minimum of 6 characters" required/></td></tr>
						<tr id="tabletr"><td style="text-align:right;padding-right:8px;">Confirm New Password*: </td><td><input type="password" name="conpass"placeholder="Confirm New Password" pattern=".{6,}" title="minimum of 6 characters" required/></td></tr>
						<tr id="tabletr"><td></td><td><button type="submit" name="startAccountReset" id="submit01"></button></td></tr>
					</table>
				</form>
			</div><!--end input-->

			<?php
		}
		else if(isset($_POST['oldpass'])){
			$username = $_SESSION['userORM'];
			$oldpass = $_POST['oldpass'];
			$newpass = $_POST['newpass'];
			$conpass = $_POST['conpass'];

			$oldpass = md5($oldpass);
			$newpass =md5($newpass);
			$conpass = md5($conpass);
			$text_echo = '
				<div id="new_reset">
				<form class="form-inline" action="'.$_SERVER['PHP_SELF'].'" method="POST">
				<table id="reset_table">
				<tr id="tabletr"><td style="text-align:right;padding-right:8px;">Old Password*: </td><td><input type="password" name="oldpass" placeholder="Enter Old Password"  pattern=".{6,}" required/></td></tr>
				<tr id="tabletr"><td style="text-align:right;padding-right:8px;">New Password*: </td><td><input type="password" name="newpass" placeholder="Enter New Password"  pattern=".{6,}" title="minimum of 6 characters" required/></td></tr>
				<tr id="tabletr"><td style="text-align:right;padding-right:8px;">Confirm New Password*: </td><td><input type="password" name="conpass"placeholder="Confirm New Password"  pattern=".{6,}" title="minimum of 6 characters" required/></td></tr>
				<tr id="tabletr"><td></td><td><button type="submit" name="startAccountReset" id="submit01"></button></td></tr>
				</table>
				</form>
				</div><!--end input-->';

				mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
				mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database. 

				$pass_re = mysql_query("SELECT * FROM users WHERE email='$username'");

				echo '<div id="resetlabel">
				<p id="acc03">PASSWORD RESET</p>
				<p id="acc2">please provide the information below</p>
				</div><!--end resetlabel-->
				
				<div id="divider">
				<h1>Divider</h1>
				</div><!--end divider-->';

				while($row = mysql_fetch_array($pass_re))
				{
					$email = $row['email'];
					$password_old = $row['password'];
				}
				if($username==$email){
					if($oldpass==$password_old){
						if($newpass==$conpass){
							mysql_query("UPDATE users SET password='$newpass' WHERE email='$username'");
							echo "Password Reset Success!";
						}else{
							echo "New password didn't match.";
							echo $text_echo;
						}
					}
					else{
						echo "Old password didn't match";
						echo $text_echo;
					}
				}

			}
			?>

			<div id="continue03">
				<p id="cont03">continue to</p>
				<a href="/mmo.tm/divinesouls/" title="Divine Souls" id="dslogo">Divine Souls</a>
			</div><!--end continue-->
			<div id="anytv">
				part of the <a href="http://www.any.tv" title="any.TV" id="anytvlogo">any.TV</a> family
			</div><!--end anytv-->

			<div id="footer">
				Copyright &copy; 2013 any.TV. All Rights Reserved.
			</div><!--end footer-->

		</div><!--end container-->
	</div>
	<body>
		</html>
