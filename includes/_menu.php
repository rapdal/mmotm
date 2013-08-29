
<?php 
if(!isset($_SESSION['userORM'])){
	$username = 'N/A';

	$email = 'N/A';
	$fullName = 'N/A';
	$mmoTag = 'N/A';
	$country = 'N/A';
	$mmoPointBalance = 0;
	$divineSoulsActive = 0;

	if(isset($_POST['username']) && isset($_POST['password'])){
		$username = $_POST['username'];
		$password = $_POST['password'];

		mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
		mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database. 

		$password = md5($password);

		$result = mysql_query("SELECT * FROM Users WHERE email = '$username' AND password = '$password'") or die(mysql_error());
		
		if(mysql_num_rows($result)==0){
		echo"<script type='text/javascript'>alert('Username and Password mismatched')</script>";
		}else{
		
		while($row = mysql_fetch_array($result))
		{
			$email = $row['email'];
			$fullName = $row['fullName'];
			$mmoTag = $row['mmoTag'];
			$country = $row['country'];
			$mmoPointBalance = $row['mmoPointBalance'];
			$divineSoulsActive = $row['keyActive'];
			$mmoPointBalance = $row['mmoPointBalance'];
			
			$_SESSION['userORM'] = $email;
		}
		echo "<meta http-equiv='refresh' content='0;url=http://mmo.tm/home/'>";
		}
	}
}
?>

<div id="arch" >
	<span id="brand">
		<a id="emblem" href="http://mmo.tm/home"><img src="/images/mmoTM.png"/></a>
	</span>
	<span id="guide">
		<p style="margin-left: 55px;">
			<a class="login-window" href="
			<?php
			if(isset($_SESSION['userORM'])){
				echo "http://mmo.tm/account/account.php";
			}else{
				echo "#login-box";
			}
			?>
			">My Account</a></p>
			<p><a href="http://mmo.tm/divinesouls/forum">Forums</a>	</p>
			<p><a href="http://mmo.tm/divinesouls/guides.php">Guides</a>	</p>
			<p><a href="http://mmo.tm/divinesouls/media.php">Media</a>	</p>
		</span>
		
		<span id="access">
			
			<?php	if(!isset($_SESSION['userORM'])) { ?>
			
			<a id="accessin" href="/divinesouls/signup.php"><img style="border-radius: 3px; margin-right: 2px;" src="images/sign-up2.png"/></a>
			<span style="width: 50px; background-color: green;"></span>
			<a href="#login-box" id="accessinlog" class="login-window"><img style="border-radius: 3px"src="images/login2.png"/></a>
			
			<?php	} else { ?>
			
			
			
			<div class="btn-group dropdown">
				<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					<?php 	if(isset($_SESSION['gmORM'])) { ?>
					<span class="userInfoHeader">[GM] </span>
					<?php } ?>
					<span class="userInfoHeader"><?php echo $_SESSION['userORM']; ?></span>
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
					<li><a href="/account/purchase.php" target="_blank">Charge mmoPoints</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>


			<?php	} ?>
		</span>
		<span style="float: left; position:absolute; " >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

		<div id="login-box" class="login-popup" style="background-image: url('../divinesouls/images/bg-ds.jpg'); background-position: center center; repeat: no-repeat; height: 183px; color: orange; text-size: 250%; font-weight: bold; border: 0px;">
			<a href="#" class="close"><img src="../divinesouls/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
			<form method="post" class="signin" action="<?php $_SERVER['PHP_SELF']?>">
				<fieldset class="textbox">
					<label class="username" for="inputEmail">
						<span>Username or email</span>
						<input type="email" required="required" id="inputEmail" name="username" placeholder="Email" />
					</label>
					
					<label class="password">
						<span>Password</span>
						<input type="password" required="required" id="inputPassword" name="password" placeholder="Password"/>
					</label>
					
					<button style="margin: 0;" class="submit button" type="submit" name="login">Sign in</button>
				</fieldset>
			</form>
			<span style="color: white;font-weight: normal;font-size: 15px;">Forgot Password? Click <a href="../home/forgot-password.php" id="click_here">here!</a></span>
		</div>
	</div>