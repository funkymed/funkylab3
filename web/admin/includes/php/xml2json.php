<?php
    header('Content-Type: text/html; charset: UTF-8');
    require_once("xmlparser.php");
    $file="../../".$_POST['file'];
  	$parser = new XMLParser($file, 'file', 1);
  	echo $parser->getJson();
?>