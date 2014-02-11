<?php

	session_start();
	
	if ($_POST['move']==1){
		$_SESSION["Funkylab3"][$_POST['tab']]['page']++;		
		if ($_SESSION["Funkylab3"][$_POST['tab']]['page']>$_POST['limit']-1){
			$_SESSION["Funkylab3"][$_POST['tab']]['page']=$_POST['limit']-1;
		}
	}else{
		$_SESSION["Funkylab3"][$_POST['tab']]['page']--;		
		if ($_SESSION["Funkylab3"][$_POST['tab']]['page']<0){
			$_SESSION["Funkylab3"][$_POST['tab']]['page']=0;
		}
	}
	
	echo "pagination : ok";

?>