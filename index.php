<?php
session_start();

if (isset($_GET['page'])) {
    $page = $_GET["page"];
} else {
    $page = "home";
}

$file = "https://4youoffice.nl/inc/" . $page . ".inc.php";
$file_headers = @get_headers($file);

if (!$file_headers || $file_headers[0] === 'HTTP/1.1 404 Not Found') {
    $page = '404';
}
?>
<!DOCTYPE html>
<html lang="nl-NL">
<head>
    <!--Meta Tags Overall-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="4YouOffice - Alles voor op kantoor">
    <meta name="description"
          content="Alles voor op kantoor vind je bij 4YouOffice! Bestel vandaag nog een werkplek voor jouw medewerker!">
    <meta name="keywords" content="kantoor, artikelen, papier, schoolspullen, bureau, stoel">
    <meta name="robots" content="index, follow">
    <!--    Meta Tags Facebook-->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://4youoffice.nl/">
    <meta property="og:title" content="4YouOffice - Alles voor op kantoor">
    <meta property="og:description"
          content="Alles voor op kantoor vind je bij 4YouOffice! Bestel vandaag nog een werkplek voor jouw medewerker!">
    <meta property="og:image" content="https://4youoffice.nl/img/favicon.png">
    <!--Favicon-->
    <link rel="shortcut icon" type="image/jpg" href="img/favicon.png">
    <!--CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
            integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="js/head.js"></script>
    <script src="js/admin.js"></script>
    <!--Own CSS-->
    <link href="css/style.css" rel="stylesheet">
    <!--Canonical Link-->
    <link rel="canonical" content="https://4youoffice.nl/">
</head>
<body>
<script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "preventDuplicates": true,
        "onclick": null,
        "timeOut": "5000",
        "extendedTimeOut": "2000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>

<?php
if (!empty($_SESSION['message'])) {
    echo '<script>toastr.info("' . $_SESSION['message'] . '")</script>';
    unset($_SESSION['message']);
}

require 'inc/navbar.inc.php';
require 'inc/' . $page . '.inc.php';
require 'inc/footer.inc.php';

?>
<!--Scripts-->


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"
></script>
<!--Own JavaScript-->
<script src="js/package.js"></script>
<script src="js/register.js"></script>
<script src="js/password.js"></script>
<script src="js/user.js"></script>
<script src="js/cart.js"></script>
<script src="js/contact.js"></script>
<script src="js/send.js"></script>
<script src="js/checkValidity.js"></script>
</body>
</html>