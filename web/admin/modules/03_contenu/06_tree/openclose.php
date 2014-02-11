<?
 	header('Content-Type: text/html; charset: UTF-8');
	include "../../../includes/php/bddconf.php";
	print_r($_POST);
	echo $query= "UPDATE page SET folderopen=".$_POST['openclose']." WHERE id=".$_POST['branch_id'];
	$res=mysql_query($query);
?>