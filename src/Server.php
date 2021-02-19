<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

namespace App;

use App\Services\HookService;

require "config/config.inc.php";
require "config/variable_config.inc.php";
require "constants.php";

class Server
{
    public function __construct()
    {
        $this->register_hooks();
    }

    public function register_hooks()
    {
        $hook = HookService::getInstance();
        foreach(HOOK_CONFIGURATION as $configuration) {
            $objString = "App\\Hooks\\".$configuration['class'];
            $hook->register($configuration['point'], new $objString());
        }
    }

    function route($query_string)
    {
        $modules = explode("/", $query_string);
        $modules = array_values(array_filter($modules, function ($var) {
            return !empty($var);
        }));
        $component = str_replace("_", "", ucwords($modules[0], "_"));


        $className = "App\\Controller\\" . ucfirst($component);
        $component = new $className($modules);

        print($component->run());
    }
}