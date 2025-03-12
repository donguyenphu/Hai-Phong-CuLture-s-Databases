<!-- DATABASE - HOME_SECTION - ADD -->
<?php
require_once '../../elements/functions.php';
require_once '../../class/Database.php';
require_once '../../define/databaseConfig.php';
require_once '../../class/Validate.php';
require_once '../../define/homeValidate.php';
require_once '../../class/Pagination.php';
require_once '../../class/HomeSection.php';
$errorFix = '';
$objHomeSection =  new HomeSection($initServer);
if (isset($_POST['submit'])) {
  $params = array_merge($_POST, $_FILES);
  // $validate = new Validate($params);
  // $rule = RULE_HOME_SECTION;
  // unset($rule['order']);
  // unset($rule['image']);
  // $validate->addAllRules($rule);
  // $validate->run();
  // $resultEnd = $validate->returnResults();
  // $errorEnd = $validate->returnErrors();
  // if (!count($errorEnd)) {
  //   $status = $objHomeSection -> createItem($params);
  //   header("Location: index.php");
  //   exit();
  // }
  $status = $objHomeSection -> createItem($params);
  if ($status['status']) {
    Header("Location: index.php");
    exit();
  }
  $errorFix = $status['errors'];
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
                <label class="form-label">Name</label>
                <input type="text" class="form-control" value="<?php if (isset($_POST['name'])) echo trim($_POST['name']); ?>" name="name">
              </div>
              <!-- FILE ATTACHED -->
              <div class="mb-3">
                <label class="form-label">File attached</label>
                <input type="text" class="form-control" value="<?php if (isset($_POST['url'])) echo trim($_POST['url']); ?>" name="url">
              </div>
              <!-- STATUS -->
              <div class="form-check form-switch">
                <label class="form-check-label" for="switch-status">Status: </label>
                <input class="form-check-input" type="checkbox" role="switch" id="switch-status" name="status" <?php if (isset($_POST['status'])) echo $_POST['status'] ? 'checked' : ''; ?>>
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
              <a class="btn btn-warning" href="index.php">Cancel</a>
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