<?php
	$timecode = round(microtime(true)*1000);
	if($_POST["id"]=='new'){
		$value="";
	}else{
		$value=getContentItem($Table,$_POST["id"],$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'],$keyorder);
	}
	
	if(!is_dir("../../../directory/".$value)){
		$value="";
	}
	
	$name=$Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']."_".$count;
	$label=$Config['TABLEAU']['ITEM'][$key]['NAME']['VALUE'];
	$tabHTML.="<input type=\"hidden\" value=\"".$value."\" id=\"".$name."\" name=\"".$name."\" />";
	$tabHTML.="<label for=\"".$name."\">".$label." : </label>";
	$tabHTML.="<div class=\"field\">";
	$tabHTML.="<div id=\"filemanager_".$timecode."\"></div>";
	$tabHTML.="</div>";
	$tabHTML.="<div style=\"clear:both;height:10px;\"></div>";
	$tabHTML.="<script type=\"text/javascript\">
		_SelectFile".$timecode."=new SelectDir({
			SourceObjName:'_SelectFile".$timecode."',
			DivId:'filemanager_".$timecode."',
			InputId:'".$name."',
			ValidExtension:'',
			SourceDir:'directory/',
			DirDefault:'".$value."'
		});
	</script>";
?>