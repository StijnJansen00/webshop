<?php
if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'head') {
        ?>
        <title>Beheerder Dashboard</title>
        <div class="container p-3">

            <h1>Beheerder Dashboard</h1>

            <div class="row row-cols-3 justify-content-center">
                <div class="col my-2">
                    <div class="card border border-main">
                        <div class="card-body">
                            <h5 class="card-title">
                                Admin Gebruikers
                            </h5>
                            <a class="btn btn-main" href="?headPage=adminUsers">
                                Bekijk
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="card border border-main">
                        <div class="card-body">
                            <h5 class="card-title">
                                Gebruikers
                            </h5>
                            <a class="btn btn-main" href="?headPage=users">
                                Bekijk
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="card border border-main">
                        <div class="card-body">
                            <h5 class="card-title">
                                Admin Dashboard
                            </h5>
                            <a class="btn btn-main" href="admin_dashboard?adminPage=orders">
                                Bekijk
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php
        include 'head_admin_users.inc.php';
        include 'head_users.inc.php';

        if ($_GET['headPage'] === 'adminUsers') {
            echo '<script>showAdminUsers()</script>';
        } else if ($_GET['headPage'] === 'users') {
            echo '<script>showUsers()</script>';
        }

    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}

