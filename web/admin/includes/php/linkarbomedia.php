<?php
	header('Content-Type: text/html; charset: UTF-8');
	
	require_once("bddconf.php");
    require_once("xmlparser.php");
	$xmlfile="../../".$_POST["xmlfile"]."/modules.xml";
	$parser = new XMLParser($xmlfile, 'file', 1);
	$tree = $parser->getTree();
	$Config=$tree['MODULES']['CONFIG'];
	$linkmediaTable=$Config['LINKMEDIATABLE']['VALUE'];
	$Table=$tree['MODULES']['CONFIG']['TABLE']['VALUE'];
	$keyorder=$tree['MODULES']['CONFIG']['KEYORDER']['VALUE'];
	
	$newordre=getLastOrder($linkmediaTable,$_POST['pere'],$_POST['table']);
	
	echo $sqlUpdateTab="INSERT INTO ".$linkmediaTable." (id_pere,id_child,tablename,ordre) VALUES (".$_POST['pere'].",".$_POST['child'].",'".$_POST['table']."',".$newordre.")";	
	$resultat=@mysql_query($sqlUpdateTab);
	if ($resultat=="1"){ 
		echo"ok";
	}else{ 
		echo mysql_error()."\n\n";
		echo "<P>ERREUR</P>"; 
	}
	
	function getLastOrder($linkmediaTable,$pere,$table){
	
 		$resCount = mysql_query("SELECT count(id_child) FROM ".$linkmediaTable." WHERE id_pere=".$pere);
 		echo mysql_error();
 		$rowCount= mysql_query($resCount);
		return ($rowCount[0]+1);
	}
	
?>