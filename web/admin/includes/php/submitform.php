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
	$sqlUpdateTab=array();
	$sqlInsertKeyTab=array();
	$sqlInsertValueTab=array();
	foreach($Config['TABLEAU']['ITEM'] as $key => $value){
		if (isset($Config['TABLEAU']['ITEM'][$key]['EDITABLE']) && $Config['TABLEAU']['ITEM'][$key]['EDITABLE']['VALUE']=='Y'){
			$name=$Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']."_".$count;
			if(isset($_POST[$name])){
				$sqlUpdateTab[$count]=$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE']."='".addslashes($_POST[$name])."'";
				$sqlInsertKeyTab[$count]=$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'];
				$sqlInsertValueTab[$count]="'".addslashes($_POST[$name])."'";
				
				if ($Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']=='checkbox'){
					$sqlUpdateTab[$count]=$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE']."='Y'";
					$sqlInsertKeyTab[$count]=$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'];
					$sqlInsertValueTab[$count]="'Y'";
				}
				if ($Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']=='calendar_time'){
					$valueDateTimeTMP=$_POST[$name];
					$valueDateTimeTMP=explode(" ",$valueDateTimeTMP);
					$valueDateTimeTMPHour=explode(":",$valueDateTimeTMP[1]);
					if ($valueDateTimeTMP[2]=="PM"){
						$valueDateTimeTMPHour[0]+=12;
					}
					$valueDateTime=$valueDateTimeTMP[0]." ".$valueDateTimeTMPHour[0].":".$valueDateTimeTMPHour[1].":00";
					$sqlUpdateTab[$count]=$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE']."='".$valueDateTime."'";
					$sqlInsertKeyTab[$count]=$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'];
					$sqlInsertValueTab[$count]="'".addslashes($valueDateTime)."'";
				}
				$count++;			
			}else{
				if ($Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']=='checkbox'){
					$sqlUpdateTab[$count]=$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE']."='N'";
					$sqlInsertKeyTab[$count]=$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'];
					$sqlInsertValueTab[$count]="'N'";
					$count++;	
				}
			}
		}
	}
	if ($_POST["id"]=='new'){
		$sqlUpdateTab="INSERT INTO ".$Table." (".implode(",",$sqlInsertKeyTab).") VALUES (".implode(",",$sqlInsertValueTab).")";	
	}else{
		$sqlUpdateTab="UPDATE ".$Table." SET ".implode(",",$sqlUpdateTab)." WHERE ".$keyorder."=".$_POST["id"];
	}
	
	$resultat=mysql_query($sqlUpdateTab);
	if ($resultat=="1"){ 
		if ($_POST["id"]=='new'){
			$SQLLAST=mysql_query("SELECT ".$keyorder." FROM ".$Table." ORDER BY ".$keyorder." DESC LIMIT 1");
			$ROWLAST = mysql_fetch_array($SQLLAST);
			
			print $ROWLAST[0].",".$Table;
			
		}else{
			echo $_POST["id"];
		}
	}else{ 
		echo mysql_error()."\n\n";
		echo $sqlUpdateTab;			
		echo "<P>ERREUR</P>"; 
	}
?>