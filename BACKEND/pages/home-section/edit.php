<!-- DATABASE - HOME_SECTION - EDTI -->
<?php
require_once '../../class/Database.php';
require_once '../../define/databaseConfig.php';
require_once '../../class/Validate.php';
require_once '../../define/homeValidate.php';
require_once '../../class/HomeSection.php';
require_once '../../class/Form.php';

$id = 1;
$errorFix = '';
if (isset($_GET['id'])) {
  $id = $_GET['id'];
}

$infoStorage = new Database($initServer);
$queryGetInitialValue = 'SELECT * FROM ' . $infoStorage->getTable() . " WHERE id = " . $id;
$arrayGetInitialValue = $infoStorage->recordQueryResult($queryGetInitialValue);

if (isset($_POST['submit'])) {
  $params = array_merge($_POST, $_FILES);

  $rule = RULE_HOME_SECTION;
  unset($rule['image']);
  // create validate -> add rule -> run -> return Results -> Errors
  $Validate = new Validate($_POST);
  $Validate->addAllRules($rule);
  $Validate->run();
  $resultEnd = $Validate->returnResults();
  $errorEnd = $Validate->returnErrors();

  $arrayGetInitialValue[0]["name"] = trim($_POST['name']);
  $arrayGetInitialValue[0]["image"] = trim(!empty($_POST['image']['name']) ? $_POST['image']['name'] : $arrayGetInitialValue[0]["image"]);
  $arrayGetInitialValue[0]["url"] = trim($_POST['url']);
  $arrayGetInitialValue[0]["order"] = trim($_POST['order']);
  $arrayGetInitialValue[0]["status"] = (isset($_POST['status']) && $_POST['status']) == "on" ? 1 : 0;
  if (!count($errorEnd)) {
    $initServer = [
      'server' => 'localhost',
      'username' => 'root',
      'password' => '',
      'database' => 'hai_phong_culture_database',
      'table' => 'home_section'
    ];
    $getAll = 'SELECT * FROM ' . $infoStorage->getTable();
    $allElemenets = $infoStorage->recordQueryResult($getAll);

    $data = [
      'id' => $id,
      'name' => $arrayGetInitialValue[0]["name"],
      'image' => $arrayGetInitialValue[0]["image"],
      'url' => $arrayGetInitialValue[0]["url"],
      'order' => $arrayGetInitialValue[0]["order"],
      'status' => $arrayGetInitialValue[0]["status"],
      'updated_at' => date("Y-m-d H:i:s")
    ];

    $tmp = $infoStorage->updateOnlyOneId($data);
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
              <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" value="<?php echo $arrayGetInitialValue[0]["name"]; ?>" name="name">
              </div>
              <!-- ORDER -->
              <div class="mb-3">
                <label class="form-label">Order</label>
                <input type="text" class="form-control" value="<?php echo $arrayGetInitialValue[0]["order"]; ?>" name="order">
              </div>
              <!-- FILE ATTACHED -->
              <div class="mb-3">
                <label class="form-label">File attached</label>
                <input type="text" class="form-control" value="<?php echo $arrayGetInitialValue[0]["url"]; ?>" name="url">
              </div>
              <!-- STATUS -->
              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" <?php echo $arrayGetInitialValue[0]["status"] ? 'checked' : ''; ?> name="status">
                <label class="form-check-label">Default switch checkbox input</label>
              </div>
              <!-- IMAGE UPLOAD -->
              <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile02" name="image">
                <label class="input-group-text">Upload</label>
              </div>
            </div>
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