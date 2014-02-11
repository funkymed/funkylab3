<?php

	header('Content-Type: text/html; charset: UTF-8');
	require_once("../../../includes/php/bddconf.php");
    require_once("../../../includes/php/xmlparser.php");
	$xmlfile="modules.xml";
	$parser = new XMLParser($xmlfile, 'file', 1);
	$tree = $parser->getTree();
	$Config=$tree['MODULES']['CONFIG'];
	$Table=$tree['MODULES']['CONFIG']['TABLE']['VALUE'];
	$keyorder=$tree['MODULES']['CONFIG']['KEYORDER']['VALUE'];
	$tabheader=array();
	$tabKey=array();
	$linktable=array();
	$linkid=array();
	$linkreturnvalue=array();
	
	$tabAlign=array();
	$tabmaxlength=array();

	$tabHTML="<span class=\"h2\" style=\"background:#ffaa55;\"><img src=\"".$_POST["xmlfile"]."/32x32.png\" alt\"\" align=\"left\"/>" .$tree['MODULES']['NAME']['VALUE']."</span>";
	$tabHTML.="<div style=\"margin-top:10px;\">";
	$tabHTML.="<div id=\"arbotree\" class=\"treeListPage arboTree\" style=\"float:left;overflow:auto;height:400px;width:300px;\"></div>";
	$tabHTML.="<div id=\"contenttree\" style=\"margin-left:305px;background:#ccc;\">";
	
	
	$tabHTML.="<div id=\"pagecontent\"></div>";
	
	$tabHTML.="</div>";
	$tabHTML.="</div>";
	
	$tabHTML.="<script type=\"text/javascript\">\n";
	
	
	$source=$Config['SOURCE']['VALUE'];
	$rename=$Config['RENAME']['VALUE'];
	$drop=$Config['DROP']['VALUE'];
	$remove=$Config['REMOVE']['VALUE'];
	$add=$Config['ADD']['VALUE'];
	$openclose=$Config['OPENCLOSE']['VALUE'];
	
	$addtree=isset($Config['ADDTREE']['VALUE']) ? $Config['ADDTREE']['VALUE'] : "N";
	$removetree=isset($Config['REMOVETREE']['VALUE']) ? $Config['REMOVETREE']['VALUE'] : "N";
	
	
	$tabHTML.="AjaxTreeOption={
		source:'".$source."',
		rename:'".$rename."',
		drop:'".$drop."',
		remove:'".$remove."',
		add:'".$add."',
		openclose:'".$openclose."',
		addtree:'".$addtree."',
		removetree:'".$removetree."'
	};";
	
	$tabHTML.="\ttree=new TreeManager('arbotree','tree',administration.arboClickItem,'images/tree/','".$_POST["xmlfile"]."/',AjaxTreeOption);";
	$tabHTML.="</script>";
	
	print $tabHTML;
	
 		
?>