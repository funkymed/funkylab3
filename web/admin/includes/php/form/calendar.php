<?php

	$label=$Config['TABLEAU']['ITEM'][$key]['NAME']['VALUE'];
	$name=$Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']."_".$count;
	
	if($_POST["id"]=='new'){
		$value=date("Y-m-d");
	}else{
		$value=getContentItem($Table,$_POST["id"],$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'],$keyorder);
	}
	
	$tabHTML.="<label for=\"".$name."\">".$label." : </label>";
	$tabHTML.="<div class=\"field\">";
	$tabHTML.="<input id=\"".$name."\" name=\"".$name."\" type=\"text\" style=\"width:150px;\" value=\"".$value."\" /> <img alt=\"Calendar\" onclick=\"new CalendarDateSelect( $(this).previous(), {year_range:10} );\" src=\"images/calendar.gif\" style=\"border:0px; cursor:pointer;\" />";
	$tabHTML.="</div>";
	
	$tabHTML.="<div style=\"clear:both;height:10px;\"></div>";
?>