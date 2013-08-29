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
$actionType = "PAY";
$cancelUrl = "http://mmo.tm/account/account.php"; // TODO - If you are not executing the Pay call 
                                    // for a preapproval, then you must set a valid
                                    // cancelUrl for the web approval flow that 
                                    // immediately follows this Pay call
$returnUrl = "http://mmo.tm/account/purchase.php"; // TODO - If you are not executing the Pay call 
                                    // for a preapproval, then you must set a valid
                                    // returnUrl for the web approval flow that 
                                    // immediately follows this Pay call
$currencyCode = "USD";

// A basic payment has 1 receiver.
// TODO - specify the receiver email
$receiverEmailArray = array(
	'paypal@any.tv'
 );

// TODO - specify the receiver amount as the amount of money, for example, '5' or '5.55'
$amount = $_POST["amount"];
$receiverAmountArray = array(
	$amount
);

// For basic payment, no primary indicators are needed, so set empty array.
$receiverPrimaryArray = array();

// TODO - Set invoiceId to uniquely identify the transaction associated with the receiver
//  You can set this to the same value as trackingId if you wish
$receiverInvoiceIdArray = array();

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
				   
$feesPayer = "";
$ipnNotificationUrl = "";
$memo = ""; // maxlength is 1000 characters
$pin = ""; // TODO - If you are executing the Pay call against an 
           // existing preapproval that requires a pin, then you 
           // must set this
$reverseAllParallelPaymentsOnError = ""; // Do not specify for basic payment
$trackingId = generateTrackingID(); // generateTrackingID function is 
                                    // found in paypalplatform.php

//-------------------------------------------------
// Make the Pay API call
//
// The CallPay function is defined in the paypalplatform.php file,
// which is included at the top of this file.
//-------------------------------------------------
$resArray = CallPay ($actionType, $cancelUrl, $returnUrl, $currencyCode, 
      $receiverEmailArray, $receiverAmountArray, $receiverPrimaryArray, 
      $receiverInvoiceIdArray, $feesPayer, $ipnNotificationUrl, $memo, 
      $pin, $preapprovalKey, $reverseAllParallelPaymentsOnError, 
      $senderEmail, $trackingId
);

$ack = strtoupper($resArray["responseEnvelope.ack"]);
if($ack=="SUCCESS")
{
 if ("" == $preapprovalKey)
 {
  // redirect for web approval flow
  $_SESSION['payKey'] = urldecode($resArray["payKey"]);
  $_SESSION['amount'] = $_POST['amount'];
  $cmd = "cmd=_ap-payment&paykey=" . urldecode($resArray["payKey"]);
  RedirectToPayPal ( $cmd );
 }
 else
 {
	echo '<h2>Thank you for purchasing.</h2><br/>Redirecting...';
	
	$ItemName = "mmoPointBalance";
	$ItemTotalPrice = $_POST['amount'];
	$result = mysql_query("SELECT * FROM Users WHERE email = '$email'") or die(mysql_error());


	while($row = mysql_fetch_array($result))
	{
		$user_id = $row['id'];
		$email = $row['email'];
		$fullName = $row['fullName'];
		$mmoTag = $row['mmoTag'];
		$country = $row['country'];
		$divineSoulsActive = $row['keyActive'];
		
		switch($ItemTotalPrice){
			case '2.89':
				$mmoPointBalance =$row['mmoPointBalance']+390;
				break;
			case '4.89':
				$mmoPointBalance = $row['mmoPointBalance']+625;
				break;
			case '9.89':
				$mmoPointBalance = $row['mmoPointBalance']+1240;
				break;
			case '19.89':
				$mmoPointBalance = $row['mmoPointBalance']+2540;
				break;
			case '29.89':
				$mmoPointBalance = $row['mmoPointBalance']+4200;
				break;
			default:
				break;
		}
		
		$query_return = mysql_query("UPDATE Users SET mmoPointBalance='$mmoPointBalance' WHERE email='$email'") or die(mysql_error());
				
		if($query_return && ($anytv_transaction_id = $row['transaction_id']))
		{
		  $postback_url = "http://play.any.tv/aff_goal?a=lsr&goal_id=2&transaction_id=$anytv_transaction_id&amount=$ItemTotalPrice";
		  $postback_url_result = file_get_contents( $postback_url );  
		  unset($postback_url_result); // use for testing    
		}
		
		$result_or = mysql_query("SELECT * FROM trans_hist WHERE user_id = '$user_id'") or die(mysql_error());
		while($row_or = mysql_fetch_array($result_or))
		{
			$order_num = $row_or['order_num'];
		}
		
		mysql_query("INSERT INTO trans_hist(product,unit_price,user_id,qty) values('$ItemName','$ItemTotalPrice','$user_id','1')") or die(mysql_error());
		mysql_query("INSERT INTO balance_hist(user_id,ordernum,product,amount,balance) values('$user_id','$order_num','$ItemName','$ItemTotalPrice','$mmoPointBalance')") or die(mysql_error());
	}
	  // payKey is the key that you can use to identify the payment resulting 
	  // from the Pay call.
	  $payKey = urldecode($resArray["payKey"]);
	  // paymentExecStatus is the status of the payment
	 $paymentExecStatus = urldecode($resArray["paymentExecStatus"]);
	 
	 echo "<meta http-equiv='refresh' content='3;url=http://mmo.tm/account/account.php'>";
 }
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