<?php
include 'php/db.php';

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {

        $getAdminInfo = $conn->prepare("SELECT * FROM `login` WHERE loginID = ?");
        $getAdminInfo->execute([$_SESSION['loginID']]);
        $adminResult = $getAdminInfo->fetch();

        $signature = str_replace('<br>', '', $adminResult['signature']);
        ?>
        <title>Wijzig Handtekening</title>

        <div class="container p-3">
            <div class="card p-3 border border-main mx-auto my-2" style="max-width: 20rem">
                <div class="card-body">
                    <h5 class="card-title mb-3">Handtekening</h5>
                    <form action="php/admin_edit_signature.php" method="post">

                        <textarea class="mb-3" name="signature" id="adminSignature" cols="30" rows="10"
                                  aria-label="Handtekening"><?= $signature ?></textarea>

                        <button class="btn btn-main" type="submit" name="submit" value="submit">
                            Wijzig Handtekening
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <?php
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}