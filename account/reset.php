<?php 
include("../includes/_header.php");
?>
<div class = "bg1 bg2">
	<div id="vessel">
		<?php include("../includes/_menu.php"); ?>
		<div id="seek" >
			<span id="scout1" >
				<!--<form action="http://mmo.tm/account/account.php?view=1" method="#" >
					<input id="submitmgmt2" type="submit" value="" name="submit" />
					<input id="submitmgmtsearch" type="text" placeholder="Search" id="pass" required/>
				</form>-->
			</span>
		</div>
		<?php
		$r_id = $_GET['rid'];
mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
				mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database. 

				$result = mysql_query("SELECT * FROM resetpass WHERE rid='$r_id'");
				if(!isset($_SESSION['userORM'])){
					if(mysql_num_rows($result)){

						while($row1 = mysql_fetch_array($result))
						{
							$username = $row1['email'];
						}

						?><div id="resetlabel" style="margin-top: 170px;">
						<p id="acc03">Forgot Password</p>
						<p id="acc2">please provide the information below</p>
					</div><!--end resetlabel-->
					<div style="height: 388px;">
						<form class="form-inline" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
							<table style="margin-left: 318px;margin-top: 80px;">
								<tr id="tabletr"><td style="text-align:right;padding-right:8px;">New Password*: </td><td><input type="password" name="newpass" placeholder="Enter New Password" pattern="(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="minimum of 6 characters" required/></td></tr>
								<tr id="tabletr"><td style="text-align:right;padding-right:8px;">Confirm New Password*: </td><td><input type="password" name="conpass"placeholder="Confirm New Password" pattern="(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="minimum of 6 characters" required/></td></tr>
								<tr id="tabletr"><td></td><td><button type="submit" name="startAccountReset" id="submit01"></button></td></tr>
							</table>
						</form>
					</div><!--end input-->
					<?php

				}else{
					$_POST['newpass']=NULL;
					?>
					<div style="height: 570px;">
						<div id="resetlabel" style="margin-top: 170px;">
							<p id="acc03">Link Already used</p>
						</div><!--end resetlabel-->
					</div>
					<?php
				}
			}else{?>
			<div style="height: 570px;">
				<div id="resetlabel" style="margin-top: 170px;">
					<p id="acc03">Page Not Found</p>
				</div><!--end resetlabel-->
			</div>
			<?php
		}

		if(isset($_POST['newpass'])){
			$newpass = $_POST['newpass'];
			$conpass = $_POST['conpass'];

			$newpass =md5($newpass);
			$conpass = md5($conpass);

				mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
				mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database. 

				$pass_re = mysql_query("SELECT * FROM Users WHERE email='$username'");


				while($row = mysql_fetch_array($pass_re))
				{
					$email = $row['email'];
				}
				if($username==$email){
					if($newpass==$conpass){
						mysql_query("UPDATE Users SET password='$newpass' WHERE email='$username'");
						mysql_query("DELETE FROM resetpass WHERE rid = '$r_id'");
						echo "<div style='text-align:center;position: absolute;top: 315px;margin-left: 454px;'>Password Reset Success!</div>";
					}else{
						echo "<div style='text-align:center;position: absolute;top: 315px;margin-left: 454px;'>New password didn't match.</div>";
					}
				}

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