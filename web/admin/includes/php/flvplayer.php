<?php
	$video="../../".$_GET['file'];
?>

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="100%" height="100%" id="FunkylabVideoPlayer" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="true" />
	<param name="FlashVars" value="&file=<?=$video;?>&autostart=1" />
	<param name="movie" value="includes/swf/flvplayer.swf" />
	<param name="quality" value="high" />
	<param name="bgcolor" value="#000000" />
	<embed src="includes/swf/flvplayer.swf" flashvars="&file=<?=$video;?>&autostart=1" quality="high" bgcolor="#000000" width="100%" height="100%" name="FunkylabVideoPlayer" align="middle" allowFullScreen="true" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>