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
  $arr = $user->query($delQuery);

  $arrayIDs = $objHomeSection->prepareJsonArray();
  $arrayIDs = array_values(array_diff($arrayIDs, [$id]));

  if ($objHomeSection->convertBackJsonArray($arrayIDs)) {
    header("Location: index.php");
    exit();
  }
}
