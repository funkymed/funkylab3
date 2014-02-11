<?
	include "../../../includes/php/bddconf.php";
	
	/*-------------------------------------------------------------------*/
	// REMOVE REAL ITEMS
	/*-------------------------------------------------------------------*/
	
	$sqlDELETE="SELECT tablename,id_child FROM link_page_contenu WHERE id_pere=".$_POST['branch_id'];
	$resDELETE=@mysql_query($sqlDELETE);
	while ($rowDELETE = mysql_fetch_array($resDELETE)){
		$sqlDELETE="DELETE FROM ".$rowDELETE['tablename']." WHERE id=".$rowDELETE['id_child'];
		$resultat=@mysql_query($sqlDELETE);
	}
	
	/*-------------------------------------------------------------------*/
	// REMOVE LIAISON AVEC PAGE
	/*-------------------------------------------------------------------*/
	
	$sqlDELETE="DELETE FROM link_page_contenu WHERE id_pere=".$_POST['branch_id'];
	$resultat=@mysql_query($sqlDELETE);
	
	/*-------------------------------------------------------------------*/
	// REMOVE PAGE
	/*-------------------------------------------------------------------*/
	
	
	if (checkIfParent($_POST['branch_id'])==false){
		$query= "DELETE FROM page WHERE id=".$_POST['branch_id'];
		$res=mysql_query($query);
	}else{
	}
	function checkIfParent($id){
		$query="SELECT * FROM page WHERE parent=".$id;
		$res=mysql_query($query);
		while ($row = mysql_fetch_array($res)){
			return true;
		}
		return false;
	}
	
	
	//administration.arboClickItem(administration.arboID,administration.arboTitre);
	
?>