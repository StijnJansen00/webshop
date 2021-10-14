<?php
include 'php/db.php';

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {

        $getAdminInfo = $conn->prepare("SELECT * FROM `login` WHERE loginID = ?");
        $getAdminInfo->execute([$_SESSION['loginID']]);
        $adminResult = $getAdminInfo->fetch();
        ?>
        <title>Mijn Account</title>
        <!--Header-->
        <div class="container-fluid p-0">
            <div class="header mb-3" style="background: url('img/header-acc.webp') no-repeat right 85% top 45%;">
                <div class="text align-middle">
                    <div class="container">
                        <h1 class="text-center">Mijn Account</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="container p-3">
            <div class="card p-3 border border-second mx-auto my-2" style="max-width: 20rem">
                <div class="card-body">
                    <h5 class="card-title text-main">Jouw gegevens</h5>
                    <div class="mb-3">
                        <p class="fw-bold text-second mb-0">Gebruikersnaam:</p>
                        <?= $adminResult['username'] ?>
                    </div>
                    <div class="mb-3">
                        <p class="fw-bold text-second mb-0">Handtekening:</p>
                        <?= $adminResult['signature'] ?>
                    </div>
                    <div class="my-2">
                        <form action="admin_edit_signature" method="post">
                            <input type="hidden" name="loginID" value="<?= $adminResult['loginID'] ?>">
                            <button class="btn btn-main" type="submit" name="submit" value="submit">
                                Wijzig Handtekening
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}