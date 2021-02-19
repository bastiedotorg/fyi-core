<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

namespace App\Controller;

use App\Services\PackageService;

class AdminPackager extends AdminPage
{
    public function list($data) {
        $packageService = new PackageService();
        return $this->rest_response(array("status"=>1, "packages" => $packageService->listAvailablePackages()));
    }

    public function detail($data) {
        $packageService = new PackageService();
        $info = $packageService->infoPackage($data[2])->checkFiles();
        return $this->rest_response(["status" => 1, "package" => $info]);
    }
}