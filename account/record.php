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

	<title>Record</title>

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
$business = $_POST['business'];
$cmd = $_POST['cmd'];
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$amount = $_POST['amount'];
$notify_url = $_POST['notify_url'];
$currency_code = $_POST['currency_code'];
$cancel_return = $_POST['cancel_return'];
$return = $_POST['return'];


				mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
				mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database. 

				$username = $_SESSION['userORM'];

				$result1 = mysql_query("SELECT * FROM Users WHERE email='$username'");

								while($row2 = mysql_fetch_array($result1))
								{
									$id_user = $row2['id'];
									echo $id_user;
								}

				mysql_query("INSERT INTO trans_hist(product,unit_price,user_id,qty,status) values('$item_name','$amount','$id_user','1','NOT PAID')");
$paypal_id='uekigx@gmail.com';
    
?>

	<head><script src="../js/paypal-button.min.js" type="text/javascript"></script></head>
<form action="<?php header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr');?>" method="post" name="frmPayPal1">
							<input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
							<input type="hidden" name="cmd" value="<?php echo $cmd;?>">
							<input type="hidden" name="item_name" value="<?php echo $item_name;?>">
							<input type="hidden" name="item_number" value="<?php echo $item_number;?>">
							<input type="hidden" name="amount" value="<?php echo $$amount;?>">
							<input type="hidden" name="notify_url" value="<?php echo $notify_url;?>" />
							<input type="hidden" name="currency_code" value="<?php echo $currency_code;?>">
							<input type="hidden" name="cancel_return" value="<?php echo $cancel_return;?>">
							<input type="hidden" name="return" value="http://mmo.tm/account/success.php">
						</form>