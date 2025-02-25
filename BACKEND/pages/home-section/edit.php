<?php
  require_once '../../elements/functions.php';
  require_once '../../class/Database.php';
  require_once '../../define/databaseConfig.php';
  require_once '../../class/Validate.php';
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
  $errorFix = '';
  if (isset($_POST['submit'])) {
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
    }

    // create validate -> add rule -> run -> return Results -> Errors

    $Validate = new Validate($_POST);
    $Validate ->addAllRules(RULE_HOME_SECTION);
    $Validate -> run();
    $Validate -> returnResults();
    $Validate -> returnErrors();
    $name = $_POST['name'];
    $imageLink = $_POST['imageLink'];
    $url = $_POST['url'];
    $status = isset($_POST['status']) ? 1 : 0;
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
        'name' => trim($_POST['name']),
        'image' => trim($_POST['image']),
        'url' => trim($_POST['file']),
        'order' => trim($_POST['order']),
        'status' => $_POST['status'],
        'id' => count($allElemenets) + 1
      ];
      $InfoStorage->update($data, RULE_HOME_SECTION);
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
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
              </div>
              <!-- IMAGE FILE -->
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
          <!--end::Form-->
        </div>
      </div>

    </main>

    <?php require_once '../../elements/footer.php'; ?>
  </div>
  <?php require_once '../../elements/script.php'; ?>
</body>
<!--end::Body-->

</html>