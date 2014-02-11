<?php
	function html_entity_decode_utf8($string){
	    static $trans_tbl;
	    $string = preg_replace('~&#x([0-9a-f]+);~ei', 'code2utf(hexdec("\\1"))', $string);
	    $string = preg_replace('~&#([0-9]+);~e', 'code2utf(\\1)', $string);
	    if (!isset($trans_tbl)){
	        $trans_tbl = array();
	        foreach (get_html_translation_table(HTML_ENTITIES) as $val=>$key)
	            $trans_tbl[$key] = utf8_encode($val);
	    }
	    return strtr($string, $trans_tbl);
	}
	function code2utf($num){
	    if ($num < 128) return chr($num);
	    if ($num < 2048) return chr(($num >> 6) + 192) . chr(($num & 63) + 128);
	    if ($num < 65536) return chr(($num >> 12) + 224) . chr((($num >> 6) & 63) + 128) . chr(($num & 63) + 128);
	    if ($num < 2097152) return chr(($num >> 18) + 240) . chr((($num >> 12) & 63) + 128) . chr((($num >> 6) & 63) + 128) . chr(($num & 63) + 128);
	    return '';
	}
	function cleantext($str){
		return trim(strip_tags(html_entity_decode_utf8(stripslashes($str)),"<b><i><u><br><p>"));
	}

	function unhtmlentities($chaineHtml) {
		$tmp = get_html_translation_table(HTML_ENTITIES);
		$tmp = array_flip ($tmp);
		$chaineTmp = strtr ($chaineHtml, $tmp);
		
		return $chaineTmp;
	}
	function cleanTextHTML($str){
		$text=stripslashes($str);
		$text=unhtmlentities($text);
		$text=str_replace("\n","",$text);
		$text=str_replace("\r","",$text);
		$text=str_replace("\t","",$text);
		$text=str_replace("&apos;","'",$text);
		$text=str_replace("&rsquo;","'",$text);
		$text=str_replace("&hellip;","...",$text);
		$text=str_replace("&oelig;","oe",$text);
		$text=strip_tags($text,"<b><i><a><br>");
		$text=str_replace("/> ","/>",$text);
		//$text=html_entity_decode($text);
		return $text;
	}
	
	function _cleanTextHTML($str){
		$text=stripslashes($str);
		$text=unhtmlentities($text);
		$text=str_replace("&apos;","'",$text);
		$text=str_replace("&rsquo;","'",$text);
		$text=str_replace("&hellip;","...",$text);
		$text=str_replace("&oelig;","oe",$text);
		$text=strip_tags($text,"<b><i><a><br>");
		$text=str_replace("/> ","/>",$text);
		//$text=html_entity_decode($text);
		return $text;
	}



?>