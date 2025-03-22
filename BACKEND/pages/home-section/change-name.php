<?php
   require_once '../../class/HomeSection.php';
   require_once '../../class/Database.php';
   require_once '../../class/Validate.php';
   require_once '../../define/databaseConfig.php';
   require_once '../../define/homeValidate.php';

   $objHomeSection = new HomeSection($initServer);

   $id = $_GET['id'];
   $newValue = $_GET['name'];

   $status = $objHomeSection->patchName($id, $newValue);

   if ($status === true) {
      echo 'success';
   }
   else {
      echo 'fail';
   }
   die();
   header("Location: index.php");
?>