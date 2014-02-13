<?php
 	header('Content-Type: text/html; charset: UTF-8');

	include "../../../includes/php/bddconf.php";
	
	$query="SELECT * FROM page WHERE parent=0 ORDER by titre ASC";
	$res=mysql_query($query);
	$varTab=array();
	
	$varTab[0]["id"]="0";
	$varTab[0]["txt"]="Racine des pages";
	$varTab[0]["open"]=1;
	
	while ($row = mysql_fetch_array($res)){
		$varTab[0]["items"][]=getElement($row);
	}
	
	print utf8_encode(getJson($varTab));
	
	function  getElement($row){
		$varTab=array();
		$varTab["id"]=$row["id"];
		$varTab["txt"]=stripslashes($row["titre"]);
		$varTab["open"]=$row["folderopen"];
		$SubQuery="SELECT * FROM page WHERE parent=".$row["id"]." ORDER by titre ASC";
		$SubRes=mysql_query($SubQuery);
		while ($SubRow = mysql_fetch_array($SubRes)){
			
			$varTab["items"][]=getElement($SubRow);
		}
		return $varTab;
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
?>