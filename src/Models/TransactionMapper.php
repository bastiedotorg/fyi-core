<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

namespace App\Models;


class TransactionMapper extends DatabaseMapper
{

    public function map($data): Transaction
    {
        $obj = new Transaction();
        return $obj
            ->setId($data['id'])
            ->setUserId($data['user_id'])
            ->setAmount($data['amount'])
            ->setSubject($data['subject'])
            ->setDate($data['date_transfer']);
    }

    public function createTransaction($user_id, $amount, $subject, $transaction_type): Transaction
    {
        $item = $this->Insert("transactions", array("user_id" => $user_id, "amount" => $amount, "subject" => $subject, "date_transfer" => time(), "transaction_type" => $transaction_type));
        return $this->map($item);
    }

    public function getTransactions(): array
    {
        return $this->QueryList("SELECT a.*, b.username FROM transactions AS a LEFT JOIN users AS b ON a.user_id = b.rowid ORDER BY date_transfer DESC");
    }

    public function createTable()
    {
        $this->db->query("CREATE TABLE `transactions` (
	`user_id` INT NOT NULL,
	`transaction_type` INT NOT NULL,
	`amount` DECIMAL NOT NULL DEFAULT '0',
	`subject` VARCHAR(255) NOT NULL,
	`date_transfer` TIMESTAMP
);");
    }
}