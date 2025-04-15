<!-- DATABASE - HOME_SECTION - INDEX -->
<?php
require_once '../../class/Database.php';
require_once '../../define/databaseConfig.php';
require_once '../../class/Pagination.php';
require_once '../../class/HomeSection.php';
require_once '../../class/Form.php';


if (isset($_GET['message'])) {
    if ($_GET['message'] == 'success') echo SUCCESS_TEXT;
    else echo FAIL_TEXT;
}

$itemsHomeSection = new HomeSection($initServer);
$params = array_merge($_GET, $_POST);
$params['page'] = $params['page'] ?? 1;
$items = $itemsHomeSection->getItems($params);
$searchParams = $params['search'] ?? [];

$totalItems = $itemsHomeSection->totalItem($params);
$newPaginationClass = new Pagination($totalItems, $itemsHomeSection->totalItemsPerPage, $itemsHomeSection->pageRange, $params['page']);
$paginationHTML = $newPaginationClass->showPagination($params);

$htmlData = '';
if (!empty($items)) {
    foreach ($items as $key => $value) {
        $htmlData .= '
            <tr class="align-middle">
                <td>' . $value['id'] . '</td>
                <td>
                    <input class="form-control ajax-name" value="' . $value['name'] . '" data-id = "' . $value['id'] . '"/>
                </td>
                <td>
                    <input class="form-control ajax-order" value="' . $value['order'] . '" data-id = "' . $value['id'] . '"/>
                </td>
                    <td>
                        <input class="form-control ajax-order" value="' . $value['order'] . '" data-id = "' . $value['id'] . '"/>
                    </td>
                <td>
                    <input class="form-check-input ajax-status" type="checkbox" role="switch" ' . ($value['status'] ? 'checked' : '') . ' data-id="' . $value['id'] . '">
                </td>
                <td>' . $value['created_at'] . '</td>
                <td>' . $value['updated_at'] . '</td>
                <td>
                    <a href="edit.php?id=' . $value['id'] . '" class="btn btn-sm btn-primary">Edit</a>
                    <a href="delete.php?id=' . $value['id'] . '" class="btn btn-sm btn-danger" type="button">Delete</a>
                </td>
            </tr>';
    }
}

// SEARCH INPUTS
$inputSearchName = Form::input('text', 'search[name]', 'Name', $searchParams['name'] ?? '');
$inputSearchUrl = Form::input('text', 'search[url]', 'URL', $searchParams['url'] ?? '');
$inputSearchCreatedAtStart = Form::input('date', 'search[created_at][start]', 'Start date:', $searchParams['created_at']['start'] ?? '');
$inputSearchCreatedAtEnd = Form::input('date', 'search[created_at][end]', 'End date:', $searchParams['created_at']['end'] ?? '');
$searchStatusValues = [2 => 'Both', 1 => 'Yes', 0 => 'No'];
$slbSearchStatus = Form::select($searchStatusValues, 'search[status]', 'Status', $searchParams['status'] ?? '');

?>
<!doctype html>
<html lang="en">

<head>
    <?php require_once '../../elements/head.php'; ?>
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-mini sidebar-collapse bg-body-tertiary app-loaded">
    <div class="app-wrapper">
        <?php require_once '../../elements/navbar.php'; ?>

        <?php require_once '../../elements/sidebar.php'; ?>
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">HomeSection - Cuisine Ingredient</h3>
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
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid">
                    <form action="" method="GET">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">Search</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <?php echo $inputSearchName; ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo $inputSearchUrl; ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo $slbSearchStatus; ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?php echo $inputSearchCreatedAtStart; ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?php echo $inputSearchCreatedAtEnd; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-info" type="submit" name="submit">Search</button>
                                <a class="btn btn-warning" href="index.php">Clear</a>
                            </div>
                        </div>
                    </form>
                    <div class="card mt-3">
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Order</th>
                                        <th>Cuisine_id</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $htmlData; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <?= $paginationHTML; ?>
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