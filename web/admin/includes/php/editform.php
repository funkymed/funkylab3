<?php
	header('Content-Type: text/html; charset: UTF-8');
	require_once("bddconf.php");
    require_once("xmlparser.php");
	$xmlfile="../../".$_POST["xmlfile"]."/modules.xml";
	$parser = new XMLParser($xmlfile, 'file', 1);
	$tree = $parser->getTree();
	$Config=$tree['MODULES']['CONFIG'];
	$Table=$tree['MODULES']['CONFIG']['TABLE']['VALUE'];
	$keyorder=$tree['MODULES']['CONFIG']['KEYORDER']['VALUE'];
	$count=0;
	$tabHTML="<form id=\"EditFormItems\" onsubmit=\"return false;\">";
	$tabHTML.="<h1 style=\"text-align:left;background:#cc3333;height:40px;padding-left:10px;padding-top:15px;font-size:15pt;color:white;\"><img src=\"".$_POST["xmlfile"]."/32x32.png\" alt\"\" align=\"left\"/>" .$tree['MODULES']['NAME']['VALUE']."</h1><br/><br/>";
	$tabHTML.="<div style=\"overflow:scroll;overflow-x:hidden;height:250px;\" id=\"idFormItems\">";
	foreach($Config['TABLEAU']['ITEM'] as $key => $value){
		if (isset($Config['TABLEAU']['ITEM'][$key]['EDITABLE']) && $Config['TABLEAU']['ITEM'][$key]['EDITABLE']['VALUE']=='Y'){
			if (isset($Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']) && is_file("form/".$Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE'].".php")){
				include "form/".$Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE'].".php";
				$count++;
			}
		}
	}
	$tabHTML.="</div>";
	$tabHTML.="<div class=\"buttons\" style=\"width:100%;text-align:center;\">";
	/*
	$tabHTML.="<button type=\"button\" class=\"positive\" onclick=\"administration.submitForm();\">";
	$tabHTML.="<img src=\"images/tick.png\" alt=\"Valider\" />";
	$tabHTML.="Valider";
	$tabHTML.="</button>";
	*/
	$tabHTML.="<input type=\"button\" value=\"valider\" class=\"btn\" onclick=\"administration.submitForm();\"/>";
	
	$tabHTML.="</div>";
	$tabHTML.="</form>";
	
	print $tabHTML;
	
	function getContentItem($table,$id,$key,$keyorder){
		$SQLQUERY="SELECT ".$key." FROM ".$table." WHERE ".$keyorder."=".$id;
		$SQLRES=mysql_query($SQLQUERY);
		$SQLROW = mysql_fetch_array($SQLRES);
		return $SQLROW[0];
	}
?>