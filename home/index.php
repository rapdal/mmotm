<?php 
include("../includes/_header.php");
?>
<div class = "bg1 bg2">
	<div id="vessel">
		<?php include("../includes/_menu.php"); ?>
		<div id="seek" >
			<span id="scout1" >
				<form action="http://localhost/mmo.tm/account/account.php?view=1" method="#" >
					<input id="submitmgmt2" type="submit" value="" name="submit" />
					<input id="submitmgmtsearch" type="text" placeholder="Search" id="pass" required/>
				</form>
			</span>
		</div>
		
		<div id="administer">
			<div id="exec">
				<table id="desk" border="0" cellspacing="1px">
					<tr>
						<th rowspan="2"><img src="../css/gfx/manage-my-game.png"></th>
						<td id="mng_game" style="font-family: 'Russo One';>
						<font-size: 14px; color:#c93a2a;font-weight:0%;">Manage my game</font>
						</td>
					</tr>
					<tr>
						<td><a href="http://localhost/mmo.tm/account/account.php?view=4"> Go to Account Management &#9654; </a>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div id="halfway">
			<span id="hwleft">
				<img src="../images/cominleft.png"/>
			</span>
			<span id="hwcenter">
				<a href="http://localhost/mmo.tm/divinesouls"><img src="../images/cominmid.png"/></a>
			</span>
			<span id="hwright">
				<img src="../images/cominright.png"/>
			</span>
		</div>
		
		<div class="content-wrap" style="margin-top:85px;">
		<div id="pre_footer">
			<div id="supplinks"><p>Support</p>
				<p id="cantlog"><a href="http://www.mmo.tm/divinesouls/forum">Forum Support</a><br/>
				<a href="mailto:sheldon@any.tv?Subject=Help" target="_top">Help!</a><br/>
			</div>
			<div id="acchead"></p>Account</p>
				<p id="cantlog"><a href="mailto:sheldon@any.tv?Subject=Can't%20Login" target="_top">Can't log in?</a><br/>
				<a href="http://www.mmo.tm/divinesouls/signup.php">Create Account</a><br/>
				<a href="http://www.mmo.tm/account/account.php?view=1">Account Summary</a><br/>
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