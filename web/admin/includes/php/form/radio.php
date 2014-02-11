<?php

 	if($_POST["id"]=='new'){
		$value="N";
	}else{
		$value=getContentItem($Table,$_POST["id"],$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'],$keyorder);
	}
	
	$name		= $Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']."_".$count;
	$label		= $Config['TABLEAU']['ITEM'][$key]['NAME']['VALUE'];
	$radioValue	= explode(",",$Config['TABLEAU']['ITEM'][$key]['RADIOVALUE']['VALUE']);
	$radioName	= explode(",",$Config['TABLEAU']['ITEM'][$key]['RADIONAME']['VALUE']);
	$radioImg 	= isset($Config['TABLEAU']['ITEM'][$key]['RADIOIMG']) ? explode(",",$Config['TABLEAU']['ITEM'][$key]['RADIOIMG']['VALUE']) : 'N';
	
	
	$tabHTML.="<label for=\"".$name."\">".$label." : </label>";
	$tabHTML.="<div class=\"field\">";
	
	for ($inputV=0;$inputV<count($radioName);$inputV++){
		if ($radioValue[$inputV]==$value){
			$checked=" checked=\"checked\"";
		}else{
			$checked="";
		}
		
		$tabHTML.="<div style=\"float:left;border:0px red solid;\">";
		
		if ($radioImg!='N'){
			$tabHTML.="<label for=\"".$name.$inputV."\" style=\"text-align:center;\">";
		}else{
			$tabHTML.="<label for=\"".$name.$inputV."\" style=\"text-align:left;\">";
		}
		
		if ($radioImg!='N'){
			$tabHTML.="<img src=\"".$_POST["xmlfile"]."/images/".$radioImg[$inputV]."\" alt=\"\" /><br />";
		}
		$tabHTML.="<input type=\"radio\" id=\"".$name.$inputV."\" name=\"".$name."\" value=\"".$radioValue[$inputV]."\" style=\"width:20px\" style=\"border-width:0px;background:#fff;float:left;\" ".$checked."/>";
		if ($radioImg!='N'){
			$tabHTML.="<br />";
		}else{
			$tabHTML.="&nbsp;";
		}
		
		$tabHTML.=$radioName[$inputV]."</label>";
		$tabHTML.="</div>";
	}
	
	$tabHTML.="</div>";
	$tabHTML.="<div style=\"clear:both;height:10px;\"></div>";
	



?>