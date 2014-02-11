<?php
	header('Content-Type: text/html; charset: UTF-8');
	
	session_start();
	
	require_once("bddconf.php");
    require_once("xmlparser.php");
	$xmlfile="../../".$_POST["xmlfile"]."/modules.xml";
	$parser = new XMLParser($xmlfile, 'file', 1);
	$tree = $parser->getTree();
	$Config=$tree['MODULES']['CONFIG'];
	$Table=$tree['MODULES']['CONFIG']['TABLE']['VALUE'];
	$Editable=$tree['MODULES']['CONFIG']['EDITABLE']['VALUE'];
	$keyorder=$tree['MODULES']['CONFIG']['KEYORDER']['VALUE'];
	$tabheader=array();
	$tabKey=array();
	$tabPreview=array();
	$tabTypePreview=array();
	$linktable=array();
	$linkid=array();
	$linkreturnvalue=array();
	
	if(!isset($_SESSION["Funkylab3"]["tab_".$Table]['page'])){
		$_SESSION["Funkylab3"]["tab_".$Table]['page']=0;	
	}
	
	$tabAlign=array();
	$tabmaxlength=array();

	$tabHTML="<span class=\"h2\"><img src=\"".$_POST["xmlfile"]."/32x32.png\" alt\"\" align=\"left\"/>" .$tree['MODULES']['NAME']['VALUE']."</span><br />";
	$tabHTML.="<div class=\"buttons\" style=\"clear:both;\">";
	
	if ($tree['MODULES']['CONFIG']['ADD']['VALUE']=='Y'){
		$tabHTML.="<button type=\"button\" class=\"positive\" onclick=\"administration.editForm(administration.xmlfile,'new');\">";
		$tabHTML.="<img src=\"images/plus.png\" alt=\"Ajouter\" />";
		$tabHTML.="Ajouter";
		$tabHTML.="</button>";
	}
	
	$tabHTML.="<button type=\"button\" onclick=\"administration.refreshCurrentOption();\">";
	$tabHTML.="<img src=\"images/refresh.png\" alt=\"Recharger\" />";
	$tabHTML.="Recharger";
	$tabHTML.="</button>";
	
	$tabHTML.="</div>";
	
	$tabHTML.="<div style=\"clear:both;\"></div>";
	$tabHTML.="<br /><br />";
	
	$tabHTML.="{pagination}";
	$tabHTML.="<table id=\"tableEdit\" class=\"sortable\" summary=\"\" style=\"clear:both;\">\n";
	$tabHTML.="\t<thead>\n";
	$tabHTML.="\t\t<tr>\n";
	$count=0;
	
	foreach($Config['TABLEAU']['ITEM'] as $key => $value){
		if( isset($Config['TABLEAU']['ITEM'][$key]['TABDISPLAY']) && $Config['TABLEAU']['ITEM'][$key]['TABDISPLAY']['VALUE']=='Y'){
			$tabKey[$count]=$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'];
			$tabheader[$count]=$Config['TABLEAU']['ITEM'][$key]['NAME']['VALUE'];
			$tabAlign[$count]=$Config['TABLEAU']['ITEM'][$key]['ALIGN']['VALUE'];
			
			$tabPreview[$count] = isset($Config['TABLEAU']['ITEM'][$key]['PREVIEW']['VALUE']) ? $Config['TABLEAU']['ITEM'][$key]['PREVIEW']['VALUE'] : 'N';
			$tabTypePreview[$count] = isset($Config['TABLEAU']['ITEM'][$key]['PREVIEWTYPE']) ? $Config['TABLEAU']['ITEM'][$key]['PREVIEWTYPE']['VALUE'] : 'N';
			
			if ($Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE']==$keyorder){
				$idrow=" idrow ";
			}else{
				$idrow="";
			}
			
			if(!isset($Config['TABLEAU']['ITEM'][$key]['TABDISPLAY']) || $Config['TABLEAU']['ITEM'][$key]['SORTABLE']['VALUE']!='Y'){
				$nosort=" nosort ";
			}else{
				$nosort="";
			}
			
			if(isset($Config['TABLEAU']['ITEM'][$key]['LINKTABLE'])){
				if(isset($Config['TABLEAU']['ITEM'][$key]['LINKID'])){
					$linktable[$count]=$Config['TABLEAU']['ITEM'][$key]['LINKTABLE']['VALUE'];
					$linkid[$count]=$Config['TABLEAU']['ITEM'][$key]['LINKID']['VALUE'];
					$linkreturnvalue[$count]=$Config['TABLEAU']['ITEM'][$key]['LINKRETURNVALUE']['VALUE'];
				}
			}
			$valueTab=$Config['TABLEAU']['ITEM'][$key]['NAME']['VALUE'];
			if(isset($Config['TABLEAU']['ITEM'][$key]['MAXLENGTH'])){
				$tabmaxlength[$count]=$Config['TABLEAU']['ITEM'][$key]['MAXLENGTH']['VALUE'];
			}else{
				$tabmaxlength[$count]=0;
			}
			$tabHTML.="\t\t\t<th class=\"".$idrow.$nosort." sortcol\">".$valueTab."</th>\n";
		}
		$count++;
	}
	
	
	
	$tabHTML.="\t\t\t<th class=\"nosort sortcol\">editer</th>\n";
	
	
	
	
	if ($tree['MODULES']['CONFIG']['REMOVE']['VALUE']=='Y'){
		$tabHTML.="\t\t\t<th class=\"nosort sortcol\">effacer</th>\n";
	}
	
	if (isset($tree['MODULES']['CONFIG']['LENGTHITEMSPAGE'])){
		$limit=" LIMIT ".($_SESSION["Funkylab3"]["tab_".$Table]['page']*($tree['MODULES']['CONFIG']['LENGTHITEMSPAGE']['VALUE'])).",".$tree['MODULES']['CONFIG']['LENGTHITEMSPAGE']['VALUE'];
	}else{
		$limit="";
	}
	
	
	$tabHTML.="\t\t</tr>\n";
	$tabHTML.="\t</thead>\n";
	$tabHTML.="\t<tbody>\n";
	$SQLQUERY="SELECT ".implode(",",$tabKey)." FROM ".$Table." ORDER BY ".$keyorder.$limit;
	$SQLRES=mysql_query($SQLQUERY);
	$count=0;
	while ($SQLROW = mysql_fetch_array($SQLRES)){
		$tabHTML.="\t\t<tr onmouseover=\"tabover(this);\"  onmouseout=\"tabout(this);\">\n";
		foreach($tabKey as $key => $value){
			
			if (isset($tabAlign[$key])){
				$align=" align=\"".$tabAlign[$key]."\" ";
			}
			
			$valueTXT=strip_tags($SQLROW[$value]);
			
			if ($tabmaxlength[$key]>0 && $tabmaxlength[$key]<=strlen($valueTXT)){
				$valueTXT=substr($valueTXT,0,$tabmaxlength[$key])."[...]";
			}
			
			if(isset($linktable[$key])){
				
				$LINKSQLQUERY="SELECT ".$linkreturnvalue[$key]." FROM ".$linktable[$key]." WHERE ".$linkid[$key]."=".$SQLROW[$value];
				$LINKSQLRES=mysql_query($LINKSQLQUERY);
				$LINKSQLROW = mysql_fetch_array($LINKSQLRES);
				
				$valueTXT="";
				$allLinkedKeys=explode(",",$linkreturnvalue[$key]);
				foreach($allLinkedKeys as $linkkey => $linkvalue){
					$valueTXT.=$LINKSQLROW[$linkvalue]." ";
				}
				$valueTXT.="(".$SQLROW[$value].")";
			}
			
			if($tabPreview[$key]=='Y'){
				switch($tabTypePreview[$key]){
					case "image" :
						$newNameTab=explode("/","directory/".$SQLROW[$value]);
						$newName="";
						for ($xx=0;$xx<count($newNameTab)-1;$xx++){
							$newName.=$newNameTab[$xx]."/";
						}
						$newName.="thumb_".$newNameTab[count($newNameTab)-1];
						$ahref="<a params=\"lightwindow_loading_animation=true,lightwindow_iframe_embed=true\" class=\"lightwindow\" href=\""."../directory/".$SQLROW[$value]."\">";
						$valueTXT=$ahref."<img src=\"../".$newName."\" alt=\"".$SQLROW[$value]."\" title=\"".$SQLROW[$value]."\" /></a>";
						break;
					case "color":
						$valueTXT="<div style=\"width:32px;height:32px;border:1px white solid;background:#".$SQLROW[$value].";\"></div>";
						break;
				}
			}
			
			
			
			if ($count%2){
				$tabHTML.="\t\t\t<td ".$align."class=\"roweven\">".$valueTXT."</td>\n";
			}else{
				$tabHTML.="\t\t\t<td ".$align."class=\"rowodd\">".$valueTXT."</td>\n";
			}
			$count++;
		}
		
		$tabHTML.="\t\t\t<td align=\"center\" onclick=\"administration.editForm('".$_POST["xmlfile"]."','".$SQLROW[$keyorder]."');\"  style=\"cursor:pointer;\"><img src=\"images/edit.png\" alt=\"Editer\"></td>\n";
		if ($tree['MODULES']['CONFIG']['REMOVE']['VALUE']=='Y'){
			$tabHTML.="\t\t\t<td align=\"center\" onclick=\"administration.deleteItem('".$_POST["xmlfile"]."','".$SQLROW[$keyorder]."');\" style=\"cursor:pointer;\"><img src=\"images/delete.png\" alt=\"Effacer\"></td>\n";
		}
		$tabHTML.="\t\t</tr>\n";
		
	}
	
	if ($count==0){
		$tabHTML.="\t\t<tr>\n";
		foreach($Config['TABLEAU']['ITEM'] as $key => $value){
			$tabHTML.="\t\t\t<td></td>\n";
		}
		$tabHTML.="\t\t</tr>\n";
	}
	
	
	$tabHTML.="\t</tbody>\n";
	$tabHTML.="</table>\n";
	$pageHTML="";
	if (isset($tree['MODULES']['CONFIG']['LENGTHITEMSPAGE'])){
		$nbpage=countItems($Table,$tree['MODULES']['CONFIG']['LENGTHITEMSPAGE']['VALUE']);
		$nbpageround=round($nbpage);
		if ($nbpage>$nbpageround){
			$nbpageround++;
		}
		
		
		if ($_SESSION["Funkylab3"]["tab_".$Table]['page']!=0){
			$ahrefPrec="<a href=\"javascript:administration.pagination('tab_".$Table."',-1,".$nbpageround.");\"><img src=\"images/prevpage.png\" alt=\"\" /></a>";
		}else{
			$ahrefPrec="&nbsp;";
		}
		
		if ($_SESSION["Funkylab3"]["tab_".$Table]['page']<($nbpageround-1)){
			$ahrefSuiv="<a href=\"javascript:administration.pagination('tab_".$Table."',1,".$nbpageround.");\"><img src=\"images/nextpage.png\" alt=\"\" /></a>";
		}else{
			$ahrefSuiv="&nbsp;";
		}
		
		$pagination="<select onChange=\"administration.paginationGoto('tab_".$Table."',this);\">";
		for($ww=1;$ww<$nbpageround+1;$ww++){
			if ($_SESSION["Funkylab3"]["tab_".$Table]['page']+1==$ww){
				$pagination.="<option value=\"".($ww-1)."\" selected=\"selected\">".$ww."</option>";
			}else{
				$pagination.="<option value=\"".($ww-1)."\">".$ww."</option>";
			}
			
		}
		$pagination.="</select>";
		
		
		$pageHTML="<div style=\"height:40px;width:33.33%;text-align:left;border:0px red solid;float:left;\">".$ahrefPrec."</div>";
		$pageHTML.="<div style=\"height:40px;width:33.33%;text-align:center;border:0px green solid;float:left;\">".$pagination."</div>";
		$pageHTML.="<div style=\"height:40px;width:33.33%;text-align:right;border:0px green solid;float:left;\">".$ahrefSuiv."</div>";
		
		
		
	}
	$tabHTML=str_replace("{pagination}",$pageHTML,$tabHTML);
	
	print $tabHTML;
	
	function countItems($Table,$limit){
		$countQuery="SELECT COUNT(*) FROM ".$Table;
		$countRes=mysql_query($countQuery);
		$countRow = mysql_fetch_array($countRes);
		return ($countRow[0]/$limit);
	}
	
	
?>