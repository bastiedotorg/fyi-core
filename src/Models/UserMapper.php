<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

namespace App\Models;


class UserMapper extends DatabaseMapper
{
    private string $table = "users";
    public function getUser($username)
    {
        $data = $this->Get($this->table, "`username`='$username'");
        if ($data)
            return $this->map($data);
        else
            return false;
    }

    public function getAccountSum($where=null) {
        $query = "SELECT SUM(`balance`) AS balance_sum from `$this->table`";
        if($where)
            $query .= " WHERE $where";

        return $this->QuerySingle($query)["balance_sum"];
    }
    public function getCount($where=null) {
        $query = "SELECT COUNT(`username`) AS user_count from `$this->table`";
        if($where)
            $query .= " WHERE $where";

        return $this->QuerySingle($query)["user_count"];

    }

    public function deleteUser($username) {
        return $this->Delete($this->table, "`username` = '$username'");
    }

    public function setUserLogin($username)
    {
        return $this->Update($this->table, array("date_last_login" => time()), "`username` = '$username'");
    }

    public function getUsers()
    {
        return $this->List($this->table, "1=1");
    }

    public function map($data): User
    {
        $obj = new User();
        return $obj
            ->setId($data['id'])
            ->setUsername($data['username'])
            ->setBalance($data['balance'])
            ->setRegistrationDate($data['date_registered'])
            ->setUserStatus($data['status'])
            ->setSecretUserInformation($data['information_user_secret'])
            ->setUserInformation($data['information_user'])
            ->setLastLogin($data['date_last_login']);
    }

    public function createUser($username): User
    {
        $item = $this->Insert("users", array("username" => $username, "date_registered" => time()));
        return $this->map($item);
    }

    public function alterUser($username, $values)
    {
        return $this->Update("users", $values, "username='$username'", true);
    }

    public function addBalanceToUser($username, $add_value)
    {
        return $this->Update("users", array("balance" => "balance+$add_value"), "username='$username'");
    }
    public function takeFundsFromUser($username, $add_value): \SQLite3Result
    {
        return $this->Update("users", array("balance" => "balance-$add_value"), "username='$username' AND `balance` > '$add_value'");
    }
    public function createTable()
    {
        $this->db->query("CREATE TABLE `users` (
	`username` VARCHAR(100) NOT NULL,
	`balance` DECIMAL NOT NULL DEFAULT '0',
	`date_last_login` TIMESTAMP,
	`date_registered` TIMESTAMP,
	`information_user` VARCHAR(255) NOT NULL DEFAULT '',
	`information_user_secret` VARCHAR(255) NOT NULL DEFAULT '',
	`status` INT NOT NULL DEFAULT '0'
);");
    }
}