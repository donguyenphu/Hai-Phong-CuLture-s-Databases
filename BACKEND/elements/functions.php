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
?>