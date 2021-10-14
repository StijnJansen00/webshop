<title>Contact</title>
<!--Header-->
<div class="container-fluid p-0">
    <div class="header mb-3" style="background: url('img/header-contact.webp') no-repeat right 40% bottom 43%;">
        <div class="text align-middle">
            <div class="container">
                <h2 class="font-monospace text-uppercase">
                    Klantenservice
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="container p-3">
    <div class="row my-3">
        <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
            <p>
                Heeft u een vraag over uw bestelling? Of over een bepaald product? Of misschien een klacht? Het team van
                4YouOffice helpt u graag zo goed mogelijk vooruit. We bijten niet, dus neem gerust contact op.
            </p>
        </div>
    </div>

    <div class="row my-3">
        <div class="col-lg-8 col-md-10 col-sm-12 mx-auto contact">
            <h4 class="red mb-3 text-center">Contact</h4>
            <form method="post" action="" id="contactForm">
                <div class="row">
                    <a href="#klantenservice"></a>
                    <div class="col-12 col-md-6 form-floating mb-3">
                        <input type="text" class="form-control" name="name" id="floatingName" placeholder="Naam"
                               required>
                        <label for="floatingName">Naam</label>
                    </div>
                    <div class="col-12 col-md-6 form-floating mb-3">
                        <input type="text" class="form-control" name="companyName" id="floatingCompanyName"
                               placeholder="bedrijfsnaam" required>
                        <label for="floatingCompanyName">Bedrijfsnaam</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="floatingEmail" placeholder="Email"
                               required>
                        <label for="floatingEmail">Email</label>
                    </div>
                    <div class="col-12 col-md-6 form-floating mb-3">
                        <input type="tel" class="form-control" name="phone" id="floatingPhone" placeholder="Mobiel"
                               required>
                        <label for="floatingPhone">Tel</label>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-floating">
                        <textarea id="floatingMessage" class="form-control" placeholder="Bericht" style="height: 9rem"
                                  name="message" required></textarea>
                        <label for="floatingMessage">Bericht</label>
                    </div>
                </div>
                <button class="btn btn-second" type="button" onclick="checkContactForm()">Verzenden</button>
            </form>
        </div>
    </div>

</div>
