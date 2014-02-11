<?php

	session_start();
	
	$_SESSION["Funkylab3"][$_POST['tab']]['page']=$_POST['goto'];
	
	echo "pagination : ok";

?>