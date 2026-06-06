<?php
	session_start();
	if(isset($_SESSION["comUN"]))
	{
		unset($_SESSION["comUN"]);
		header("Location: ./index.php");
	}	
	elseif(isset($_SESSION["truckNo"]))
	{
		unset($_SESSION["truckNo"]);
		header("Location: ./truckLogin.php");
	}
	
?>
