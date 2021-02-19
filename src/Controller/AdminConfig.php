<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

namespace App\Controller;


use App\Models\ConfigMapper;

class AdminConfig extends AdminPage
{

    public function get($data) {
        $map = new ConfigMapper();
        return $this->rest_response(array("status" =>1, "items" => $map->getGrouped()));

    }

    public function set($data) {
        $map = new ConfigMapper();
        $map->storeConfigData($_POST);
        return $this->rest_response(array("status" => 1));
    }
}