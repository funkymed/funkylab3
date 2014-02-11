<?php

	
	$label=$Config['TABLEAU']['ITEM'][$key]['NAME']['VALUE'];
	$name=$Config['TABLEAU']['ITEM'][$key]['FORM']['VALUE']."_".$count;
	$minV=$Config['TABLEAU']['ITEM'][$key]['MIN']['VALUE'];
	$maxV=$Config['TABLEAU']['ITEM'][$key]['MAX']['VALUE'];
	
	if(isset($Config['TABLEAU']['ITEM'][$key]['STEP']['VALUE'])){
		$step=$Config['TABLEAU']['ITEM'][$key]['STEP']['VALUE'];
	}else{
		$step=1;
	}

	if($_POST["id"]=='new'){
		$value=$minV;
	}else{
		$value=getContentItem($Table,$_POST["id"],$Config['TABLEAU']['ITEM'][$key]['KEY']['VALUE'],$keyorder);
	}
	
	$tabHTML.="<label for=\"".$name."\">".$label." : </label>";
	$tabHTML.="<div class=\"field\">";
	$tabHTML.="<div id=\"track".$count."\" style=\"width:500px; background:transparent url(images/slider-images-track-right.png) no-repeat scroll right top; height:10px;float:left;\">";
	$tabHTML.="<div id=\"handle".$count."\" style=\"width:10px; height:15px; cursor:move;\"><img src=\"images/slider-images-handle.png\" alt=\"\" style=\"float: left;\" /></div>";
	$tabHTML.="</div>";
	$tabHTML.="<div  style=\"padding-left:5px;\" id=\"debug".$count."\">&nbsp;</div>";
	$tabHTML.="<input type=\"hidden\" id=\"".$name."\" name=\"".$name."\" value=\"".$value."\" />";
	$tabHTML.="</div>";
	
	$tabHTML.="<div style=\"clear:both;height:10px;\"></div>";
	$tabHTML.="<script type=\"text/javascript\">";	
	
	$tabHTML.="
		slider".$count." =new Control.Slider('handle".$count."', 'track".$count."',
		{
			range:\$R(".$minV.", ".$maxV.", false),
			step:".$step.",
			onChange : function(v){ \$('debug".$count."').update(Math.round(v)); \$('".$name."').value= Math.round(v); },
	    	onSlide :  function(v){ \$('debug".$count."').update(Math.round(v)); \$('".$name."').value= Math.round(v); }
		});	
		slider".$count.".setValue(".$value.");
	";	
	$tabHTML.="</script>";
	
?>