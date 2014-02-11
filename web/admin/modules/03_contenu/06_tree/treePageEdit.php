<?php
	/*
		id = 2
		titre = nouvelle%20page
		xmlfile = modules/03_contenu/05_tree
	*/
	header('Content-Type: text/html; charset: UTF-8');
	require_once("../../../includes/php/bddconf.php");
    require_once("../../../includes/php/xmlparser.php");
	
	
	$parser = new XMLParser("modules.xml", 'file', 1);
	$tree = $parser->getTree();
	$Config=$tree['MODULES']['CONFIG'];
	$Arboitems=$tree['MODULES']['CONFIG']['ARBOITEMS']['ITEM'];
	$linkmediaTable=$Config['LINKMEDIATABLE']['VALUE'];
	
	$Table=$tree['MODULES']['CONFIG']['TABLE']['VALUE'];
	$keyorder=$tree['MODULES']['CONFIG']['KEYORDER']['VALUE'];
	$tabheader=array();
	$tabKey=array();
	$linktable=array();
	$linkid=array();
	$linkreturnvalue=array();
	
	$tabAlign=array();
	$tabmaxlength=array();

	$tabHTML="<span class=\"h3\" style=\"background:#00bbff;color:white;text-align:left;\"><img src=\"".$_POST["xmlfile"]."/32x32.png\" alt\"\" width=\"16\" height=\"16\" align=\"left\"/>Items disponible</span>";
	$tabHTML.="<div style=\"background:#333;border:2px #000 solid;height:55px;\">";
	
 	$tabHTML.="<input type=\"hidden\" name=\"treeMediaSelect\" id=\"treeMediaSelect\" />";
	
	for ($tt=0;$tt<count($Arboitems);$tt++){
		$tabHTML.="<div class=\"dragitem\" id=\"itemarbo_".$tt."\" style=\"cursor:move;float:left;color:white;margin:5px;text-align:center;\" title=\"".$Arboitems[$tt]['SOURCE']['VALUE']."\">";
		$tabHTML.="<img src=\"modules/".$Arboitems[$tt]['SOURCE']['VALUE']."/32x32.png\" /><br />";
		$tabHTML.=$Arboitems[$tt]['NAME']['VALUE'];
		$tabHTML.="</div>";
	}
	$tabHTML.="<div style=\"clear:both;\"></div>";
	$tabHTML.="</div>";
	
	$tabHTML.="<span class=\"h3\" style=\"background:#ff6403;color:white;text-align:left;\"><img src=\"".$_POST["xmlfile"]."/32x32.png\" alt\"\" width=\"16\" height=\"16\" align=\"left\"/>Contenu de page</span>";
	$tabHTML.="<div id=\"dropItem\" style=\"background:#333;border:2px #000 solid;height:320px;overflow:scroll;overflow-y:hidden;\">";
	
	$queryPere="SELECT id_child,tablename FROM ".$linkmediaTable." WHERE id_pere=".$_POST["id"]." ORDER BY ordre";	
	$resPere=mysql_query($queryPere);
	
	$tabDivItem=array();
	$count=0;
	while ($rowPere = mysql_fetch_array($resPere)){
		$queryChild="SELECT * FROM ".$rowPere['tablename']." WHERE id=".$rowPere['id_child'];	
		$resChild=mysql_query($queryChild);
		$rowChild = mysql_fetch_array($resChild);
		$poskey=getXmlFile($Arboitems,$rowPere['tablename']);
		
		
		if (isset($Arboitems[$poskey]['SOURCE'])){
			$parserItems = new XMLParser("../../".$Arboitems[$poskey]['SOURCE']['VALUE']."/modules.xml", 'file', 1);
			$treeItems = $parserItems->getTree();
			
			if(isset($Arboitems[$poskey]['PREVIEW']) && is_file("../../../../directory/".$rowChild[$Arboitems[$poskey]['PREVIEW']['VALUE']])){
				if (isset($Arboitems[$poskey]['PREVIEWTYPE'])){
					switch($Arboitems[$poskey]['PREVIEWTYPE']['VALUE']){
						case "image":
							$newNameTab=explode("/","../directory/".$rowChild[$Arboitems[$poskey]['PREVIEW']['VALUE']]);
							$newName="";
							for ($xx=0;$xx<count($newNameTab)-1;$xx++){
								$newName.=$newNameTab[$xx]."/";
							}
							//$newName.="thumb_".$newNameTab[count($newNameTab)-1];
							$newName.=$newNameTab[count($newNameTab)-1];
							
							$preview="<div style=\"width:128px;height:128px;border:2px gray solid;margin:auto;\"><img src=\"".$newName."\" width=\"128\" height=\"128\"/></div>";
							
							$newNameTab=explode("/","../directory/".$rowChild[$Arboitems[$poskey]['PREVIEW']['VALUE']]);
							$newName="";
							for ($xx=0;$xx<count($newNameTab)-1;$xx++){
								$newName.=$newNameTab[$xx]."/";
							}
							//$newName.="thumb_".$newNameTab[count($newNameTab)-1];
							$newName.=$newNameTab[count($newNameTab)-1];
							
							$iconPreview="<img src=\"".$newName."\" width=\"32\" height=\"32\"/><br />";
							break;
						default:
							$preview="";
							$iconPreview="<img src=\"modules/".$Arboitems[$poskey]['SOURCE']['VALUE']."/32x32.png\" /><br />";
							break;
					}
				}else{
					$preview="";
					$iconPreview="<img src=\"modules/".$Arboitems[$poskey]['SOURCE']['VALUE']."/32x32.png\" /><br />";
				}
				
			}else{
				$preview="";
				$iconPreview="<img src=\"modules/".$Arboitems[$poskey]['SOURCE']['VALUE']."/32x32.png\" /><br />";
			}
			
					
			 /*Icon*/
			 
			$idName=$rowPere['tablename']."_".$rowChild['id'];
			
			$tabHTML.="<div id=\"".$idName."\" style=\"cursor:pointer;float:left;color:white;margin:5px;text-align:center;\" onDblClick=\"administration.modeRefresh=false;administration.editForm('modules/".$Arboitems[$poskey]['SOURCE']['VALUE']."',".$rowChild['id'].");\">";
			$tabHTML.=$iconPreview;
			
			if(isset($Arboitems[$poskey]['TITLE'])){
				$tabHTML.=$rowChild[$Arboitems[$poskey]['TITLE']['VALUE']];
			}else{
				$tabHTML.=$Arboitems[$poskey]['NAME']['VALUE'];
			}
			
			$tabHTML.="</div>";
			
			/*ToolTip*/
			
			$tabHTML.="<div class=\"tooltipLink\" id=\"tooltip_".$count."\" style=\"display:none;\">";
			$tabHTML.="Edition :";
			$tabHTML.="<hr />";
			$tabHTML.="<div onClick=\"administration.modeRefresh=false;administration.editForm('modules/".$Arboitems[$poskey]['SOURCE']['VALUE']."',".$rowChild['id'].");\" onmouseover=\"tabover(this);\" onmouseout=\"tabout(this);\" >Editer</div>";
			$tabHTML.="<div onClick=\"administration.deleteTreeItem('modules/".$Arboitems[$poskey]['SOURCE']['VALUE']."',".$rowChild['id'].",'".$idName."');\" onmouseover=\"tabover(this);\" onmouseout=\"tabout(this);\" >Effacer</div>";
			$tabHTML.="<hr />";
			$tabHTML.=$preview;
			$tabHTML.="</div>";
			
			$count++;
			$tabDivItem[]=$idName;
		}
	}
	
	$tabHTML.="</div>";
	
	
	/*Javascript*/
	
	$tabHTML.="<script type=\"text/javascript\">\n";
	
	$tabHTML.="Droppables.add('dropItem',{
		accept:'dragitem',
		hoverclass:'droppableItem',
		onDrop: function(e){
			administration.modeRefresh=true;
			$('treeMediaSelect').value=e.title;
			administration.addItemPage();
		}
	});";
	
	for ($tt=0;$tt<count($Arboitems);$tt++){
		 $tabHTML.="new Draggable('itemarbo_".$tt."',{ghosting:true,revert:true});";
		 
	}
	
	
	for ($yy=0;$yy<count($tabDivItem);$yy++){
		$tabHTML.="TooltipManager.addHTML('".$tabDivItem[$yy]."', 'tooltip_".$yy."');";	
	}
	
	$tabHTML.="Sortable.create('dropItem',{
		tag:'div',
		constraint:false, 
		ghosting: false,
		onUpdate: function () {
			var allTabItem=new Array();
			$('dropItem').descendants().each(function(e){
				if (e.id!=\"\"){
					allTabItem.push(e.id);
				}
			 });
			 
			new Ajax.Request('includes/php/updatelinkarbo.php', {
				parameters:{items:allTabItem.toString(),xmlfile:'".$_POST["xmlfile"]."',pageid:'".$_POST["id"]."'},
				onComplete: function(e){
					Debugger.DEBUG(e.responseText);
				}
			});
			
			
		}
	});";
	
	$tabHTML.="</script>";
	
 	print $tabHTML;
 	
 	function getXmlFile($array,$keyRef){
	 	for ($tt=0;$tt<count($array);$tt++){
		 	if ($array[$tt]['TABLE']['VALUE']==$keyRef){
			 	return $tt;
		 	}
	 	}
 	}
 	
?>