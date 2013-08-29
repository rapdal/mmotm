<?php 
session_start();

if(isset($_SESSION['userORM'])){
	unset($_SESSION['userORM']);
}

header("Location: ".$_SERVER['HTTP_REFERER']);
 ?>