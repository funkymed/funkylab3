<?php
$strServeur = strtolower($_SERVER['SERVER_NAME']);
switch($strServeur){
    case "localhost":
        $host       = "localhost";
        $user       = "root";
        $pass       = "Zwc0f75h";
        $bdd        = "f3";
        $ext_site   = "f3";
        $url        = "http://localhost/f3.funkylab.info/web/";
        break;
    default:
        $host       = 'localhost:/tmp/mysql5.sock';
        $user       = "dbo339428562";
        $pass       = "vc121wt78v";
        $bdd        = "db339428562";
        $ext_site   = "funkylab3";
        $url        = "http://localhost/f3.funkylab.info/web/";
}

define ("bdd",          $bdd);
define ("ext_site",     $ext_site);
define ("sessionName",  $ext_site);
define ("url_root",     $url);

mysql_connect($host,$user,$pass);
mysql_select_db("$bdd");

?>