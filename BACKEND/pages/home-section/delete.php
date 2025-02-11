<?php
require_once '../../elements/functions.php';
require_once '../../class/Database.php';
require_once '../../define/databaseConfig.php';
$id = '';
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
  // echo $delQuery.'</br>';
  $arr = $user->query($delQuery);
  header("Location: index.php");
  exit();
}
?>
