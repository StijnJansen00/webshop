<?php
include "php/db.php";

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'head') {

        $selectAdminInfo = $conn->prepare("SELECT * FROM login WHERE loginID = ?");
        $selectAdminInfo->execute([$_GET['login']]);
        $admin = $selectAdminInfo->fetch();
        ?>
        <title>Edit Admin</title>
        <div class="container p-3">
            <h5 class="text-center text-main mb-3">Wijzig <?= $admin['username'] ?></h5>
            <div class="card border border-second mx-auto" style="max-width: 25rem">
                <div class="card-body">
                    <form action="php/head_edit_admin.php" method="post">
                        <input type="hidden" name="login" value="<?= $admin['loginID'] ?>">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="username" id="username"
                                   value="<?= $admin['username'] ?>" required>
                            <label for="username">Gebruikersnaam</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" id="password"
                                   placeholder="Wachtwoord">
                            <label for="password">Wachtwoord</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="repeatPassword"
                                   id="repeatPassword" placeholder="Herhaal Wachtwoord">
                            <label for="repeatPassword">Herhaal Wachtwoord</label>
                        </div>
                        <button type="submit" name="submit" value="submit" class="btn btn-main">
                            Opslaan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php
    } else {
        header('Location: 404');
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}