<?php
    function checkNameLength($name) {
        $tmp = trim($name);
        return (strlen($tmp) > 0 && strlen($tmp) <= 50);
    }
    function checkImageLink($imgLink) {
        $tmp = trim($imgLink);
        return (strlen($tmp > 0) && strlen($tmp) <= 255);
    }
    function checkAttachedLink($url) {
        $tmp = trim($url);
        return (strlen($tmp) > 0 && strlen($tmp) <= 255);
    }
    function randomString($length = 5){
		
		$arrCharacter = array_merge(range('A','Z'), range('a','z'), range(0,9));
		$arrCharacter = implode($arrCharacter);
		$arrCharacter = str_shuffle($arrCharacter);
		
		$result		= substr($arrCharacter, 0, $length);
		return $result;
	}
?>