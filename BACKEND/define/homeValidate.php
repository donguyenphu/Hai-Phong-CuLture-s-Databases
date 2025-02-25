<?php
    $RulesHomeSection = array(
        'name' => array(
            'type' => 'string',
            'min' => 1,
            'max' => 50
        ),
        'order' => array(
            'type' => 'int',
            'min' => 1,
            'max' => 256
        ),
        'file' => array(
            'type' => 'url-custom'
        ),
        'image' => array(
            'type' => 'image',
            'max_bytes' =>  2*1024*1024,
            'extensions' => array('jpg','png','jpeg') 
        )
    );
    define("RULE_HOME_SECTION", $RulesHomeSection)
?>