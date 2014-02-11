<?php
	if($_POST["id"]=='new'){
		$value="";
	}else{
		$value=getContentItem($Table,$_POST["id"],$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'],$keyorder);
	}
	$name=$Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']."_".$count;
	$label=$Config['TABLEAU']['ITEM'][$key]['NAME']['VALUE'];
	$tabHTML.="<label for=\"".$name."\">".$label." : </label>";
	$tabHTML.="<div class=\"field\" id=\"divmultiselect".$count."\">";
	$tabHTML.="<input readonly=\"readonly\" type=\"hidden\" value=\"".$value."\" id=\"".$name."\" name=\"".$name."\" />";
	$tabHTML.="</div>";
	$tabHTML.="<div style=\"clear:both;height:10px;\"></div>";
	$tableLinked=$Config['TABLEAU']['ITEM'][$key]['LINKTABLE']['VALUE'];
	$tableLinkedlabel=$Config['TABLEAU']['ITEM'][$key]['LINKLABEL']['VALUE'];
	$tableLinkedvalue=$Config['TABLEAU']['ITEM'][$key]['LINKVALUE']['VALUE'];
	$tableLinkedorder="";
	if(isset($Config['TABLEAU']['ITEM'][$key]['LINKLABEL']['ATTRIBUTES']['ORDER'])){
		$tableLinkedorder=$Config['TABLEAU']['ITEM'][$key]['LINKLABEL']['ATTRIBUTES']['ORDER'];
		$tableLinkedorderby=$Config['TABLEAU']['ITEM'][$key]['LINKLABEL']['VALUE'];;
	}else if(isset($Config['TABLEAU']['ITEM'][$key]['LINKVALUE']['ATTRIBUTES']['ORDER'])){
		$tableLinkedorder=$Config['TABLEAU']['ITEM'][$key]['LINKVALUE']['ATTRIBUTES']['ORDER'];
		$tableLinkedorderby=$Config['TABLEAU']['ITEM'][$key]['LINKVALUE']['VALUE'];;
	}
	$orderlinked = 	$tableLinkedorder!="" ? " order by ".$tableLinkedorderby." ".$tableLinkedorder : "";
	$querymultisql="select ".$tableLinkedlabel.",".$tableLinkedvalue." from ".$tableLinked.$orderlinked;
	$valueArray=explode(",",$value);
	$resmultisql=mysql_query($querymultisql);
	$arrayJSONS=array();
	while ($rowmultisql = mysql_fetch_array($resmultisql)){
		if ($value==""){
			$value=$rowmultisql[$tableLinkedvalue];
		}
		$selected=(count($valueArray)>0 && in_array($rowmultisql[$tableLinkedvalue],$valueArray)) ? "true" : "false";
		$arrayJSONS[]="{label:'".$rowmultisql[$tableLinkedlabel]."',value:'".$rowmultisql[$tableLinkedvalue]."',selected:".$selected."}";
	}
	$jsonConfig="[".implode(",",$arrayJSONS)."]";
	$tabHTML.="
	<script type=\"text/javascript\">
		new MultiSelectObj(".$jsonConfig.",'".$value."','divmultiselect".$count."','".$name."');
	</script>";
?>