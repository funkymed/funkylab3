
<div onmouseover="if(ThumbTimeoutHide){clearInterval(ThumbTimeoutHide);}" onmouseout="ThumbTimeoutHide=setTimeout(function(){$('Menulist').hide();},100);" style="width:150px;">
	<a href="javascript:filemanagerObj.renamefile('<?=$_GET['dir'].$_GET['file'];?>');">Renommer</a>
	<a href="javascript:filemanagerObj.deletefile('<?=$_GET['dir'].$_GET['file'];?>');">Effacer</a>
	<?php if ($_GET['type']!='dir'){?>
		<a href="javascript:filemanagerObj.DownloadFile('<?=$_GET['dir'].$_GET['file'];?>');">T&eacute;l&eacute;charger</a>
  <?php }?>
  <?php if ($_GET['type']=='zip'){?>
		<a href="javascript:filemanagerObj.unZipFile('<?=$_GET['dir'].$_GET['file'];?>');">Decompresser</a>
  <?php }else{?>
		<a href="javascript:filemanagerObj.ZipFile('<?=$_GET['dir'];?>','<?=$_GET['file'];?>');">Compresser</a>
  <?php }?>
</div>