<?php
	 if($_POST["id"]=='new'){
		$value="";
	}else{
		$value=getContentItem($Table,$_POST["id"],$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'],$keyorder);
	}
	$name=$Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']."_".$count;
	
	$label=$Config['TABLEAU']['ITEM'][$key]['NAME']['VALUE'];
	$tabHTML.="<label for=\"".$name."\">".$label." : </label>";
	$tabHTML.="<div class=\"field\">";
	
	$RichEdit="";
	if (isset($Config['TABLEAU']['ITEM'][$key]['HTMLMODE']['VALUE']) && $Config['TABLEAU']['ITEM'][$key]['HTMLMODE']['VALUE']=='Y')
		$RichEdit="onClick=administration.initRichEditor(this)";
	
	$tabHTML.="<textarea ".$RichEdit." type=\"text\" style=\"width:500px;height:200px\" id=\"".$name."\" name=\"".$name."\">".$value."</textarea>";
	$tabHTML.="</div>";
	$tabHTML.="<div style=\"clear:both;height:10px;\"></div>";
	
// 	if (isset($Config['TABLEAU']['ITEM'][$key]['HTMLMODE']['VALUE']) && $Config['TABLEAU']['ITEM'][$key]['HTMLMODE']['VALUE']=='Y'){
// 		$tabHTML.="<script type=\"text/javascript\">";
// 		//$tabHTML.="tinyMCE.idCounter=0;";
// 		$tabHTML.="tinyMCE.execCommand('mceAddControl', false, '".$name."');";
// 		$tabHTML.="</script>";
// 	}
	
?>