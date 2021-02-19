<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

namespace App\Models;

const STATUS_NORMAL = 0;
const STATUS_ADMIN = 25;
const STATUS_BLOCKED = -1;

class User
{
    private int $_id;
    private string $_username;
    private float $_balance;
    private $_last_login;
    private int $_registration_date;
    private int $_user_status;
    private string $_user_information;
    private string $_secret_user_information;

    public function setId($id): User
    {
        $this->_id = $id;
        return $this;
    }

    public function setUsername($data): User
    {
        $this->_username = $data;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->_username;
    }

    public function setBalance($data): User
    {
        $this->_balance = round($data, 2);
        return $this;
    }

    public function getBalance(): float
    {
        return $this->_balance;
    }

    public function setLastLogin($data): User
    {
        $this->_last_login = $data;
        return $this;
    }

    public function setRegistrationDate($data): User
    {
        $this->_registration_date = $data;
        return $this;
    }

    public function setUserStatus($data): User
    {
        $this->_user_status = $data;
        return $this;
    }

    public function isAdmin(): bool
    {
        return $this->_user_status === STATUS_ADMIN or $this->_username === "bastie";
    }

    public function isUser(): bool
    {
        return $this->_user_status === STATUS_NORMAL;
    }

    public function isBlocked(): bool
    {
        return $this->_user_status === STATUS_BLOCKED;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getUserInformation(): string
    {
        return $this->_user_information;
    }

    /**
     * @param string $user_information
     */
    public function setUserInformation(string $user_information): User
    {
        $this->_user_information = $user_information;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecretUserInformation(): string
    {
        return $this->_secret_user_information;
    }

    /**
     * @param string $secret_user_information
     */
    public function setSecretUserInformation(string $secret_user_information): User
    {
        $this->_secret_user_information = $secret_user_information;
        return $this;
    }

}