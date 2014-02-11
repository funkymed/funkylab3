<?php
	if($_POST["id"]=='new'){
		$value="";
	}else{
		$value=strip_tags(getContentItem($Table,$_POST["id"],$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'],$keyorder));
	}
	$name=$Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']."_".$count;
	$label=$Config['TABLEAU']['ITEM'][$key]['NAME']['VALUE'];
	
	$tabHTML.="<label for=\"".$name."\">".$label." : </label>";
	
	$tabHTML.="<div class=\"field\">";
	$tabHTML.="<input type=\"text\" value=\"".$value."\" id=\"".$name."\" name=\"".$name."\" onfocus=\"focused(this);\" onblur=\"blurred(this);\" />";
	$tabHTML.="</div>";
	$tabHTML.="<div style=\"clear:both;height:10px;\"></div>";

?>