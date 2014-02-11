<?php
	header('Content-Type: text/html; charset: UTF-8');
	require_once("../../../includes/php/bddconf.php");
    require_once("../../../includes/php/xmlparser.php");
	$xmlfile="../../../".$_POST["xmlfile"]."/modules.xml";
	$parser = new XMLParser($xmlfile, 'file', 1);
	$tree = $parser->getTree();
	$Table=$tree['MODULES']['CONFIG']['TABLE']['VALUE'];
	$keyorder=$tree['MODULES']['CONFIG']['KEYORDER']['VALUE'];
	$delete_id=$_POST['id'];
	
	echo $sqlDELETE="DELETE FROM ".$Table." WHERE ".$keyorder."=".$delete_id;
	
	print_r($_POST);
	$resultat=@mysql_query($sqlDELETE);
	if ($resultat=="1"){ 
		echo "c bon"; 	
	}else{ 
		echo mysql_error()."\r\n";
		echo $sqlUpdateTab;			
		echo "<P>ERREUR</P>"; 
	}
	
	if (isset($_POST['linkdelete'])){
		echo $sqlDELETE="DELETE FROM link_page_contenu WHERE id_child=".$delete_id." AND tablename='".$Table."'";
	
		print_r($_POST);
		$resultat=@mysql_query($sqlDELETE);
		if ($resultat=="1"){ 
			echo "c bon"; 	
		}else{ 
			echo mysql_error()."\n\n";
			echo $sqlDELETE;			
			echo "<P>ERREUR</P>"; 
		}
	}
	
	
?>