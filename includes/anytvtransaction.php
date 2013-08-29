<?php

session_start();

if(isset($_GET['anytv_transaction_id']) && ($transaction_id = $_GET['anytv_transaction_id']))
{
  $_SESSION['anytv_transaction_id'] = $transaction_id;
}

?>
