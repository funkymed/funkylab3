<?
	header('Content-Type: text/html; charset: UTF-8');
	
	require_once("bddconf.php");
    require_once("xmlparser.php");
	$xmlfile="../../".$_POST["xmlfile"]."/modules.xml";
	$parser = new XMLParser($xmlfile, 'file', 1);
	$tree = $parser->getTree();
	$Config=$tree['MODULES']['CONFIG'];
	
	
	
	$items=explode(",",$_POST['items']);
	$pageid=$_POST["pageid"];
	$linkmediaTable=$Config['LINKMEDIATABLE']['VALUE'];	
	
	for ($xx=0;$xx<count($items);$xx++){
		$count=$xx+1;
		
		$itemInfo=explode("_",$items[$xx]);
		
		echo $sqlUpdate = "UPDATE ".$linkmediaTable." SET ordre=".$count." WHERE id_child=".$itemInfo[1]." AND tablename='".$itemInfo[0]."' AND id_pere=".$pageid;
		
 		$resUpdate = mysql_query($sqlUpdate);
 		echo mysql_error();
		
		
		
	}
	
	
	
?>