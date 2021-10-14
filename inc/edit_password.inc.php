<?php
if (isset($_SESSION['login']) && $_SESSION['role'] === 'user') {
    ?>
    <title>Wijzig Wachtwoord</title>

    <div class="container p-3">
        <div class="card p-3 border border-main mx-auto my-2" style="max-width: 20rem">
            <div class="card-body">
                <h5 class="card-title mb-3">Wachtwoord Aanpassen</h5>
                <form action="" method="post" id="editPasswordForm">
                    <input type="hidden" id="loginEditPassword" value="<?= $_POST['loginID'] ?>">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="oldPassword" id="oldEditPassword"
                               placeholder="Oude Wachtwoord" required>
                        <label for="oldEditPassword">Oude Wachtwoord</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="newPassword" id="newEditPassword"
                               placeholder="Nieuw Wachtwoord" required>
                        <label for="newEditPassword">Nieuw Wachtwoord</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="repeatPassword" id="repeatEditPassword"
                               placeholder="Herhaal Nieuw Wachtwoord" required>
                        <label for="repeatEditPassword">Herhaal Nieuw Wachtwoord</label>
                    </div>
                    <button class="btn btn-main" type="button" onclick="checkEditPassword()">
                        Wachtwoord Opslaan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}