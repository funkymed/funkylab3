<?php
	session_start();
	include "../bddconf.php"; 

	if (isset($_POST['login'])){
		if ((trim($_POST['login'])=="") OR (trim($_POST['mdp'])=="")){ 
			echo "Veuillez saisir votre login et mot de passe.";
			exit;
		}
		$ConnexionQuery = "SELECT * FROM admin WHERE login = '".$_POST['login']."' AND pass = '".$_POST['mdp']."' and  online='Y'";
		$ConnexionRes = mysql_query($ConnexionQuery);
		$ConnexionRow = mysql_fetch_array($ConnexionRes);		
		if (($_POST['login']==$ConnexionRow['login']) AND ($_POST['mdp']==$ConnexionRow['pass'])){	
			$id=$ConnexionRow['id'];
			$query="UPDATE admin SET derniereconnexion='".date("Y-m-d H:i:s")."' WHERE id='".$id."'";
			$result=mysql_query($query);						
			$_SESSION[sessionName]['user'] = $ConnexionRow;					
			$_SESSION[sessionName]['user']['startdate']=date("Y-m-d")." ".date("H:i:s");
			echo "1";
			exit();
		}else{
			echo "Mauvais login ou mot de passe";
			exit;
		}
	}else{
		echo "Veuillez saisir votre login et mot de passe.";
		exit;
	}
?>