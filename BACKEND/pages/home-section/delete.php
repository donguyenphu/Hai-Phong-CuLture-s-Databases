<!-- DATABASE - HOME_SECTION - DELETE -->
<?php
require_once '../../class/Database.php';
require_once '../../define/databaseConfig.php';
require_once '../../class/HomeSection.php';
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $objHomeSection = new HomeSection($initServer);
  if ($objHomeSection->deleteItem($id)) {
    header("Location: index.php");
    exit();
  }
}
