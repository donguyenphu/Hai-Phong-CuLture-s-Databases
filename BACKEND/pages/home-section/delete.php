<!-- DATABASE - HOME_SECTION - DELETE -->
<?php
$currentTable = 'home_section';
require_once '../../class/Database.php';
require_once '../../define/databaseConfig.php';
require_once '../../class/HomeSection.php';

$objHomeSection = new HomeSection($initServer);

if (!isset($_GET['id']) || empty($objHomeSection->getItem($_GET['id']))) {
  header("Location: index.php");
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $objHomeSection = new HomeSection($initServer);
  if ($objHomeSection->deleteItem($id)) {
    header("Location: index.php");
    exit();
  }
}
