<?php
  require_once '../../elements/functions.php';
  require_once '../../class/Database.php';
  require_once '../../define/databaseConfig.php';
  require_once '../../class/Validate.php';
  require_once '../../define/homeValidate.php';
  $id = 1;
  $errorFix = '';
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
  }

  $InfoStorage = new Database($initServer);
  $queryGetInitialValue = 'SELECT * FROM '.$InfoStorage->getTable()." WHERE id = ".$id;
  $arrayGetInitialValue = $InfoStorage->recordQueryResult($queryGetInitialValue);

  if (isset($_POST['submit'])) {
    $_POST = array_merge($_POST, $_FILES);

    if (!isset($_POST["image"]["name"])) {
      $_POST["image"]["name"] = $_POST["imageName"]; 
    }

    // create validate -> add rule -> run -> return Results -> Errors
    $Validate = new Validate($_POST);
    $Validate ->addAllRules(RULE_HOME_SECTION);
    $Validate -> run();
    $resultEnd = $Validate->returnResults();
    $errorEnd = $Validate->returnErrors();

    $arrayGetInitialValue[0]["name"] = trim($_POST['name']);
    $arrayGetInitialValue[0]["id"] = trim($_POST['id']);
    $arrayGetInitialValue[0]["image"] = trim((isset($_POST['image']["name"]) ? $_POST["image"]["name"] : $_POST["imageName"]));
    $arrayGetInitialValue[0]["url"] = trim($_POST['file']);
    $arrayGetInitialValue[0]["order"] = trim($_POST['order']);
    $arrayGetInitialValue[0]["status"] = (isset($_POST['status']) ? 1 : 0);

    if (!count($errorEnd)) {
      $initServer = [
        'server' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'hai_phong_culture_database',
        'table' => 'home_section'
      ];
      $getAll = 'SELECT * FROM ' . $InfoStorage->getTable();
      $allElemenets = $InfoStorage->recordQueryResult($getAll);

      $data = [
        'id' => trim($_POST['id']),
        'name' => trim($_POST['name']),
        'image' => trim(!empty($_POST['image']["name"]) ? $_POST['image']['name'] : $_POST['imageName']),
        'url' => trim($_POST['file']),
        'order' => trim($_POST['order']),
        'status' => (isset($_POST['status']) ? 1 : 0),
        'updated_at' => date("H:i:s A")
      ];
      
      $tmp = $InfoStorage->updateOnlyOneId($data, $id);
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
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $arrayGetInitialValue[0]["name"]; ?>" name="name">
              </div>
              <!-- ORDER -->
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Order</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $arrayGetInitialValue[0]["order"]; ?>" name="order">
              </div>
              <!-- ID -->
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Id</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $arrayGetInitialValue[0]["id"]; ?>" name="id">
              </div>
              <!-- FILE ATTACHED -->
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">File attached</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $arrayGetInitialValue[0]["url"]; ?>" name="file">
              </div>
              <!-- STATUS -->
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="status" <?php echo $arrayGetInitialValue[0]["status"] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="exampleCheck1">Status:</label>
              </div>
              <!-- STATUS (LATER) -->
              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
              </div>
              <!-- IMAGE NAME UPLOAD -->
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $arrayGetInitialValue[0]["image"]; ?>" name="imageName">
              </div>
              <!-- IMAGE UPLOAD -->
              <div class="input-group mb-3">
                  <input type="file" class="form-control" id="inputGroupFile02" name="image">
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