<?php
include "php/db.php";

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'head') {
        $selectAdminUsers = $conn->prepare("SELECT * FROM login WHERE `role` = ?");
        $selectAdminUsers->execute(['admin']);
        ?>
        <title>Admin Gebruikers</title>
        <div class="hide container p-3" id="adminUsers">

            <h3 class="mb-3">Admin Gebruikers</h3>

            <div class="row" style="max-width: 50rem">
                <div class="col-lg-6 col-md-12 mb-3">
                    <button type="button" class="btn btn-main" data-bs-toggle="modal" data-bs-target="#addAdminUser">
                        Admin Toevoegen
                    </button>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <input type="search" class="form-control" id="adminUsersSearch" placeholder="Zoek Admin"
                           aria-label="Search">
                </div>
            </div>

            <div class="table-scroll" style="height: 30rem; max-width: 45rem">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Handtekening</th>
                        <th>*</th>
                    </tr>
                    </thead>
                    <tbody id="adminUsersTable">
                    <?php
                    foreach ($selectAdminUsers as $admin) {
                        ?>
                        <tr>
                            <td><?= $admin['username'] ?></td>
                            <td><?= $admin['signature'] ?></td>
                            <td>
                                <div class="row">
                                    <form class="col-6" action="head_edit_admin" method="get">
                                        <input type="hidden" value="<?= $admin['loginID'] ?>" name="login">
                                        <button type="submit" class="btn btn-main">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </form>
                                    <form class="col-6" action="php/head_delete_admin.php" method="post">
                                        <input type="hidden" value="<?= $admin['loginID'] ?>" name="loginID">
                                        <button type="submit" name="submit" class="btn btn-danger"
                                                onclick="return confirm(`Weet je zeker dat je dit profiel wilt verwijderen?`);">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="modal fade" id="addAdminUser" tabindex="-1" aria-labelledby="addAdminUser" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAdminUser">Admin Toevoegen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="php/head_add_admin.php" method="post">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="adminUserName" id="adminUserName"
                                       placeholder="Gebruikersnaam"
                                       required>
                                <label for="adminUserName">Gebruikersnaam</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="adminUserPassword" id="adminUserPassword"
                                       placeholder="Wachtwoord"
                                       required>
                                <label for="adminUserPassword">Wachtwoord</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="adminUserRepeatPassword" id="adminUserRepeatPassword"
                                       placeholder="Herhaal Wachtwoord"
                                       required>
                                <label for="adminUserRepeatPassword">Herhaal Wachtwoord</label>
                            </div>
                            <div class="mb-3">
                                <label for="adminSignature">Handtekening</label>
                                <textarea class="w-100" name="signature" id="adminSignature" rows="6"></textarea>
                            </div>

                            <button type="submit" name="submit" value="submit" class="btn btn-main">
                                Toevoegen
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $("#adminUsersSearch").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("#adminUsersTable tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script>
        <?php
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}