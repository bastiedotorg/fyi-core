<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

session_start();

spl_autoload_register(function ($class) {
    $parts = explode("\\", $class);
    if($parts[0] == "App") $parts[0] = "src";
    include implode("/", $parts) . '.php';
});


$app = new App\Server();
$app->route(str_replace($_SERVER['SCRIPT_NAME'], "", $_SERVER['REQUEST_URI']));
