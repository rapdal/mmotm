<?php

    mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); // Connect to database server(localhost) with username and password.  
    mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error()); // Select registration database.  

    //register variables
    $ItemSumCash = 0;		// total purchases
    $DB_itemprice = 0;		// price per item

    $balance = "";
    $update = "";
    $email = "";
    $salt ="";

    //register POST into variables
    $update = $_GET['update'];
    $account = $_GET['account'];

    $tempitemID = $_GET['Itemid'];
    $tempitemcash = $_GET['ItemCash'];
    $input_itemID = explode('|', $tempitemID);
    $input_itemCash = explode('|', $tempitemcash);

    $salt = $_GET['salt'];

    //query balance

    if($_GET['action'] == 1) {
        $data = mysql_query("SELECT email, mmoPointBalance FROM Users WHERE id='".$account."' && verifyActive='1'") or die(mysql_error());  
        $info = mysql_fetch_array($data);
        echo $info['email'] . ":";
        echo $info['mmoPointBalance'];
        
    }

    //update balance
    if($_GET['action'] == 2) {
        $data = mysql_query("SELECT email, mmoPointBalance FROM Users WHERE id='".$account."' && verifyActive='1'") or die(mysql_error());  
        $info = mysql_fetch_array($data);

        $balance = $info['mmoPointBalance'] + $update;
        $email = $info['email'];

        mysql_query("UPDATE Users SET mmoPointBalance='$balance' WHERE email='$account'");

        echo $info['email'] . ":";
		echo $balance;
        //echo $balance . ":";
        //echo $salt;

    }

	// purchase an item
    if($_GET['action'] == 3) {
    
        $x = 0;		// counter for number of items to purchase
        $uID = mysql_query("SELECT * from Users WHERE id = '".$account."'");
        $row = mysql_fetch_array($uID);

		// confirm user validity 
        if(mysql_num_rows($uID)){
			$UserCash = $row['mmoPointBalance'];
			
			foreach($input_itemID as $itemID){
				
				if($itemID > 0){ // check if item exists
					mysql_query("INSERT INTO giftbox(userID,itemID) VALUES ('$account','$itemID')");

					$checkitem = mysql_query("SELECT * from ds_cashitemlist WHERE Status = 1 and BuyCostCash > 0 and CashItemID = $itemID");
					$row1 = mysql_fetch_array($checkitem);
					
					if(mysql_num_rows($checkitem)){ // check if price posted is different from what is in the db
						if($row1['DiscountCostCash'] > 0){
							if($row1['DiscountCostCash'] == $input_itemCash[$x]){
								$DB_itemprice = $row1['DiscountCostCash'];
							}
							else{
								echo "400";
							}
						}
						else{
							if($row1['BuyCostCash'] == $input_itemCash[$x]){
								$DB_itemprice = $row1['BuyCostCash'];
							}
							else{
								echo "400";
							}
						}

						if($DB_itemprice == $input_itemCash[$x]){
							$ItemSumCash = $ItemSumCash + $DB_itemprice;
						}
						else{
							echo "400";
						}
					}
					else{
						echo "200"; // non-existing item
					}
				}
			
				$x++;
			}
			

			if($UserCash < $ItemSumCash){
				echo "300";	// lack of balance
			}
			else{	// SUCCESS
				$BeforeUserCash = $UserCash - $ItemSumCash; 
				mysql_query("UPDATE Users SET mmoPointBalance = '".$BeforeUserCash."' WHERE id='".$account."'");
				echo "0,".$BeforeUserCash;  
				//echo $salt; 
			}
		}
		else{
			echo "100";   // non-existing user
		}
    }
?>