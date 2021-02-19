<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */


namespace App\Hooks;


class Base
{
    protected static ?Base $_instance = null;

    public static function getInstance(): ?Base
    {
        if(self::$_instance===null) {
            self::$_instance = new static();
        }
        return self::$_instance;
    }
    public function run($hook_point, $params)
    {
        return $params;
    }
}