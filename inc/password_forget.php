<title>Wachtwoord Reset</title>
<div class="container p-2">

    <div class="card mx-auto my-5 login">

        <div class="card-body">
            <form action="php/password_reset.php" method="post">
                <h4 class="card-title pb-3 text-center text-uppercase font-monospace text-main">Wachtwoord Vergeten</h4>
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
                <button class="mx-auto btn btn-main" type="submit" name="submit" value="login">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>