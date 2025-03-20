<!-- DATABASE - HOME_SECTION - EDTI -->
<?php
require_once '../../elements/functions.php';
require_once '../../class/Database.php';
require_once '../../define/databaseConfig.php';
require_once '../../define/homeValidate.php';
require_once '../../class/HomeSection.php';
require_once '../../class/Form.php';

$id = '';
$errorFix = '';
$objHomeSection = new HomeSection($initServer);
$_GET['id'] = intval($_GET['id']);
if (isset($_GET['id'])) {
  $id = $_GET['id'];
}


$infoStorage = new Database($initServer);
$arrayGetInitialValue = $objHomeSection->getItem($id);
$params = $arrayGetInitialValue;




if (empty($params)) {
  Header("Location: index.php");
  exit();
}

if (isset($_POST['submit'])) {
  $params = array_merge($_POST, $_FILES);
  $result = $objHomeSection->updateItem($id, $params);
  $errorFix =  $result['errors'];
  if ($result == true) {
    header("Location: index.php");
    exit();
  }
}

$editName = Form::input("text", "name", "Name", $params['name'] ?? '');
$editOrder = Form::input("text", "order", "Order", $params['order'] ?? '');
$editURL = Form::input("text", "url", "URL", $params['url'] ?? '');

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
              <h3 class="mb-0">Database - Edit</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body m-3">
        <div class="card card-primary card-outline mb-4">
          <div class="card-header">
            <div class="card-title">Home section - Edit</div>
          </div>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-body">
              <?php
              if ($errorFix !== '') {
                echo $errorFix;
              }
              ?>

              <?= $editName ?>

              <?= $editOrder ?>

              <?= $editURL ?>

              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" role="switch" name="status" <?= isset($params['status']) ? 'checked' : '' ?>>
                <label class="form-check-label">Default switch checkbox input</label>
              </div>
              <!-- IMAGE -->
              <div style="margin: 10px 0 10px 0; width: 30%; height: auto;">
                <img src="" id = "image-display-preview" class="w-100 h-100 rounded">
              </div>
              <div class="mb-3">
                <label class="form-label">Upload</label>
                <input type="file" class="form-control" name="image" id = "input-upload-preview">
              </div>
            </div>
            <!-- SUBMIT -->
            <div class="card-footer">
              <input type="submit" class="btn btn-primary" name="submit" value="Submit">
              <a type="button" class="btn btn-warning" href="./index.php">Cancel</a>
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