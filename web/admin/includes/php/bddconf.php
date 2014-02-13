<?php
$strServeur = strtolower($_SERVER['SERVER_NAME']);
switch($strServeur){
    case "localhost":
        $host       = "localhost";
        $user       = "root";
        $pass       = "";
        $bdd        = "f3";
        $ext_site   = "f3";
        $url        = "http://localhost/github/funkylab3/web/";
        break;
}

define ("bdd",          $bdd);
define ("ext_site",     $ext_site);
define ("sessionName",  $ext_site);
define ("url_root",     $url);

mysql_connect($host,$user,$pass);
mysql_select_db("$bdd");

?>