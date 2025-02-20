<?php
    $initServer =[
        'server' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'hai_phong_culture_database',
        'table' => 'home_section'
    ];
    define("DATABASE_INFO", $initServer);
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
            'max_bytes' =>  20*1024*1024,
            'extensions' => array() 
        )
    );
    define("RULE_HOME_SECTION", $RulesHomeSection)
?>