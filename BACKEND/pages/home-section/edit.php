<?php
require_once '../../elements/functions.php';
require_once '../../class/Database.php';
require_once '../../define/databaseConfig.php';
$id = '';
$name = '';
$imageLink = '';
$url = '';
$created_at = '';
$updated_at = '';
$errorName = '';
$errorImageLink = '';
$errorFile = '';
$errorOrder = '';
$status = 0;
if (isset($_POST['name']) && isset($_POST['imageLink']) && isset($_POST['url'])) {
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
  }
  $name = $_POST['name'];
  $imageLink = $_POST['imageLink'];
  $url = $_POST['url'];
  $status = isset($_POST['status']) ? 1 : 0;
  if (!checkNameLength($name)) {
    if (!strlen(trim($name))) {
      $errorName = '<strong class="text-danger">Please fill your name</strong>';
    } else {
      $errorName = '<strong class="text-danger">Your name has an invalid length</strong>';
    }
  }
  if (!checkAttachedLink($url)) {
    if (!strlen(trim($url))) {
      $errorURL = '<strong class="text-danger">Please fill the attached link</strong>';
    } else {
      $errorURL = '<strong class="text-danger">Your URL has an invalid length</strong>';
    }
  }
  if (!checkImageLink(trim($imageLink))) {
    if (!strlen(trim($imageLink))) {
      $errorImageLink = '<strong class="text-danger">Please fill the image link</strong>';
    } else {
      $errorImageLink = '<strong class="text-danger">Your image link has an invalid length</strong>';
    }
  }

  if ($errorName == '' && $errorURL == '' && $errorImageLink == '') {
    $initServer = [
      'server' => 'localhost',
      'username' => 'root',
      'password' => '',
      'database' => 'hai_phong_culture_database',
      'table' => 'home_section'
    ];
    $user = new Database($initServer);
    $modify = [
      'name' => $name,
      'image' => $imageLink,
      'url' => $url
    ];
    $queryUpdate = "UPDATE " . "`" . $user->getTable() . "` SET";
    $middle = '';
    foreach ($modify as $key => $value) {
      $middle .= ", " . "`" . $key . "`" . " = " . "'" . $value . "'";
    }
    $middle = substr($middle, 1);
    $queryUpdate .= $middle . " WHERE `id` = " . "'" . $id . "'";
    echo $queryUpdate . '</br>';
    // die();
    $arr = $user->query($queryUpdate);
    header("Location: index.php");
    exit();
    /// UPDATE `home_section` SET `name` = 'bro', SET `image` = 'BucTuongHaiPhong.jpg', SET `url` = './index.php' WHERE `id` = '1'
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <?php require_once '../../elements/head.php'; ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <!--begin::App Wrapper-->
  <div class="app-wrapper">
    <!--begin::Header-->
    <?php require_once '../../elements/navbar.php'; ?>
    <!--end::Header-->
    <!--begin::Sidebar-->
    <?php require_once '../../elements/sidebar.php'; ?>





    <main class="app-main">
      <!--begin::App Content Header-->
      <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Database - Edit</h3>
            </div>
          </div>
          <!--end::Row-->
        </div>
        <!--end::Container-->
      </div>
      <!--end::App Content Header-->
      <!--begin::App Content-->
      <!--end::App Content-->
      <div class="card-body m-3">
        <div class="card card-primary card-outline mb-4">
          <!--begin::Header-->
          <div class="card-header">
            <div class="card-title">Home section - Edit</div>
          </div>
          <!--end::Header-->
          <!--begin::Form-->
          <form action="" method="POST">
            <!--begin::Body-->
            <!-- id, name, image, url, status, order, created_at, updated_at -->
            <div class="card-body">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="" name="name">
                <?php
                echo $errorName;
                ?>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Order</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="" name="order">
                <?php
                echo $errorOrder;
                ?>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">File attached</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="" name="url">
                <?php
                echo $errorFile;
                ?>
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="status">
                <label class="form-check-label" for="exampleCheck1">Status:</label>
              </div>
              <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile02" name="imageLink">
                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                <?php
                echo $errorImageLink;
                ?>
              </div>
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary" name="submit">Submit</button>
              <a type="button" class="btn btn-warning" href="./index.php">Cancel</a>
            </div>
            <!--end::Footer-->
          </form>
          <!--end::Form-->
        </div>
      </div>

    </main>

    <?php require_once '../../elements/footer.php'; ?>
  </div>
  <!--end::App Wrapper-->
  <!--begin::Script-->
  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <?php require_once '../../elements/script.php'; ?>
</body>
<!--end::Body-->

</html>