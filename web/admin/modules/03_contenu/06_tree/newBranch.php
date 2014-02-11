<?
	include "../../../includes/php/bddconf.php";
	
	$query= "INSERT INTO page (titre,parent,fait_le) VALUES ('nouvelle page',".$_POST['branch_id'].",now())";
	$res=mysql_query($query);
	
	echo $query= "UPDATE page SET folderopen=1 WHERE id=".$_POST['branch_id'];
	$res=mysql_query($query);
	
	$query="SELECT id FROM page ORDER BY id DESC LIMIT 1";
	$res=mysql_query($query);
	$row = mysql_fetch_array($res);
	echo $row[0];
?>