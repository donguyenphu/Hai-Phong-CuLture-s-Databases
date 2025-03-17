<!-- DATABASE - HOME_SECTION - EDTI -->
<?php
require_once '../../class/Database.php';
require_once '../../define/databaseConfig.php';
require_once '../../define/homeValidate.php';
require_once '../../class/HomeSection.php';
require_once '../../class/Form.php';

$id = '';
$errorFix = '';
$objHomeSection = new HomeSection($initServer);
$arrayIDs = $objHomeSection->prepareJsonArray();
$_GET['id'] = intval($_GET['id']);
if (isset($_GET['id'])) {
  $id = $_GET['id'];
}
if (!isset($_GET['id']) || !in_array($_GET['id'], $arrayIDs)) {
  Header("Location: index.php");
  exit();
}


$infoStorage = new Database($initServer);
$queryGetInitialValue = 'SELECT * FROM ' . $infoStorage->getTable() . " WHERE id = " . $id;
$arrayGetInitialValue = $infoStorage->recordQueryResult($queryGetInitialValue);
$params = $arrayGetInitialValue[0];
if (isset($_POST['submit'])) {
  $params = array_merge($_POST, $_FILES);
  $oldImage = $arrayGetInitialValue[0]['image'] ?? '';
  $result = $objHomeSection->updateItem($params, $id);
  if ($result['status']  == true) {
    if ($oldImage !== '') {
      $realPath = "../../assets/images/home-section/".$oldImage;
      @unlink($realPath);
    }
    if ($result['image'] !== '') {
      $realPath = '../../assets/images/home-section/'.$result['image'];
      @move_uploaded_file($result['tmp_name'], $realPath);
    }
    header("Location: index.php");
    exit();
  }
  $errorFix .= '<div class="alert alert-danger" role="alert">';
  foreach ($result as $element => $value) {
    $errorFix .= '<li>' . '<strong>' . ucfirst($element) . '</strong>' . ' : ' . $value . '</li>';
  }
  $errorFix .= '</div>';
}

$editName = Form::input("text", "name", "Name", $params['name'] ?? '');
$editOrder = Form::input("text", "order", "Order", $params['order'] ?? '');
$editURL = Form::input("text", "url", "URL", $params['url'] ?? '');
$editImage = Form::input("file", "image", "Upload", $params['image'] ?? '');

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
              <!-- NAME -->
              <?= $editName ?>
              <!-- ORDER -->
              <?= $editOrder ?>
              <!-- URL -->
              <?= $editURL ?>
              <!-- STATUS -->
              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" role="switch" name="status">
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