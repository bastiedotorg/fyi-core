<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

namespace App\Models;


class Transaction
{
    protected int $_user_id;
    protected float $_amount;
    protected string $_subject;
    protected int $_date;
    protected int $_id;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->_user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): Transaction
    {
        $this->_user_id = $user_id;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->_amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): Transaction
    {
        $this->_amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->_subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): Transaction
    {
        $this->_subject = $subject;
        return $this;
    }

    /**
     * @return int
     */
    public function getDate(): int
    {
        return $this->_date;
    }

    /**
     * @param int $date
     */
    public function setDate(int $date): Transaction
    {
        $this->_date = $date;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): Transaction
    {
        $this->_id = $id;
        return $this;
    }

}