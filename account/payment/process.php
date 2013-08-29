<?php
session_start();
include_once("config.php");
include_once("paypal.class.php");

if($_POST) //Post Data received from product list page.
{
    //Mainly we need 4 variables from an item, Item Name, Item Price, Item Number and Item Quantity.
    $ItemName = "mmoPointBalance";
    $ItemPrice = $_POST["amount"]; //Item Price
    $ItemNumber = $_POST["itemnumber"]; //Item Number
    $ItemQty = 1; //Item Quantity
    $ItemTotalPrice = ($ItemPrice*$ItemQty); //(Item Price x Quantity = Total) Get total amount of product;

    //Data to be sent to paypal
    $padata =   '&CURRENCYCODE='.urlencode($PayPalCurrencyCode).
                '&PAYMENTACTION=Sale'.
                '&ALLOWNOTE=1'.
                '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
                '&PAYMENTREQUEST_0_AMT='.urlencode($ItemTotalPrice).
                '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
                '&L_PAYMENTREQUEST_0_QTY0='. urlencode($ItemQty).
                '&L_PAYMENTREQUEST_0_AMT0='.urlencode($ItemPrice).
                '&L_PAYMENTREQUEST_0_NAME0='.urlencode($ItemName).
                '&L_PAYMENTREQUEST_0_NUMBER0='.urlencode($ItemNumber).
                '&AMT='.urlencode($ItemTotalPrice).
                '&RETURNURL='.urlencode($PayPalReturnURL ).
                '&CANCELURL='.urlencode($PayPalCancelURL);

        //We need to execute the "SetExpressCheckOut" method to obtain paypal token
        $paypal= new MyPayPal();
        $httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

        //Respond according to message we receive from Paypal
        if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
        {

                // If successful set some session variable we need later when user is redirected back to page from paypal.
                $_SESSION['itemprice'] =  $ItemPrice;
                $_SESSION['totalamount'] = $ItemTotalPrice;
                $_SESSION['itemName'] =  $ItemName;
                $_SESSION['itemNo'] =  $ItemNumber;
                $_SESSION['itemQTY'] =  $ItemQty;

                if($PayPalMode=='sandbox')
                {
                    $paypalmode     =   '.sandbox';
                }
                else
                {
                    $paypalmode     =   '';
                }
                //Redirect user to PayPal store with Token received.
                $paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
                header('Location: '.$paypalurl);

        }else{
            //Show error message
            echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
        }

}

//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
if(isset($_GET["token"]) && isset($_GET["PayerID"]))
{
    //we will be using these two variables to execute the "DoExpressCheckoutPayment"
    //Note: we haven't received any payment yet.

    $token = $_GET["token"];
    $playerid = $_GET["PayerID"];

    //get session variables
    $ItemPrice      = $_SESSION['itemprice'];
    $ItemTotalPrice = $_SESSION['totalamount'];
    $ItemName       = $_SESSION['itemName'];
    $ItemNumber     = $_SESSION['itemNo'];
    $ItemQTY        =$_SESSION['itemQTY'];

    $padata =   '&TOKEN='.urlencode($token).
                        '&PAYERID='.urlencode($playerid).
                        '&PAYMENTACTION='.urlencode("SALE").
                        '&AMT='.urlencode($ItemTotalPrice).
                        '&CURRENCYCODE='.urlencode($PayPalCurrencyCode);

    //We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
    $paypal= new MyPayPal();
    $httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

    //Check if everything went ok..
    if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
    {
		echo '<h2>Thank you for purchasing.</h2><br/><br/>Redirecting...';


		$transactionID = urlencode($httpParsedResponseAr["TRANSACTIONID"]);
		$nvpStr = "&TRANSACTIONID=".$transactionID;
		$paypal= new MyPayPal();
		$httpParsedResponseAr = $paypal->PPHttpPost('GetTransactionDetails', $nvpStr, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

	
		mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
		mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database. 
		
		$email = $_SESSION['userORM'];
		
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
			
			$query_return = mysql_query("UPDATE Users SET mmoPointBalance='$mmoPointBalance' WHERE email='$email'");
					
			if($query_return && ($anytv_transaction_id = $row['transaction_id']))
			{
			  $postback_url = "http://play.any.tv/aff_goal?a=lsr&goal_id=2&transaction_id=$anytv_transaction_id&amount=$ItemTotalPrice";
			  $postback_url_result = file_get_contents( $postback_url );  
			  unset($postback_url_result); // use for testing    
			}
			
			$result_or = mysql_query("SELECT * FROM trans_hist WHERE user_id = '$user_id'");
			while($row_or = mysql_fetch_array($result_or))
			{
				$order_num = $row_or['order_num'];
			}
			
			mysql_query("INSERT INTO trans_hist(product,unit_price,user_id,qty) values('$ItemName','$ItemTotalPrice','$user_id','1')");
			mysql_query("INSERT INTO balance_hist(user_id,ordernum,product,amount,balance) values('$user_id','$order_num','$ItemName','$ItemTotalPrice','$mmoPointBalance')");
		}

		echo "<meta http-equiv='refresh' content='0;url=http://mmo.tm/account/account.php'>";

    }else{
            echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
    }
}
?>