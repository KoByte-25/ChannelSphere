<?php
	session_start();
	if(isset($_SESSION["comUN"]))
	{
		unset($_SESSION["comUN"]);
	}	
	header("Location: ./index.php");
?>
