<?php
    header('Content-Type: text/html; charset: UTF-8');
    require_once("bddconf.php");
    require_once("xmlparser.php");
    $rootDir="../../modules/";
    $tabModules=listOption($rootDir);
    $varXmlTab=array();
	for ($xx=0;$xx<count($tabModules);$xx++){
	 	if (is_file($rootDir.$tabModules[$xx].'/menu.xml')){
	 		$parser = new XMLParser($rootDir.$tabModules[$xx].'/menu.xml', 'file', 1);
	 		$tree = $parser->getTree();
	 		
	 		
	 		$varXmlTab[$xx]["Titre"]=$tree['MODULES']['NAME']['VALUE'];
	 		$varXmlTab[$xx]["Icon"]="modules/".$tabModules[$xx].'/32x32.png';
	 		$tabModulesSub=listOption($rootDir.$tabModules[$xx]."/");
	 		
	 		$countMod=0;
	 		
	 		for ($rr=0;$rr<count($tabModulesSub);$rr++){
		 		if (is_file($rootDir.$tabModules[$xx].'/'.$tabModulesSub[$rr].'/modules.xml')){
			 		$Subparser = new XMLParser($rootDir.$tabModules[$xx].'/'.$tabModulesSub[$rr].'/modules.xml', 'file', 1);
			 		$Subtree = $Subparser->getTree();
			 		
		 			if(isset($Subtree['MODULES']['DISPLAY']['VALUE']) && $Subtree['MODULES']['DISPLAY']['VALUE']=='Y'){
		 			
				 		$varXmlTab[$xx]["Content"][$countMod]["Titre"]=$Subtree['MODULES']['NAME']['VALUE'];
				 		$varXmlTab[$xx]["Content"][$countMod]["Icon"]="modules/".$tabModules[$xx].'/'.$tabModulesSub[$rr].'/32x32.png';
				 		
				 		$tableName=isset($Subtree['MODULES']['CONFIG']['TABLE']['VALUE']) ? $Subtree['MODULES']['CONFIG']['TABLE']['VALUE'] : "";
				 		
				 		if($tableName!="" && mysql_table_exists($tableName)==0 && isset($Subtree['MODULES']['CONFIG']['TYPE'])){
					 		switch($Subtree['MODULES']['CONFIG']['TYPE']['VALUE']){
						 		case "tableau":
							 		if(isset($Subtree['MODULES']['CONFIG']['TABLEAU']['ITEM'])){
								 		makeBddFormXML($Subtree['MODULES']['CONFIG']['TABLEAU']['ITEM'],$tableName);
							 		}
							 		break;
							 	case "tree":
							 		makeLinkTableXML($tableName);
							 		break;
						 	}
				 		}
				 		
				 		if (is_file($rootDir.$tabModules[$xx].'/'.$tabModulesSub[$rr].'/table.sql')){
					 		$myFile = $rootDir.$tabModules[$xx].'/'.$tabModulesSub[$rr].'/table.sql';
							$fh = fopen($myFile, 'r');
							$theData = fread($fh, filesize($myFile));
							fclose($fh);
							mysql_query($theData);
				 		}
				 		
					 	foreach($Subtree['MODULES']['CONFIG'] as $key => $value){
						 	if (isset($value['VALUE'])){
					 			$varXmlTab[$xx]["Content"][$countMod]['Config'][$key]=$value['VALUE'];
				 			}
				 		}
				 		$varXmlTab[$xx]["Content"][$countMod]['Config']['xml']="modules/".$tabModules[$xx].'/'.$tabModulesSub[$rr];
				 		$countMod++;
			 		}
		 		}
	 		}
	 	}
	}
	
	
	print getJson($varXmlTab);
    
  	function listOption($directory){
		$tab=array();
		$dir = opendir($directory);
		
		while ($f = readdir($dir)) {
				if(is_dir($directory.$f)) {
					if ($f!="." && $f!=".."){
					$tab[]= $f;	
				}
			}
	  	}
		closedir($dir);
		sort($tab);
		
		
		return $tab;
	}
	function getJson($arr=null) {
		if (!is_array($arr)){
			$arr=$this->getTree();
		}
	    $parts = array();
	    $is_list = false;
	    $keys = array_keys($arr);
	    $max_length = count($arr)-1;
	    if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {
	        $is_list = true;
	        for($i=0; $i<count($keys); $i++) {
	            if($i != $keys[$i]) { 
	                $is_list = false;
	                break;
	            }
	        }
	    }
	    foreach($arr as $key=>$value) {
	        if(is_array($value)) { 
	            if($is_list) $parts[] = getJson($value);
	            else $parts[] = '"' . $key . '":' . getJson($value);
	        } else {
	            $str = '';
	            if(!$is_list) $str = '"' . $key . '":';
	            if(is_numeric($value)) $str .= $value;
	            elseif($value === false) $str .= 'false';
	            elseif($value === true) $str .= 'true';
	            else $str .= '"' . addslashes($value) . '"';
	            $parts[] = $str;
	        }
	    }
	    $json = implode(',',$parts);
	    if($is_list) return '[' . $json . ']';
	    return '{' . $json . '}';
	} 
  
	function makeLinkTableXML($tableName){
		$queryLink="CREATE TABLE `".$tableName."` (";
		$queryLink.="`id_pere` int(11) NOT NULL default '0',";
		$queryLink.="`id_child` int(11) NOT NULL default '0',";
		$queryLink.="`order` int(11) NOT NULL default '0',";
		$queryLink.="`ordre` int(11) NOT NULL default '0',";
		$queryLink.="`tablename` varchar(255) NOT NULL default ''";
		$queryLink.=") ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		mysql_query($queryLink);		
	}
	
	function makeBddFormXML($xmlTab,$tableName){
		$insertCol	= array();
		$primaryKey	= "";
		for ($tt=0;$tt<count($xmlTab);$tt++){
			$newCol				= $xmlTab[$tt];
			$newColType			= isset($newCol['ATTRIBUTES']['TYPE']) ? $newCol['ATTRIBUTES']['TYPE'] : "";
			$newColPrimaryKey	= isset($newCol['ATTRIBUTES']['PRIMARYKEY']) ? $newCol['ATTRIBUTES']['PRIMARYKEY'] : "" ;
			$newColDefault		= isset($newCol['ATTRIBUTES']['DEFAULT']) ? " default '".$newCol['ATTRIBUTES']['DEFAULT']."'" : "";
			$newColKey			= isset($newCol['KEY']['VALUE']) ? $newCol['KEY']['VALUE'] : "";
			if ($newColPrimaryKey=="Y"){
				$insertCol[]="`".$newColKey."` ".$newColType." NOT NULL auto_increment";
				$primaryKey=",PRIMARY KEY  (`".$newColKey."`)";
			}else{
				$insertCol[]="`".$newColKey."` ".$newColType." NOT NULL".$newColDefault;
			}
		}
		$queryCol="CREATE TABLE `".$tableName."` (".implode(",",$insertCol).$primaryKey.") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		mysql_query($queryCol);
	}
	
	function mysql_table_exists($table) {
		$requete = 'SHOW TABLES FROM '.bdd.' LIKE \''.$table.'\'';
		$exec = mysql_query($requete);
		return mysql_num_rows($exec);
	}

?>