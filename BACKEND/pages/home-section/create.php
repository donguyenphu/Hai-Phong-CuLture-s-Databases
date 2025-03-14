<!-- DATABASE - HOME_SECTION - ADD -->
<?php
require_once '../../class/Database.php';
require_once '../../define/databaseConfig.php';
require_once '../../class/HomeSection.php';
require_once '../../class/Form.php';

$errorFix = '';
$objHomeSection =  new HomeSection($initServer);
$params = [];
if (isset($_POST['submit'])) {
  $params = array_merge($_POST, $_FILES);
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
  <div class="app-wrapper">
    <?php require_once '../../elements/navbar.php'; ?>

    <?php require_once '../../elements/sidebar.php'; ?>
    <main class="app-main">
      <div class="app-content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Database - Add</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body m-3">
        <div class="card card-primary card-outline mb-4">
          <div class="card-header">
            <div class="card-title"><strong class="text-default">Home section - Add</strong></div>
          </div>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-body">
              <?php if ($errorFix !== '') { echo $errorFix; } ?>

              <?php echo Form::input('text', 'name', 'Name',$params,['name']); ;?>

              <?php echo Form::input('text','url', 'File Attached', $params, ['name']); ?>
              
              <div class="form-check form-switch">
                <label class="form-check-label" for="switch-status">Status: </label>
                <input class="form-check-input" type="checkbox" role="switch" id="switch-status" name="status" <?php if (isset($_POST['status'])) echo $_POST['status'] ? 'checked' : ''; ?>>
              </div>

              <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile02" name="image">
                <label class="input-group-text" for="inputGroupFile02">Upload</label>
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