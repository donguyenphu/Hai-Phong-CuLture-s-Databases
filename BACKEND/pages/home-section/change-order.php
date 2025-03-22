<?php
    require_once '../../class/HomeSection.php';
    require_once '../../class/Database.php';
    require_once '../../class/Validate.php';
    require_once '../../define/databaseConfig.php';
    require_once '../../define/homeValidate.php';

    $objHomeSection = new HomeSection($initServer);
    $_GET = array_map(function ($element) {
        return trim($element);
    }, $_GET);

    $objHomeSection->patchOrder($_GET['id'], $_GET['order']);

    header("Location: index.php");
?>
