<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

spl_autoload_register(function ($class) {
    $parts = explode("\\", $class);
    if ($parts[0] == "App") $parts[0] = "src";
    include implode("/", $parts) . '.php';
});
