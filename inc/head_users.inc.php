<?php
include "php/db.php";

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'head') {
        $selectUsers = $conn->prepare("SELECT * FROM login AS l INNER JOIN `user` u ON u.loginID = l.loginID WHERE l.role = ?");
        $selectUsers->execute(['user']);
        ?>
        <title>Gebruikers</title>
        <div class="hide" id="users">

            <div class="container">
                <h3 class="mb-3">Gebruikers</h3>

                <div class="row mb-3">
                    <div class="col-lg-6 col-md-12">
                        <input type="search" class="form-control" id="usersSearch" placeholder="Zoek User"
                               aria-label="Search">
                    </div>
                </div>
            </div>

            <div class="container-fluid p-3">

                <div class="table-scroll" style="height: 30rem;">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Naam</th>
                            <th>Email</th>
                            <th>Adres</th>
                            <th>Bedrijf</th>
                            <th>Tel</th>
                        </tr>
                        </thead>
                        <tbody id="usersTable">
                        <?php
                        foreach ($selectUsers as $user) {
                            ?>
                            <tr>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['name'] . ' ' . $user['surname'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['street'] . ' ' . $user['number'] . ' ' . $user['zipcode'] . ' ' . $user['city'] ?></td>
                                <td><?= $user['company'] ?></td>
                                <td><?= $user['phone'] ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>

            <script>
                $(document).ready(function () {
                    $("#usersSearch").on("keyup", function () {
                        var value = $(this).val().toLowerCase();
                        $("#usersTable tr").filter(function () {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                    });
                });
            </script>

        </div>
        <?php
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}