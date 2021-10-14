<title>Wachtwoord vergeten</title>

<div class="container p-2">
    <div class="card mx-auto my-5 login">
        <div class="card-body">
            <form action="php/password_forget.php" method="post">
                <h4 class="card-title pb-3 text-center text-uppercase font-monospace text-main">Wachtwoord Vergeten</h4>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="username" id="username"
                           placeholder="Gebruikersnaam" required>
                    <label for="username">Gebruikersnaam</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="email" id="email"
                           placeholder="Email" required>
                    <label for="email">Email</label>
                </div>
                <button class="mx-auto btn btn-main" type="submit" name="submit">
                    Wachtwoord Aanvragen
                </button>
            </form>
        </div>
    </div>
</div>