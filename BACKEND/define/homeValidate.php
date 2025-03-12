<?php
$RulesHomeSection = array(
    'name' => array(
        'type' => 'string',
        'min' => 1,
        'max' => 100
    ),
    'order' => array(
        'type' => 'int',
        'min' => 1,
        'max' => 256
    ),
    // 'url' => array(
    //     'type' => 'url-custom'
    // ),
    'url' => array (
        'type' => 'string',
        'min' => 5,
        'max' => 100
    ),
    'image' => array(
        'type' => 'image',
        'max_bytes' =>  2 * 1024 * 1024,
        'extensions' => array('png', 'jpeg', 'jpg', 'jfif', 'webp')
    )
);
define("RULE_HOME_SECTION", $RulesHomeSection);
