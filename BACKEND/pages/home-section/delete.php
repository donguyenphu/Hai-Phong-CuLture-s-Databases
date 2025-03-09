<!-- DATABASE - HOME_SECTION - DELETE -->
<?php
require_once '../../elements/functions.php';
require_once '../../class/Database.php';
require_once '../../define/databaseConfig.php';
require_once '../../class/Validate.php';
require_once '../../define/homeValidate.php';
require_once '../../class/Pagination.php';
require_once '../../class/HomeSection.php';
if (isset($_GET['id'])) {
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
  header("Location: index.php");
  exit();
}
