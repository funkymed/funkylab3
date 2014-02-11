<?php
	$label=$Config['TABLEAU']['ITEM'][$key]['NAME']['VALUE'];
	$name=$Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']."_".$count;
	
	if($_POST["id"]=='new'){
		$value="000000";
	}else{
		$value=getContentItem($Table,$_POST["id"],$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'],$keyorder);
	}
	
	$tabHTML.="<label for=\"".$name."\">".$label." : </label>";
	$tabHTML.="<div class=\"field\" class=\"buttons\">";
	
	$tabHTML.="#<input type=\"text\" id=\"".$name."\" name=\"".$name."\" value=\"".$value."\" style=\"width:55px;\" />";
	
	$tabHTML.="<button type=\"button\"  id=\"colorbox".$name."\" style=\"height:22px;border:2px gray solid;\">";
	$tabHTML.="changer de couleur";
	$tabHTML.="</button>";

	$tabHTML.="</div>";
	$tabHTML.="<div style=\"clear:both;height:10px;\"></div>";
	
	$tabHTML.="<script type=\"text/javascript\">";
	$tabHTML.="new Control.ColorPicker('".$name."', { 'swatch' : 'colorbox".$name."' });";
	
	$tabHTML.="</script>";

?>