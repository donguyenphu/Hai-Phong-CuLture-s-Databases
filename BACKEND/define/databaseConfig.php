<?php
date_default_timezone_set("America/New_York");
$initServer = [
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'hai_phong_culture_database',
    'table' => 'home_section'
];

define("HOME_SECTION_DATABASE_INFO", $initServer);
$infoStorage = new Database($initServer);
