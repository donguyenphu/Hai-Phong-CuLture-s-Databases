<!-- DATABASE - ADD -->
<?php
require_once '../../elements/functions.php';
require_once '../../class/Database.php';
require_once '../../define/databaseConfig.php';
require_once '../../class/Validate.php';
require_once '../../define/homeValidate.php';
$errorFix = '';
if (isset($_POST['submit'])) {
  $_POST = array_merge($_POST, $_FILES);
  $validate = new Validate(array_merge($_POST, $_FILES));
  $validate->addAllRules(RULE_HOME_SECTION);
  $validate->run();
  $resultEnd = $validate->returnResults();
  $errorEnd = $validate->returnErrors();
  $currentDate = date("H:i:s A");
  if (!count($errorEnd)) {
    $initServer = [
      'server' => 'localhost',
      'username' => 'root',
      'password' => '',
      'database' => 'hai_phong_culture_database',
      'table' => 'home_section'
    ];
    $InfoStorage = new Database($initServer);
    $getAll = 'SELECT * FROM ' . $InfoStorage->getTable();
    $allElemenets = $InfoStorage->recordQueryResult($getAll);
    $data = [
      'id' => $_POST['id'] = trim($_POST['id']),
      'name' => $_POST['name'] = trim($_POST['name']),
      'image' => $_POST['image']["name"] = trim($_POST['image']["name"]),
      'url' => $_POST['file'] = trim($_POST['file']),
      'order' => $_POST['order'] = trim($_POST['order']),
      'status' => $_POST['status'],
      'created_at' => $currentDate
    ];
    $InfoStorage->insert($data, 'single');
    header("Location: index.php");
    exit();
  }
  $errorFix .= '<div class="alert alert-danger" role="alert">';
  foreach ($errorEnd as $element => $value) {
    $errorFix .= '<li>' . '<strong>' . ucfirst($element) . '</strong>' . ' : ' . $value . '</li>';
  }
  $errorFix .= '</div>';
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
              <h3 class="mb-0">Database - Add</h3>
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
          <div class="card-header">
            <div class="card-title"><strong class="text-default">Home section - Add</strong></div>
          </div>
          <!-- FORM STARTS -->
          <form action="" method="POST" enctype="multipart/form-data">
            <!--begin::Body-->
            <!-- id, name, image, url, status, order, created_at, updated_at -->
            <!-- if !isset on status => off , isset => on -->
            <div class="card-body">
              <?php
              if ($errorFix !== '') {
                echo $errorFix;
              }
              ?>
              <!-- NAME -->
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?php if (isset($_POST['name'])) echo trim($_POST['name']); ?>" name="name">
              </div>
              <!-- ORDER -->
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Order</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?php if (isset($_POST['order'])) echo trim($_POST['order']); ?>" name="order">
              </div>
              <!-- ID -->
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Id</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?php if (isset($_POST['id'])) echo trim($_POST['id']); ?>" name="id">
              </div>
              <!-- FILE ATTACHED -->
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">File attached</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?php if (isset($_POST['file'])) echo trim($_POST['file']); ?>" name="file">
              </div>
              <!-- STATUS -->
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="status" <?php if (isset($_POST['status'])) echo $_POST['status'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="exampleCheck1">Status:</label>
              </div>
              <!-- STATUS (LATER) -->
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
              </div>
              <!-- IMAGE UPLOAD -->
              <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile02" name="image" value="<?php if (isset($_POST['image'])) echo $_POST['image']; ?>">
                <label class="input-group-text" for="inputGroupFile02">Upload</label>
              </div>
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer">
              <input type="submit" class="btn btn-primary" name="submit" value="Submit">
              <a type="button" class="btn btn-warning" href="./index.php">Cancel</a>
            </div>
            <!--end::Footer-->
          </form>
          <!-- FORM ENDS -->
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