
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

		mysql_connect("localhost", "root", "") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
		mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database. 

		$password = md5($password);

		$result = mysql_query("SELECT * FROM Users WHERE email = '$username' AND password = '$password'") or die(mysql_error());


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
	}
}

if(!isset($_SESSION['error'])){
	//This code runs if the form has been submitted
	if (isset($_POST['username_s']) && isset($_POST['pass_s'])) { 
	 
		 // Connects to your Database 
		 mysql_connect("localhost", "root", "") or die(mysql_error()); 
		 mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); 

		// checks if the username is in use
		$usercheck = $_POST['username_s'];
		$check = mysql_query("SELECT email FROM Users WHERE email = '$usercheck'") or die(mysql_error());
		$check2 = mysql_num_rows($check);

		 //if the name exists it gives an error
		 if ($check2 != 0) {
			$_SESSION['error'] = "Sorry, the email is already in use.";
		}

		// this makes sure both passwords entered match
		if ($_POST['pass_s'] != $_POST['pass2_s']) {
			$_SESSION['error'] = "Password does not match.";
		}

		// create activation hash
		$hash = md5( rand(0,1000) );

		// now we insert it into the database
		$anytv_transaction_id = '';
		if(isset($_SESSION['anytv_transaction_id']))
		{
			$anytv_transaction_id = $_SESSION['anytv_transaction_id'];
		}
		
		
		if(!isset($_SESSION['error'])){
			$pass_s = md5($_POST['pass_s']);
		
			$insert = "INSERT INTO Users (email, password, fullName, betaExperience, dsExperience, DOB, verifyHash, keyAssigned, mmoTag, transaction_id) 
				VALUES ('".$_POST['username_s']."', '$pass_s', '".$_POST['fullName_s']."', '".$_POST['betaExperience_s']."', '".$_POST['dsExperience_s']."', '".$_POST['DOB_s']."', '$hash', '', '', '$anytv_transaction_id')";
			$add_member = mysql_query($insert) or die(mysql_error());;
		
		
			// postback to dashboard for conversion
			if($anytv_transaction_id)
			{
			  $postback_url = "http://play.any.tv/aff_lsr?offer_id=296&transaction_id=$anytv_transaction_id";
			  $postback_url_result = file_get_contents( $postback_url );  
			  unset($postback_url_result); // use for testing
			  
			  if(isset($_SESSION['anytv_transaction_id']))
			  {
				unset($_SESSION['anytv_transaction_id']);
			  }
			}
			
			if(!$add_member)
			{
				$_SESSION['error'] = "An error occurred. Please try again.";
			}else{
				header("Location: http://localhost/divinesouls.tm/submit-beta-signup.php");
			}
	
			
		}
	}
}
?>

<div id="arch" >
	<span id="brand">
		<a id="emblem" href="http://localhost/mmo.tm/home"><img src="/mmo.tm/images/mmoTM.png"/></a>
	</span>
	<span id="guide">
		<p style="margin-left: 55px;"><a class="login-window" href="
		<?php
		if(isset($_SESSION['userORM'])){
			echo "http://localhost/mmo.tm/account/account.php?view=4";
		}else{
			echo "#login-box";
		}
		?>
		">My Account</a></p>
		<p><a href="http://divinesouls.mmo.tm/forum">Forums</a>	</p>
		<p><a href="http://localhost/mmo.tm/divinesouls/guides.php">Guides</a>	</p>
		<p><a href="http://localhost/mmo.tm/divinesouls/media.php">Media</a>	</p>
	</span>
	
	<span id="access">
	
		<?php	if(!isset($_SESSION['userORM'])) { ?>
			
			<a id="accessin" href="/mmo.tm/divinesouls/signup.php"><img style="border-radius: 3px; margin-right: 2px;" src="images/sign-up2.png"/></a>
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
					<li><a href="/mmo.tm/account/purchase.php" target="_blank">Charge mmoPoints</a></li>
					<li><a href="/mmo.tm/account/logout.php">Logout</a></li>
				</ul>
			</div>


		<?php	} ?>
	</span>
	<span style="float: left; position:absolute; " >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

	<div id="login-box" class="login-popup" style="background-image: url('../divinesouls/images/bg-ds.jpg'); background-position: center center; repeat: no-repeat; height: 183px; color: orange; text-size: 250%; font-weight: bold; border: 0px;">
		<a href="#" class="close"><img src="../divinesouls/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
		<form method="post" class="signin" action="<?php $_SERVER['PHP_SELF'] ?>">
			<fieldset class="textbox">
			<label class="username" for="inputEmail">
			<span>Username or email</span>
			<input type="email" required="required" id="inputEmail" name="username" placeholder="Email" />
			</label>
			
			<label class="password">
			<span>Password</span>
			<input type="password" required="required" id="inputPassword" name="password" placeholder="Password" />
			</label>
			
			<button style="margin: 0;" class="submit button" type="submit" name="login">Sign in</button>
			</fieldset>
		</form>
		<span style="color: white;font-weight: normal;font-size: 15px;">Forgot Password? Click <a href="/mmo.tm/home/forgot-password.php" id="click_here">here!</a></span>
	</div>
</div>