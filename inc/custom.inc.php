<?php
if (!empty($_SESSION['message'])) {
    echo '<script>toastr.info("' . $_SESSION['message'] . '")</script>';
    unset($_SESSION['message']);
}
?>
<title>Office Op Maat</title>
<!--Header-->
<div class="container-fluid p-0">
    <div class="header mb-3" style="background: url('img/header-custom.webp') no-repeat right 75% bottom 48%;">
        <div class="text align-middle">
            <div class="container">
                <h2 class="font-monospace text-uppercase">
                    Maatwerk
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="container p-3">
    <div class="row my-3">
<!--        <h1>Office Op Maat</h1>-->
        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium illum incidunt itaque labore
            nobis. Aspernatur autem beatae, dignissimos est optio quam quis repudiandae tenetur? Distinctio ex nisi
            optio, placeat rem repellendus temporibus ut. Aperiam assumenda corporis cumque debitis dignissimos ea
            eligendi, esse excepturi, expedita impedit in nihil perspiciatis placeat! At eius suscipit voluptatum?
            Accusamus dolore eaque fugiat inventore maxime quibusdam soluta vero. Aspernatur consequatur distinctio
            doloribus facilis ipsa labore maxime nulla possimus quis, rerum sequi sunt ullam voluptatibus! Aliquam
            aliquid hic libero quidem voluptatum? Adipisci aperiam beatae dolor hic id nihil omnis sapiente vitae.
            Corporis cumque maiores quam quis voluptates.
        </p>
    </div>

    <div class="row my-3">
        <div class="col-lg-8 col-md-10 col-sm-12 mx-auto contact">
            <div class="my-2 text-center">
                <h5>Wilt u klant worden of heeft u een vraag over office op maat?</h5>
                <p>Vul dan onderstaand formulier in wij nemen contact met u op!</p>
            </div>
            <form method="post" id="customForm">
                <div class="row">
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
                        <input type="text" class="form-control" name="phone" id="floatingPhone" placeholder="Mobiel"
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
                <button type="button" class="btn btn-second" onclick="checkCustomForm()">Verzenden</button>
            </form>
        </div>
    </div>

</div>