<?php 
include '../includes/_header.php'; 
?>

<div id="signup">

    <div id="header-wrapper" style="height: 50px;">
		<div id="header" style="text-align:center; position:relative;">
			<?php include '../includes/_menu.php'; ?>
		</div>

		
	<script>
	<?php
	if(isset($_SESSION['error'])){
		echo "alert('".$_SESSION['error']."')"; 
		unset($_SESSION['error']);
	}
	?>
	</script>

		<div style="padding: 20px 0 10px;">
		</div>
	</div><!--herder-wrapper-->   
        <div id="content">
            
            <div class="two-col self-clear">
                <div class="col-1">
                    <div id="intro">
						<div id="tab-signup">
							<div id="tabs-s">
								<ul>
									<li><a class="tab-selected" href="#tabs-1">Fighter</a></li>
									<li><a href="#tabs-2">Mage</a></li>
									<li><a href="#tabs-3">Priest</a></li>
									<li><a href="#tabs-4">Slasher</a></li>
								</ul>
								<div class="tab" id="tabs-1">
									<iframe width="100%" height="315" src="//youtube.com/embed/tr6e9LwyRtw" frameborder="0" allowfullscreen></iframe>
									<br /> <br />
								</div>
								<div class="tab" id="tabs-2">
									<iframe width="100%" height="315" src="//youtube.com/embed/vVfvRvPVNZA" frameborder="0" allowfullscreen></iframe>
									<br /> <br />
								</div>
								<div class="tab" id="tabs-3">
									<iframe width="100%" height="315" src="//youtube.com/embed/nEvs5Gbm0AA" frameborder="0" allowfullscreen></iframe>
									<br /> <br />
								</div>
								<div class="tab" id="tabs-4">
									<iframe width="100%" height="315" src="//youtube.com/embed/bKF3Mlxb7As" frameborder="0" allowfullscreen></iframe>
									<br /> <br />
								</div>
							</div>
						</div>
                    </div>
                </div>
                
                <div class="col-2">
					<img class="col-2-img" src="images/no_monthly.png" />
                    <div></div>
                    <div>

                        <div id="signup-form">
                            <img src="images/get_in.png" alt="Get in the fray" />
                            <br />
                            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                                <label>Full Name</label>
                                <input id="txtfullname" required="required" class="rounded-textbox" type="text" name="fullName_s" /><br />
                                <label>Email Address</label>
                                <input id="txtusername" required="required" class="rounded-textbox" type="email" name="username_s" /><br />
                                <label>Password</label>
                                <input id="txtpassword" required="required" class="rounded-textbox" type="password" name="pass_s" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="include at least 1 small letter, 1 capital letter and 1 number with the minimum length of 8 characters" required/><br />
                                <label>Confirm Password</label>
                                <input id="txtconfirm" required="required" class="rounded-textbox" type="password" name="pass2_s" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="include at least 1 small letter, 1 capital letter and 1 number with the minimum length of 8 characters" required/><br />
                                <label>Date of Birth</label>
                                <input id="txtdob" required="required" placeholder="mm/dd/yyyy" class="rounded-textbox" type="text" name="DOB_s" /><br />
                                <label>Beta Experience</label>
								<input type="hidden" name="betaExperience_s" value="No" />
                                <input id="txtbetaexp" type="checkbox" name="betaExperience_s" value="Yes" /><br />
                                <label>Divine Souls Experience</label>
								<input type="hidden" name="dsExperience_s" value="No" />
                                <input id="txtdsexp" type="checkbox" name="dsExperience_s" value="Yes" /><br />

                                <button type="submit" class="btn btn-link submit" name="submit"><img src="images/next.png" /></button>
                            </form>
                        </div>
                    </div>
                    <div></div>
                </div>
            </div>
        </div>            
		<?php include '../includes/_footer.php'; ?>