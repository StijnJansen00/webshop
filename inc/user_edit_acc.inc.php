<?php
include 'php/db.php';

if (isset($_SESSION['login']) && $_SESSION['role'] === 'user') {
    if (isset($_POST['submit'])) {

        $userID = $_POST['userID'];

        $getUserInfo = $conn->prepare("SELECT * FROM `user` WHERE userID=:id");
        $getUserInfo->execute([
            ":id" => $userID
        ]);
        $res = $getUserInfo->fetch();
        ?>
        <title>Wijzig Mijn Gegevens</title>
        <div class="container p-3">
            <a class="text-decoration-none text-main" href="user_acc">Terug</a>

            <div class="row m-3">
                <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
                    <form action="" method="post" id="userEditForm">
                        <div class="card border border-second mx-auto">
                            <h4 class="card-title text-center text-main mt-3">Gegevens</h4>
                            <div class="card-body pt-0">
                                <div class="row mb-3">
                                    <div class="col-6 col-md-4">
                                        <span class="fw-bold">Naam</span>
                                        <br>
                                        <?= $res['name'] ?> <?= $res['surname'] ?>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <span class="fw-bold">Email</span>
                                        <br>
                                        <?= $res['email'] ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-8 form-floating mb-3">
                                        <input type="text" class="form-control" id="userEditStreet"
                                               value="<?= $res['street'] ?>"
                                               required>
                                        <label for="userEditStreet">Straat*</label>
                                    </div>
                                    <div class="col-12 col-md-4 form-floating mb-3">
                                        <input type="number" min="0" class="form-control" id="userEditNumber"
                                               value="<?= $res['number'] ?>" required>
                                        <label for="userEditNumber">Huisnummer*</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 form-floating mb-3">
                                        <input type="text" class="form-control" id="userEditZipcode"
                                               value="<?= $res['zipcode'] ?>" required>
                                        <label for="userEditZipcode">Postcode*</label>
                                    </div>
                                    <div class="col-12 col-md-6 form-floating mb-3">
                                        <input type="text" class="form-control" id="userEditCity"
                                               value="<?= $res['city'] ?>"
                                               required>
                                        <label for="userEditCity">Plaats*</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 form-floating mb-3">
                                        <input type="text" class="form-control" id="userEditPhone"
                                               value="<?= $res['phone'] ?>"
                                               required>
                                        <label for="userEditPhone">Telefoon*</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 form-floating mb-3">
                                        <input type="text" class="form-control" id="userEditCompany"
                                               value="<?= $res['company'] ?>">
                                        <label for="userEditCompany">Bedrijf</label>
                                    </div>
                                    <div class="col-12 col-md-6 form-floating mb-3">
                                        <input type="number" class="form-control" id="userEditKvk"
                                               value="<?= $res['kvk'] ?>">
                                        <label for="userEditKvk">KvK</label>
                                    </div>
                                </div>
                                <input type="hidden" id="userEditUser" value="<?= $userID ?>">

                                <button class="btn btn-main" type="button" onclick="checkUserEdit()">
                                    Opslaan
                                </button>
                            </div>
                        </div>
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
