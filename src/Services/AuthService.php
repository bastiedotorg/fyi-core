<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */
namespace App\Services;
use Access;

class AuthService {
    protected string $api_key = CUNEROS_CONFIGURATION['api_key'];
    protected string $project_id = CUNEROS_CONFIGURATION['project_id'];

    protected ?Access $_api = null;
    public function getApi($user, $password): Access
    {
        if($this->_api === null)
            $this->_api = new \Access($password, $user, $this->api_key, $this->project_id);
        return $this->_api;
    }

    public function login($user, $password): bool
    {
        $this->getApi($user, $password)->info();

        return $this->_api->get_error_number() === 0;
    }

    public function withdraw($amount, $subject, $user, $external_id): bool
    {
        $this->getApi($user, "");
        $this->_api->send($amount, $subject, $external_id);
        return $this->_api->get_error_number() === 0;
    }

    public function getError(): string
    {
        return $this->_api->get_error_message();
    }
}
