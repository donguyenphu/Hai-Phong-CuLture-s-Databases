
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
  $errorURL = '';
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
      }
      else {
        $errorName = '<strong class="text-danger">Your name has an invalid length</strong>';
      }
    }
    if (!checkAttachedLink($url)) {
      if (!strlen(trim($url))) {
        $errorURL = '<strong class="text-danger">Please fill the attached link</strong>';
      }
      else {
        $errorURL = '<strong class="text-danger">Your URL has an invalid length</strong>';
      }
    }
    if (!checkImageLink(trim($imageLink))) {
      if (!strlen(trim($imageLink))) {
        $errorImageLink = '<strong class="text-danger">Please fill the image link</strong>';
      }
      else {
        $errorImageLink = '<strong class="text-danger">Your image link has an invalid length</strong>';
      }
    }

    if ($errorName == '' && $errorURL == '' && $errorImageLink == '') {
      $initServer =[
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
      $queryUpdate = "UPDATE "."`".$user -> getTable()."` SET";
      $middle = '';
      foreach ($modify as $key => $value) {
        $middle .= ", "."`".$key."`"." = "."'".$value."'";
      }
      $middle = substr($middle, 1);
      $queryUpdate .= $middle." WHERE `id` = "."'".$id."'";
      echo $queryUpdate.'</br>';
      // die();
      $arr = $user -> query($queryUpdate);
      header("Location: index.php");
      exit();
      /// UPDATE `home_section` SET `name` = 'bro', SET `image` = 'BucTuongHaiPhong.jpg', SET `url` = './index.php' WHERE `id` = '1'
    }
  }
?>

<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE v4 | Dashboard</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
        name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS." />
    <meta
        name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard" />
    <!--end::Primary Meta Tags-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!--begin::Fonts-->
    <link
        rel="stylesheet"
        href="./css/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
        crossorigin="anonymous" />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
        rel="stylesheet"
        href="./css/overlayscrollbars.min.css"
        integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
        rel="stylesheet"
        href="./css/bootstrap-icons.min.css"
        integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="./css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block"><a href="./index.php" class="nav-link">Home</a></li>
                    <li class="nav-item d-none d-md-block"><a href="./create.php" class="nav-link">Create</a></li>
                </ul>
                <!--end::Start Navbar Links-->
                <!--begin::End Navbar Links-->

                <!--end::End Navbar Links-->
            </div>
            <!--end::Container-->
        </nav>
        <!--end::Header-->
        <!--begin::Sidebar-->
        <?php require_once '../home-section/nav-left.php'; ?>





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
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="../home-section/index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Database - Edit</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content Header-->
            <!--begin::App Content-->
            <!--end::App Content-->
            <div class="card-body">
                <div class="card card-primary card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header"><div class="card-title">Home section - Edit</div></div>
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
                        <label for="exampleInputEmail1" class="form-label">File attached</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" value="" name="url">
                        <?php
                          echo $errorURL;
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








        <footer class="app-footer">
            <!--begin::To the end-->
            <div class="float-end d-none d-sm-inline">Anything you want</div>
            <!--end::To the end-->
            <!--begin::Copyright-->
            <strong>
                Copyright &copy; 2014-2024&nbsp;
                <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
            </strong>
            All rights reserved.
            <!--end::Copyright-->
        </footer>
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
        src="../home-section/js/overlayscrollbars.browser.es6.min.js"
        integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
        crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
        src="../home-section/js/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
        src="../home-section/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="../home-section/js/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- sortablejs -->
    <script
        src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
        integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ="
        crossorigin="anonymous"></script>
    <!-- sortablejs -->
    <script>
        const connectedSortables = document.querySelectorAll('.connectedSortable');
        connectedSortables.forEach((connectedSortable) => {
            let sortable = new Sortable(connectedSortable, {
                group: 'shared',
                handle: '.card-header',
            });
        });

        const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
        cardHeaders.forEach((cardHeader) => {
            cardHeader.style.cursor = 'move';
        });
    </script>
    <!-- apexcharts -->
    <!-- ChartJS -->
    <!--end::Script-->
</body>
<!--end::Body-->

</html>