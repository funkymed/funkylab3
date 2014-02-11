<?php
	$label=$Config['TABLEAU']['ITEM'][$key]['NAME']['VALUE'];
	$name=$Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']."_".$count;
	if($_POST["id"]=='new'){
		$value=date("Y-m-d h:i");
		if (date("H")>12){
			$value.=" PM";
		}else{
			$value.=" AM";
		}
	}else{
		$value=getContentItem($Table,$_POST["id"],$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'],$keyorder);
		$valueTMP=explode(" ",$value);
		$valueTMP_Day=$valueTMP[0];
		$valueTMP_Hour=explode(":",$valueTMP[1]);
		if ($valueTMP_Hour[0]>12){
			$CODE_hour=" PM";
			$valueTMP_Hour[0]-=12;
		}else{
			$CODE_hour=" AM";
		}
		$value=$valueTMP_Day." ".$valueTMP_Hour[0].":".$valueTMP_Hour[1]." ".$CODE_hour;
	}
	$tabHTML.="<label for=\"".$name."\">".$label." : </label>";
	$tabHTML.="<div class=\"field\">";
	$tabHTML.="<input id=\"".$name."\" name=\"".$name."\" type=\"text\" style=\"width:150px;\" value=\"".$value."\" />";
	$tabHTML.=" <img alt=\"Calendar\" onClick=\"new CalendarDateSelect( $('".$name."'), {time:true,year_range:10});\" src=\"images/calendar.gif\" style=\"border:0px; cursor:pointer;\" />";
	$tabHTML.="</div>";
	$tabHTML.="<div style=\"clear:both;height:10px;\"></div>";
?>
