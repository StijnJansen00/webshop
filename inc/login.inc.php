<title>Inloggen</title>
<div class="container" style="min-height: 32rem">
    <div class="d-flex justify-content-center">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                <div class="brand_logo_container">
                    <img loading="lazy" src="img/favicon.png"
                         class="brand_logo" alt="Logo">
                </div>
            </div>
            <div class="d-flex justify-content-center form_container mb-3">
                <form action="php/login.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="username" id="usernameLogin"
                               placeholder="Gebruikersnaam" required>
                        <label for="usernameLogin">Gebruikersnaam</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="password" id="passwordLogin"
                               placeholder="Wachtwoord" required>
                        <label for="passwordLogin">Wachtwoord</label>
                    </div>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button type="submit" name="submit" class="btn login_btn">Inloggen</button>
                    </div>
                </form>
            </div>

            <a class="text-center text-second text-decoration-none mb-3" href="register">Nog geen account?</a>

            <a class="text-center text-second text-decoration-none mb-3" href="password_forget">Wachtwoord vergeten</a>

        </div>
    </div>
</div>


<!--<div class="container p-2">-->
<!---->
<!--    <div class="card mx-auto my-5 login">-->
<!---->
<!--        <div class="card-body">-->
<!--            <div class="row">-->
<!--                <img loading="lazy" class="mx-auto" src="img/favicon.png" style="max-width: 5rem" alt="">-->
<!--            </div>-->
<!--            <form action="php/login.php" method="post">-->
<!--                <h4 class="card-title pt-2 text-center text-uppercase font-monospace text-main">Inloggen</h4>-->
<!--                <div class="form-floating mb-3">-->
<!--                    <input type="text" class="form-control" name="username" id="usernameLogin"-->
<!--                           placeholder="Gebruikersnaam" required>-->
<!--                    <label for="usernameLogin">Gebruikersnaam</label>-->
<!--                </div>-->
<!--                <div class="form-floating mb-3">-->
<!--                    <input type="password" class="form-control" name="password" id="passwordLogin"-->
<!--                           placeholder="Wachtwoord" required>-->
<!--                    <label for="passwordLogin">Wachtwoord</label>-->
<!--                </div>-->
<!--                <button class="mx-auto btn btn-main" type="submit" name="submit" value="login">-->
<!--                    Login-->
<!--                </button>-->
<!--            </form>-->
<!--        </div>-->
<!---->
<!--        <a class="text-center text-second text-decoration-none mb-3" href="register">Nog geen account?</a>-->
<!---->
<!--        <a class="text-center text-second text-decoration-none mb-3" href="password_forget">Wachtwoord vergeten</a>-->
<!---->
<!--    </div>-->
<!---->
<!--</div>-->