<?php

// scoper-composer-autoload.php @generated by PhpScoper

$loader = require_once __DIR__.'/composer-autoload.php';

// Aliases for the whitelisted classes. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#class-whitelisting
if (!class_exists('ComposerAutoloaderInit527c1e1e3bf712cbbc43a48f87e93709', false) && !interface_exists('ComposerAutoloaderInit527c1e1e3bf712cbbc43a48f87e93709', false) && !trait_exists('ComposerAutoloaderInit527c1e1e3bf712cbbc43a48f87e93709', false)) {
    spl_autoload_call('_PhpScoper49d996c9b91b\ComposerAutoloaderInit527c1e1e3bf712cbbc43a48f87e93709');
}

// Functions whitelisting. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#functions-whitelisting
if (!function_exists('database_write')) {
    function database_write() {
        return \_PhpScoper49d996c9b91b\database_write(...func_get_args());
    }
}
if (!function_exists('database_read')) {
    function database_read() {
        return \_PhpScoper49d996c9b91b\database_read(...func_get_args());
    }
}
if (!function_exists('printOrders')) {
    function printOrders() {
        return \_PhpScoper49d996c9b91b\printOrders(...func_get_args());
    }
}

return $loader;
