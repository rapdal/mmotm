<?php

//-------------------------------------------------
// When you integrate this code,
// look for TODO as an indication
// that you may need to provide a value or take 
// action before executing this code.
//-------------------------------------------------
require_once ("paypalplatform.php");

$email = $_SESSION['userORM'];

// ==================================
// PayPal Platform Basic Payment Module
// ==================================

// Request specific required fields

// Request specific optional or conditionally required fields
//   Provide a value for each field that you want to include in the request; 
//   If left as an empty string, the field will not be passed in the request

// TODO - If you are executing the Pay call against a 
                   // preapprovalKey, you should set senderEmail
                   // It is not required if the web approval flow immediately 
                   // follows this Pay call
mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database. 

$result = mysql_query("SELECT * FROM paymentMethod WHERE email='$email'");

if(mysql_num_rows($result) != 0)
{
	while($row = mysql_fetch_array($result))
	{
		$senderEmail = $row['paypal_email'];
		$preapprovalKey = $row['paypal_key'];
	}
}else{
	$senderEmail = "";
	$preapprovalKey = ""; 
}
				  

//-------------------------------------------------
// Make the Pay API call
//
// The CallPay function is defined in the paypalplatform.php file,
// which is included at the top of this file.
//-------------------------------------------------
$resArray = CallCancelPreapproval ($preapprovalKey
);

$ack = strtoupper($resArray["responseEnvelope.ack"]);
if($ack=="SUCCESS")
{
	mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
	mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database. 

	$user=$_SESSION['userORM'];
	$sql = "DELETE FROM paymentMethod WHERE email='$user'";
	mysql_query($sql);
	
	echo "<meta http-equiv='refresh' content='0;url=http://mmo.tm/account/management/settings/payment-options.php'>";
} 
else  
{
	 //Display a user-friendly Error on the page using any of the following 
	 //error information returned by PayPal.
	 //TODO - There can be more than 1 error, so check for "error(1).errorId", 
	 //       then "error(2).errorId", and so on until you find no more errors.
	 $ErrorCode = urldecode($resArray["error(0).errorId"]);
	 $ErrorMsg = urldecode($resArray["error(0).message"]);
	 $ErrorDomain = urldecode($resArray["error(0).domain"]);
	 $ErrorSeverity = urldecode($resArray["error(0).severity"]);
	 $ErrorCategory = urldecode($resArray["error(0).category"]);
	 
	 echo "Preapproval API call failed. ";
	 echo "Detailed Error Message: " . $ErrorMsg;
	 echo "Error Code: " . $ErrorCode;
	 echo "Error Severity: " . $ErrorSeverity;
	 echo "Error Domain: " . $ErrorDomain;
	 echo "Error Category: " . $ErrorCategory;
}
?>