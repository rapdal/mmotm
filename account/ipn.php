<?php
/**
 *  PHP-PayPal-IPN Example
 *
 *  This shows a basic example of how to use the IpnListener() PHP class to 
 *  implement a PayPal Instant Payment Notification (IPN) listener script.
 *
 *  For a more in depth tutorial, see my blog post:
 *  http://www.micahcarrick.com/paypal-ipn-with-php.html
 *
 *  This code is available at github:
 *  https://github.com/Quixotix/PHP-PayPal-IPN
 *
 *  @package    PHP-PayPal-IPN
 *  @author     Micah Carrick
 *  @copyright  (c) 2011 - Micah Carrick
 *  @license    http://opensource.org/licenses/gpl-3.0.html
 */
 
 
/*
Since this script is executed on the back end between the PayPal server and this
script, you will want to log errors to a file or email. Do not try to use echo
or print--it will not work! 

Here I am turning on PHP error logging to a file called "ipn_errors.log". Make
sure your web server has permissions to write to that file. In a production 
environment it is better to have that log file outside of the web root.
*/
ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');


// instantiate the IpnListener class
include('ipnlistener.php');
$listener = new IpnListener();


/*
When you are testing your IPN script you should be using a PayPal "Sandbox"
account: https://developer.paypal.com
When you are ready to go live change use_sandbox to false.
*/
$listener->use_sandbox = true;

/*
By default the IpnListener object is going  going to post the data back to PayPal
using cURL over a secure SSL connection. This is the recommended way to post
the data back, however, some people may have connections problems using this
method. 

To post over standard HTTP connection, use:
$listener->use_ssl = false;

To post using the fsockopen() function rather than cURL, use:
$listener->use_curl = false;
*/

/*
The processIpn() method will encode the POST variables sent by PayPal and then
POST them back to the PayPal server. An exception will be thrown if there is 
a fatal error (cannot connect, your server is not configured properly, etc.).
Use a try/catch block to catch these fatal errors and log to the ipn_errors.log
file we setup at the top of this file.

The processIpn() method will send the raw data on 'php://input' to PayPal. You
can optionally pass the data to processIpn() yourself:
$verified = $listener->processIpn($my_post_data);
*/
try {
    $listener->requirePostMethod();
    $verified = $listener->processIpn();
} catch (Exception $e) {
    error_log($e->getMessage());
    exit(0);
}


/*
The processIpn() method returned true if the IPN was "VERIFIED" and false if it
was "INVALID".
*/
if ($verified) {

    if ($_POST['payment_status'] != 'Completed') { 
        // simply ignore any IPN that is not completed
        exit(0); 
    }
	
	if ($_POST['receiver_email'] != 'uekigx@gmail.com') {
        $errmsg .= "'receiver_email' does not match: ";
        $errmsg .= $_POST['receiver_email']."\n";
    }
	
	if ($_POST['mc_currency'] != 'USD') {
        $errmsg .= "'mc_currency' does not match: ";
        $errmsg .= $_POST['mc_currency']."\n";
    }
	
	
	$payer_email = $_POST['payer_email'];
	$mc_gross = $_POST['mc_gross'];
	$mc_fee = $_POST['mc_fee'];
	
	mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
	mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database. 

	$result = mysql_query("SELECT * FROM Users WHERE email = '$payer_email'") or die(mysql_error());

	while($row = mysql_fetch_array($result))
	{
		$email = $row['email'];
		$fullName = $row['fullName'];
		$mmoTag = $row['mmoTag'];
		$country = $row['country'];
		$mmoPoints = $row['mmoPointBalance'];
		$divineSoulsActive = $row['keyActive'];
		$mmoPointBalance = $row['mmoPointBalance'] + ($mc_gross*125);
		
		$query_return = mysql_query("UPDATE Users SET mmoPointBalance='$mmoPointBalance' WHERE email='$payer_email'");
                
                if($query_return && ($anytv_transaction_id = $row['transaction_id']))
                {
                  $postback_url = "http://play.any.tv/aff_goal?a=lsr&goal_id=2&transaction_id=$anytv_transaction_id&amount=$mc_gross";
                  $postback_url_result = file_get_contents( $postback_url );  
                  unset($postback_url_result); // use for testing    
                }
	}
	mail($payer_email, 'VERIFIED IPN', $listener->getTextReport());
	
} else {
    /*
    An Invalid IPN *may* be caused by a fraudulent transaction attempt. It's
    a good idea to have a developer or sys admin manually investigate any 
    invalid IPN.
    */
    mail('uekigx@yahoo.com', 'Invalid IPN', $listener->getTextReport());
}

?>