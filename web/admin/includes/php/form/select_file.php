<?php
	$timecode = round(microtime(true)*1000);
	if($_POST["id"]=='new'){
		$value="";
		$defaultValue="aucun fichier";
	}else{
		$value=getContentItem($Table,$_POST["id"],$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'],$keyorder);
		$valueTMP=explode("/",$value);
		if (count($valueTMP)>1){
			$defaultValue=$valueTMP[count($valueTMP)-1];
		}else{
			$defaultValue=$value;
		}
	}
	
	if (isset($Config['TABLEAU']['ITEM'][$key]['VALIDEXT'])){
		$validext=$Config['TABLEAU']['ITEM'][$key]['VALIDEXT']['VALUE'];
	}else{
		$validext="";
	}
	if(!is_file("../../../directory/".$value)){
		$value="";
	}
	
	$name=$Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']."_".$count;
	$label=$Config['TABLEAU']['ITEM'][$key]['NAME']['VALUE'];
	$tabHTML.="<input type=\"hidden\" value=\"".$value."\" id=\"".$name."\" name=\"".$name."\" />";
	$tabHTML.="<label for=\"".$name."\">".$label." : </label>";
	$tabHTML.="<div class=\"field\">";
	$tabHTML.="<div id=\"filemanager_".$timecode."\"></div>";
	$tabHTML.="<div id=\"upload_".$timecode."\"></div>";
	$tabHTML.="</div>";
	
	$tabHTML.="<div style=\"clear:both;height:10px;\"></div>";
	$tabHTML.="<script type=\"text/javascript\">";
	

	$previewForm = (isset($Config['TABLEAU']['ITEM'][$key]['PREVIEWFORM']) &&  $Config['TABLEAU']['ITEM'][$key]['PREVIEWFORM']['VALUE']=='Y') ? "true" : "false";
	
	
	$tabHTML.="
		_SelectFile".$timecode."=new SelectFile({
			SourceObjName:'_SelectFile".$timecode."',
			DivId:'filemanager_".$timecode."',
			InputId:'".$name."',
			ValidExtension:'".$validext."',
			SourceDir:'directory/',
			FileDefault:'".$defaultValue."',
			Preview:".$previewForm."
		});
	";
	
	
	
	$tabHTML.="</script>";
?>