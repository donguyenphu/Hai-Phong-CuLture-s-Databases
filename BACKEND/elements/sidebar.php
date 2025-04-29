<?php
$categories = [
    'history',
    'culture',
    'cuisine',
    'cuisine-address',
    'cuisine-ingredient',
    'cuisine-ingredient-detail',
    'home-section',
    'travel',
    'travel-location-info',
    'travel-overall-image'
];
$htmlCategories = '';
foreach ($categories as $key => $value) {
    $htmlCategories .= '
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                    '.strtoupper($value).'
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="../'.$value.'/index.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../'.$value.'/create.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add</p>
                    </a>
                </li>
            </ul>
        </li>
    ';
}
?>
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="./index.php" class="brand-link">
            <img
                src="../../assets/img/AdminLTELogo.png"
                alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">AdminLTE 4</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="menu"
                data-accordion="false">
                <?php echo $htmlCategories; ?> 
            </ul>
        </nav>
    </div>
</aside>