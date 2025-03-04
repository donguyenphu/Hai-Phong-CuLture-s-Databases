<?php
date_default_timezone_set("America/New_York");
$initServer = [
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'hai_phong_culture_database',
    'table' => 'home_section'
];
$initServer2 = [
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'hai_phong_culture_database',
    'table' => 'noOverLap'
];

define("DATABASE_INFO", $initServer);
$infoStorage = new Database($initServer);
