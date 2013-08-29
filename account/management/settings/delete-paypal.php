<?php 
	session_start();

if(!isset($_SESSION['userORM'])){
	header("Location: http://mmo.tm/divinesouls");
}


		mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
		mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database. 
	
		if($_GET['id']!=""){
		$user=$_SESSION['userORM'];
		$paypal_email = $_GET['id'];
		$sql = "DELETE FROM paymentMethod WHERE email='$user' AND paypal_email ='$paypal_email'";
		mysql_query($sql);
		
		echo "<meta http-equiv='refresh' content='0;url=http://mmo.tm/account/management/settings/payment-options.php'>";
		}
?>