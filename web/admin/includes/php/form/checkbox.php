<?php

 	if($_POST["id"]=='new'){
		$value="N";
	}else{
		$value=getContentItem($Table,$_POST["id"],$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'],$keyorder);
	}
	
	if ($value=='Y'){
		$check=" checked=\"checked\"";
	}else{
		$check="";
	}
	
	$name=$Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']."_".$count;
	$label=$Config['TABLEAU']['ITEM'][$key]['NAME']['VALUE'];
	
	$tabHTML.="<label for=\"".$name."\">".$label." : </label>";
	$tabHTML.="<div class=\"field\">";
	$tabHTML.="<input type=\"checkbox\" id=\"".$name."\" name=\"".$name."\" ".$check." style=\"width:20px\" style=\"border-width:0px;background:#fff;\" />";
	$tabHTML.="</div>";
	$tabHTML.="<div style=\"clear:both;height:10px;\"></div>";
	

?>