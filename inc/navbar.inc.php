<?php
require "permissions/pages.php";

if ($_SESSION['role'] === 'head') {
    $userArray = $menuItems['head'];
} else if ($_SESSION['role'] === 'admin') {
    $userArray = $menuItems['admin'];
} else if ($_SESSION['role'] === 'user') {
    $userArray = $menuItems['user'];
} else {
    $userArray = $menuItems['guest'];
}

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $products = count($_SESSION['cart']);
} else {
    $products = 0;
}
?>

<div class="container py-1">
    <a class="navbar-brand" href="home">
        <img loading="lazy" src="img/logo4YouOffice.png" height="80" alt="4YouOffice Logo">
    </a>
</div>

<div class="container-fluid bg-main border-top border-second text-white py-1">
    <div class="container">
        <div class="row row-cols-2">
            <div class="col">
                Voor 15.00 besteld, vandaag verzonden!
            </div>
            <div class="col text-end">
                Gratis verzending vanaf &euro;65,-
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg sticky-top navbar-light bg-nav font-monospace py-1 px-5">

    <button class="navbar-toggler border-main ms-auto" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbar4YouOffice"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="container">
        <div class="collapse navbar-collapse" id="navbar4YouOffice">
            <ul class="navbar-nav mb-2 mb-md-0 ms-auto font-monospace">
                <?php
                foreach ($userArray as $item) {
                    if (!is_string($item[1])) {
                        echo '<li class="nav-item dropdown p-1">';
                        echo '<a class="nav-link dropdown-toggle fs-5" href="#" id="acc_dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
                        echo '<i class="bi bi-person"></i>';
                        echo '</a>';
                        echo '<ul class="dropdown-menu border border-second" aria-labelledby="acc_dropdown">';
                        foreach ($item[1] as $DropItem) {
                            echo '<li><a class="dropdown-item" href="' . $DropItem[0] . '">' . $DropItem[1] . '</a></li>';
                        }
                        echo '</ul>';
                        echo '</li>';
                    } else {
                        echo '<li class="nav-item px-2 pt-1"><a class="nav-link fs-5" aria-current="page" href="' . $item[0] . '">' . $item[1] . '</a></li>';
                    }
                }
                ?>
                <li class="nav-item px-2">
                    <a class="nav-link fs-5" aria-current="page" href="cart">
                        <i class="fs-4 bi bi-cart3"></i><span class='badge badge-warning'
                                                              id='lblCartCount'> <?= $products ?> </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
