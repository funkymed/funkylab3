<?php

	$name=$Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']."_".$count;
	$value=date("Y-m-d H:i:s");
	if (isset($Config['TABLEAU']['ITEM'][$key]['CONDITION'])){
		if(isset($_POST["id"]) && $_POST["id"]!='new'){
			$value=getContentItem($Table,$_POST["id"],$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'],$keyorder);
			if ($value==$Config['TABLEAU']['ITEM'][$key]['CONDITION']['VALUE']){
				$value=date("Y-m-d H:i:s");
			}
		}
	}
	
	$tabHTML.="<input type=\"hidden\" value=\"".$value."\" id=\"".$name."\" name=\"".$name."\" />";
?>