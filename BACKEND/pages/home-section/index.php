<!-- DATABASE - HOME_SECTION - INDEX -->
<?php
require_once '../../elements/functions.php';
require_once '../../class/Database.php';
require_once '../../define/databaseConfig.php';
require_once '../../class/Validate.php';
require_once '../../define/homeValidate.php';
require_once '../../class/Pagination.php';
// two levels up
$Databases = new Database($initServer);
$getAll = 'SELECT * FROM ' . $Databases->getTable();
$allElemenets = $Databases->recordQueryResult($getAll);
$arrayRender = $allElemenets;
// allElements: all items
// arrayRender: query array
$htmlData = '';
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$totalItems = count($allElemenets);


// SEARCH AREA
// FIRST: ASSIGN THE ALLELEMENTS ARRAY AS FULL ARRAY -> SEARCH PROCESS -> ASSIGN THE SEARCH 
$querySearch = [];
$querySearch[] = 'SELECT * ';
$querySearch[] = 'FROM `' . $Databases->getTable() . '`';
if (isset($_GET['submit'])) {
    $queryWhere = [];
    if (intval($_GET['search']['status']) < 2) {
        $queryWhere[] = '`status` = ' . $_GET['search']['status'];
    }
    if (!empty($_GET['search']['name'])) {
        $queryWhere[] = '`name` LIKE "%' . $_GET['search']['name'] . '%"';
    }
    if (!empty($_GET['search']['url'])) {
        $queryWhere[] = '`url` LIKE "%' . $_GET['search']['url'] . '%"';
    }
    if (!empty($_GET['search']['created_at']['start'])) {
        $queryWhere[] = '`created_at` >= ' . $_GET['search']['created_at']['start'];
    }
    if (!empty($_GET['search']['created_at']['end'])) {
        $queryWhere[] = '`created_at` <= ' . $_GET['search']['created_at']['end'];
    }
    if (!empty($queryWhere)) {
        $querySearch[] = 'WHERE ' . implode(' AND ', $queryWhere);
    }
}
$querySearch = implode(' ', $querySearch);
$arrayRender = $Databases->recordQueryResult($querySearch);
// if the query array isn't full -> only render 1 page and page range is 1 only
if (count($allElemenets) != count($arrayRender)) {
    $pageRange = 1;
    $totalItemsPerPages = count($arrayRender);
    $totalPages = 1;
}
else {
    $totalItemsPerPages = 10;
    $pageRange = 4;
    $totalPages = floor($totalItems / $totalItemsPerPages) + ($totalItems % $totalItemsPerPages !== 0);
}

// start pagination
$startElement = ($currentPage - 1) * $totalItemsPerPages;
$querySearch .= ' LIMIT ' . $startElement . ', ' . $totalItemsPerPages;
$arrayRender = $Databases->recordQueryResult($querySearch);
$newPaginationClass = new Pagination($totalItems, $totalItemsPerPages, $pageRange, $currentPage);
if (!empty($arrayRender)) {
    // RENDER ELEMENTS
    // select from limit
    $htmlData = '';
    if (!empty($arrayRender)) {
        foreach ($arrayRender as $key => $value) {
            $htmlData .= '
                    <tr class="align-middle">
                         <td>' . $value['id'] . '</td>
                         <td>' . $value['name'] . '</td>
                         <td>' . $value['image'] . '</td>
                         <td>' . $value['url'] . '</td>
                         <td>
                             <input class="form-check-input" type="checkbox" role="switch" id="input-status-' . $value['id'] . '" ' . ($value['status'] ? 'checked' : '') . '>
                         </td>
                         <td>' . $value['order'] . '</td>
                         <td>' . $value['created_at'] . '</td>
                         <td>' . $value['updated_at'] . '</td>
                         <td>
                             <a href="edit.php?id=' . $value['id'] . '" class="btn btn-sm btn-primary">Edit</a>
                             <a href="delete.php?id=' . $value['id'] . '" class="btn btn-sm btn-danger" type="button">Delete</a>
                         </td>
                     </tr>';
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <?php require_once '../../elements/head.php'; ?>
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-mini sidebar-collapse bg-body-tertiary app-loaded">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <?php require_once '../../elements/navbar.php'; ?>

        <?php require_once '../../elements/sidebar.php'; ?>
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Page header-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">HomeSection - Index</h3>
                        </div>
                        <div class="col-sm-6">
                            <a href="./create.php" class="btn btn-primary float-sm-end ms-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 5l0 14"></path>
                                    <path d="M5 12l14 0"></path>
                                </svg>
                                Create
                            </a>

                        </div>
                    </div>
                    <!--end::Page header-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content Header-->
            <div class="app-content">
                <div class="container-fluid">
                    <!-- Filter & Search -->
                    <form action="" method="GET">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">Search</h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex gap-3">
                                    <div class="mb-3 w-50">
                                        <label for="exampleInputPassword1" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1" name="search[name]">
                                    </div>
                                    <div class="mb-3 w-50">
                                        <label for="exampleInputPassword1" class="form-label">URL</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1" name="search[url]">
                                    </div>
                                    <div class="mb-3 w-50">
                                        <label for="validationCustom04" class="form-label">Status</label>
                                        <select class="form-select" name="search[status]" id="validationCustom04" required="">
                                            <!-- <option selected="" disabled="" value="">Choose...</option> -->
                                            <option value="2">Both</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a valid state.</div>
                                    </div>
                                </div>
                                <div class="d-flex gap-3">
                                    <div class="mb-3 w-50">
                                        <label for="exampleInputPassword1" class="form-label">Start date:</label>
                                        <input type="date" name="search[created_at][start]" class="form-control" id="exampleInputPassword1">
                                    </div>
                                    <div class="mb-3 w-50">
                                        <label for="exampleInputPassword1" class="form-label">End date:</label>
                                        <input type="date" name="search[created_at][end]" class="form-control" id="exampleInputPassword1">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-info" type="submit" name="submit">Search</button>
                                <button class="btn btn-warning" type="submit">Clear</button>
                            </div>
                        </div>
                    </form>
                    <!-- List Items -->
                    <div class="card mt-3">
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">Id</th>
                                        <th style="width: 20px">Name</th>
                                        <th>Image</th>
                                        <th>Url</th>
                                        <th style="width: 10px">Status</th>
                                        <th style="width: 10px">Order</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo $htmlData;
                                    ?>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th style="width: 10px">id</th>
                                        <th style="width: 20px">name</th>
                                        <th>image</th>
                                        <th>url</th>
                                        <th style="width: 10px">status</th>
                                        <th style="width: 10px">order</th>
                                        <th>created_at</th>
                                        <th>updated_at</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <?php
                                echo $newPaginationClass->showPagination();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once '../../elements/footer.php'; ?>
    </div>
    <?php require_once '../../elements/script.php'; ?>
</body>

</html>