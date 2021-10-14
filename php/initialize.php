<?php

namespace _PhpScoper49d996c9b91b;

use Mollie\Api\MollieApiClient;

\ini_set('display_errors', 1);
\ini_set('display_startup_errors', 1);
\error_reporting(\E_ALL);

require_once __DIR__ . "/../mollie/vendor/autoload.php";
require_once __DIR__ . "/functions.php";


$mollie = new MollieApiClient();
$mollie->setApiKey("test_fRmqPGsCgxemETHz4Gs28BQWa8KwAg");
