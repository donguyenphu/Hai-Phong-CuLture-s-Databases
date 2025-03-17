<!-- DATABASE - HOME_SECTION - DELETE -->
<?php
require_once '../../class/Database.php';
require_once '../../define/databaseConfig.php';
require_once '../../class/HomeSection.php';
if (isset($_GET['id'])) {
  $objHomeSection = new HomeSection($initServer);
  $id = $_GET['id'];
  $database = 'hai_phong_culture_database';
  $table = 'home_section';
  $getAll = "SELECT * FROM " . $database . "." . $table;
  $initServer = [
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'hai_phong_culture_database',
    'table' => 'home_section'
  ];
  $user = new Database($initServer);
  $delQuery = "DELETE FROM " . "`" . $user->getTable() . "`" . " WHERE `id` = " . "'" . $id . "'";
  $getQuery = "SELECT * FROM " . "`" . $user->getTable() . "`" . " WHERE `id` = " . "'" . $id . "'";
  $arrayID = ($user->recordQueryResult($getQuery))[0];
  $arr = $user->query($delQuery);
  $imageName = $arrayID['image'] ?? '';
  $arrayIDs = array_values(array_diff($objHomeSection->prepareJsonArray(), [$id]));
  if ($imageName !== '') {
    @unlink('../../assets/images/home-section/'.$imageName);
  }
  if ($objHomeSection->convertBackJsonArray($arrayIDs)) {
    header("Location: index.php");
    exit();
  }
}
