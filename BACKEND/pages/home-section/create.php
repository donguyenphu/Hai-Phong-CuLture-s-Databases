<!-- DATABASE - HOME_SECTION - ADD -->
<?php
$currentTable = 'home_section';
require_once '../../elements/functions.php';
require_once '../../class/Database.php';
require_once '../../define/databaseConfig.php';
require_once '../../class/HomeSection.php';
require_once '../../class/Form.php';

$errorFix = '';
$objHomeSection =  new HomeSection($initServer);
$params = [];
if (isset($_POST['submit'])) {
  $params = array_merge($_POST, $_FILES);
  $status = $objHomeSection->createItem($params);
  if ($status === true) {
    header("Location: index.php");
  }
  $errorFix = $status['errors'];
}

// CREATE FORM STARTS
$createName = Form::input('text', 'name', 'Name', $params['name'] ?? '');
$createURL = Form::input('text', 'url', 'File Attached', $params['url'] ?? '');
$createStatus = $params['status'] ?? '';

?>

<!doctype html>
<html lang="en">

<head>
  <?php require_once '../../elements/head.php'; ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <div class="app-wrapper">
    <?php require_once '../../elements/navbar.php'; ?>

    <?php require_once '../../elements/sidebar.php'; ?>
    <main class="app-main">
      <div class="app-content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">HomeSection - Add</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body m-3">
        <div class="card card-primary card-outline mb-4">
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-body">
              <?php if ($errorFix !== '') {
                echo $errorFix;
              } ?>
              <!-- NAME -->
              <?= $createName ?>
              <!-- URL -->
              <?= $createURL ?>
              <!-- STATUS -->
              <div class="form-check form-switch">
                <label class="form-check-label" for="switch-status">Status: </label>
                <input class="form-check-input" type="checkbox" role="switch" id="switch-status" name="status" <?= $createStatus ?>>
              </div>
              <!-- IMAGE -->
              <div style="margin: 10px 0 10px 0; width: 30%; height: auto;">
                <img src="" id="image-display-preview" class="w-100 h-100 rounded">
              </div>
              <div class="mb-3">
                <label class="form-label">Upload</label>
                <input type="file" class="form-control" name="image" id="input-upload-preview">
              </div>
            </div>
            <div class="card-footer">
              <input type="submit" class="btn btn-primary" name="submit" value="Submit">
              <a class="btn btn-warning" href="index.php">Cancel</a>
            </div>
          </form>
        </div>
      </div>

    </main>

    <?php require_once '../../elements/footer.php'; ?>
  </div>
  <?php require_once '../../elements/script.php'; ?>
</body>

</html>