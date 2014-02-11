<?php
	$uploaddir = '../../../directory/' ;
	if ($_FILES['Filedata']){
		$extension_fichier = strtolower( array_pop( explode( ".", $_FILES['Filedata']['name'] ) ) ) ;
		$uploadfile = $uploaddir . basename( $_FILES['Filedata']['name'] );
		move_uploaded_file( $_FILES['Filedata']['tmp_name'], $uploadfile );
		chmod($uploadfile,0777);
		makethumbnail($uploadfile);
	} 
	
	function makethumbnail($filename){
		$newNameTab=explode("/",$filename);
		$newName="";
		for ($xx=0;$xx<count($newNameTab)-1;$xx++){
			$newName.=$newNameTab[$xx]."/";
		}
		$newName.="thumb_".$newNameTab[count($newNameTab)-1];
		
		if(!is_file($newName)){
			$width = 64;
			$height = 64;
			list($width_orig, $height_orig) = getimagesize($filename);
			$ratio_orig = $width_orig/$height_orig;
			if ($width/$height > $ratio_orig) {
			   $width = $height*$ratio_orig;
			} else {
			   $height = $width/$ratio_orig;
			}
			$image_p = imagecreatetruecolor($width, $height);
			$image = imagecreatefromjpeg($filename);
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
			imagejpeg($image_p, $newName, 90);
		}
		
	}
	
	
?>
