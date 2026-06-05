<?php
	session_start();
	if(isset($_SESSION["cusUN"]))
	{
		unset($_SESSION["cusUN"]);
	}	
	header("Location: ./index.php");
?>
