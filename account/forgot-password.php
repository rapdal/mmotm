<?php 
include("../includes/_header.php");
?>
<div class = "bg1 bg2">
	<div id="vessel">
		<?php include("../includes/_menu.php"); ?>
		<div id="seek" >
			<span id="scout1" >
				<!--<form action="http://mmo.tm/account/account.php?view=1" method="#" >
					<input id="submitmgmtsearch" type="text" placeholder="Search" id="pass" required/>
					<input id="submitmgmt2" type="submit" value="" name="submit" />
				</form>-->
			</span>
		</div>

		<?php if(!isset($_SESSION['userORM'])){
			?>
			<div id="resetlabel" style="margin-top: 170px;">
				<p id="acc03">Forgot Password</p>
				<p id="acc2">please provide the information below</p>
			</div><!--end resetlabel-->

			<?php
			if(isset($_POST['emailadd'])){

				$username = $_POST['emailadd'];

				mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
				mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database. 

				$result = mysql_query("SELECT * FROM Users WHERE email='$username'");

				while($row = mysql_fetch_array($result))
				{
					$email = $row['email'];
					$password_old = $row['password'];
				}

				if(mysql_num_rows($result)==0){//email does not exist.
					echo "<div style='position: absolute;text-align: center;width: 1100px;margin-top: 64px;'>Email does not exist.</div>";
				}else{ //email exists
					echo "<div style='position: absolute;text-align: center;width: 1100px;margin-top: 64px;'>Email sent.</div>";
					$tstamp = date("YmdHms");
					$sendemail = $username.$tstamp;
					$sha = sha1($sendemail);
					$sendemail = "mmo.tm/home/reset.php?rid=".$sha;
					$subject = "Password Reset" ;
					$message = "Click this link to reset password: ".$sendemail;
					mail($email, $subject,
						$message, "From:" . "no-reply@mmo.tm");

					$result2 = mysql_query("SELECT * FROM resetpass WHERE email='$username'");

					if(mysql_num_rows($result2)==0){
					mysql_query("INSERT INTO resetpass (rid, email) VALUES('$sha','$email')");
					}else{
					mysql_query("UPDATE resetpass SET rid='$sha' WHERE email='$email'");
					}

				}
			}
			?>

			<div style="height: 357px;width: auto;text-align: center;">
				<div style="margin-left: 402px;margin-top: 114px;">
					<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
						<table>
							<tr id="tabletr"><td style="text-align:right;padding-right:8px;padding-bottom: 10px;">Email*: </td><td><input type="email" name="emailadd" placeholder="Enter email address" required/></td></tr>
							<tr id="tabletr"><td></td><td><button type="submit" name="startAccountReset" id="submit01" style="margin-left: 20px;"></button></td></tr>
						</table>
					</form>
				</div><!--end input-->
			</div>
			<?php 
		}
		else{
			echo '<div style="height: 570px;">
			<div id="resetlabel" style="margin-top: 170px;">
			<p id="acc03">Page Not Found</p>
			</div><!--end resetlabel-->
			</div>';
		}
		?>
		<div class="content-wrap" style="margin-top:85px;">
			<div id="pre_footer">
				<div id="supplinks"><p>Support</p>
					<p id="cantlog"><a href="http://mmo.tm/divinesouls/forum">Forum Support</a><br/>
						<a href="mailto:sheldon@any.tv?Subject=Help" target="_top">Help!</a><br/>
					</div>
					<div id="acchead"></p>Account</p>
						<p id="cantlog"><a href="mailto:sheldon@any.tv?Subject=Can't%20Login" target="_top">Can't log in?</a><br/>
							<a href="http://mmo.tm/divinesouls/signup.php">Create Account</a><br/>
							<a href="http://mmo.tm/account/account.php?view=1">Account Summary</a><br/>
				<!--<a href="#">Add a Game</a><br/>
				<a href="#">Redeem Promo Codes</a><br/></p>
			-->
		</div>
	</div>
</div>

<!--end $Ren-->
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