<?php
    require_once '../../class/HomeSection.php';
    require_once '../../class/Database.php';
    require_once '../../class/Validate.php';
    require_once '../../define/databaseConfig.php';
    require_once '../../define/homeValidate.php';

    $objHomeSection = new HomeSection($initServer);

    $queryUpdate = $objHomeSection->patchStatus($_GET['id'], $_GET['status']);

    header("Location: index.php?message=success");
?>
