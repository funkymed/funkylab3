<?php

	include "../../../includes/php/bddconf.php";
	print_r($_POST);	
	$dragID = $_POST['drag_id'];
	$dropID = $_POST['drop_id'];
	if (ifItChild($dragID,$dropID)){
		echo "attention enfant";
	}else{
		$query="UPDATE page SET parent=".$dropID." WHERE id=".$dragID;
		$res=mysql_query($query);
	}
	
	function ifItChild($child,$parent,$value=false){
		if ($value==true){
			return true;
		}
		$checkRES=mysql_query("SELECT parent,titre FROM page WHERE id=".$parent);
		while ($resROW = mysql_fetch_array($checkRES)) {
			//print $resROW['parent']."==".$child."\n";
			if ($resROW['parent']==$child){
				return true;
			}else{
				$value=ifItChild($child,$resROW['parent'],$value);
			}
		}
		return $value;
	}
?>