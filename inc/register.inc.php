<title>Registreren</title>

<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
            <form action="" method="post" id="registerForm">

                <div class="card mx-auto border border-main my-5">
                    <div class="card-body">
                        <h4 class="card-title mb-3 text-center">Registreren</h4>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="username" id="usernameRegister"
                                   placeholder="Gebruikersnaam" required>
                            <label for="usernameRegister">Gebruikersnaam</label>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="password" class="form-control" name="password" id="passwordRegister"
                                       placeholder="Wachtwoord" required>
                                <label for="passwordRegister">Wachtwoord</label>
                            </div>
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="password" class="form-control" name="repeatPassword"
                                       id="repeatPasswordRegister" placeholder="Herhaal wachtwoord" required>
                                <label for="repeatPasswordRegister">Herhaal achtwoord</label>
                            </div>
                        </div>
                        <div id="passwordMessage"></div>
                        <div class="row">
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="text" class="form-control" name="name" id="nameRegister" placeholder="Naam"
                                       required>
                                <label for="nameRegister">Naam</label>
                            </div>
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="text" class="form-control" name="surname" id="surnameRegister"
                                       placeholder="Achternaam" required>
                                <label for="surnameRegister">Achternaam</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="email" class="form-control" name="email" id="emailRegister"
                                       placeholder="Email"
                                       required>
                                <label for="emailRegister">Email</label>
                            </div>
                            <div class="col-12 col-md-6 form-floating mb-3">
                                <input type="text" class="form-control" name="phone" id="phoneRegister"
                                       placeholder="Telefoon" required>
                                <label for="phoneRegister">Telefoon*</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 form-floating mb-3">
                                <input type="text" class="form-control" name="street" id="streetRegister"
                                       placeholder="Straat"
                                       required>
                                <label for="streetRegister">Straat*</label>
                            </div>
                            <div class="col-12 col-md-4 form-floating mb-3">
                                <input type="text" class="form-control" name="number" id="numberRegister"
                                       placeholder="Huisnummer" required>
                                <label for="numberRegister">Huisnr + Hs*</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 form-floating mb-3">
                                <input type="text" class="form-control" name="city" id="cityRegister" placeholder="Stad"
                                       required>
                                <label for="cityRegister">Plaats*</label>
                            </div>
                            <div class="col-12 col-md-4 form-floating mb-3">
                                <input type="text" class="form-control" name="zipcode" id="zipcodeRegister"
                                       placeholder="Postcode" required>
                                <label for="zipcodeRegister">Postcode*</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-7 form-floating mb-3">
                                <input type="text" class="form-control" name="company" id="companyRegister"
                                       placeholder="Bedrijfsnaam">
                                <label for="companyRegister">Bedrijf</label>
                            </div>
                            <div class="col-12 col-md-5 form-floating mb-3">
                                <input type="number" class="form-control" name="kvk" id="kvkRegister" placeholder="KvK">
                                <label for="kvkRegister">KvK</label>
                            </div>
                        </div>

<!--                        <button class="btn btn-main" type="button" onclick="checkRegisterPassword()">-->
                        <button class="btn btn-main" type="button" onclick="checkRegister()">
                            Registreren
                        </button>
                    </div>

                    <a class="text-center text-second text-decoration-none mb-3" href="login">Al een account?</a>

                </div>
            </form>
        </div>
    </div>
</div>

