<?php
 	header('Content-Type: text/html; charset: UTF-8');
	include "../../../includes/php/bddconf.php";
	print_r($_POST);
	$query= "UPDATE page SET titre='".addslashes(utf8_decode($_POST['new_value']))."' WHERE id=".$_POST['branch_id'];
	$res=mysql_query($query);

?>