<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

namespace App\Controller;

class Base
{
    protected array $modules = [];

    public function checkPermission()
    {
        return true;
    }

    public function csrf_check() {
        if($_SERVER['HTTP_X_CSRFTOKEN'] !== $_SESSION['csrf']) {
            die($this->rest_error("CSRF error"));
        }
    }

    public function rest_error($message) {
        return $this->rest_response(array("status" => 0, "message" => $message));
    }

    public function rest_ok() {
        return $this->rest_response(array("status" => 1));
    }

    public function rest_response($data)
    {
        return json_encode($data);
    }

    public function __construct($modules)
    {
        $this->modules = $modules;
    }

    public function default()
    {
        return $this->rest_response(array("message" => "Method not found"));
    }

    public function run()
    {
        if(!$this->checkPermission()) {
            return $this->default();
        }
        $action = $this->modules[1];
        if (is_callable(array($this, $action))) {
            return $this->$action($this->modules);
        } else {
            return $this->default(); //or some kind of error message
        }
    }
}