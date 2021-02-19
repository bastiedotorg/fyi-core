<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

namespace App\Models;


class ReferralRelation
{
    protected $_id;
    protected $_parent;
    protected $_child;
    protected $_amount_total;
    protected $_amount_individual;


    /**
     * @param mixed $parent
     */
    public function setParent($parent): ReferralRelation
    {
        $this->_parent = $parent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChild()
    {
        return $this->_child;
    }

    /**
     * @param mixed $child
     */
    public function setChild($child): ReferralRelation
    {
        $this->_child = $child;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmountTotal()
    {
        return $this->_amount_total;
    }

    /**
     * @param mixed $amount_total
     */
    public function setAmountTotal($amount_total): ReferralRelation
    {
        $this->_amount_total = $amount_total;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmountIndividual()
    {
        return $this->_amount_individual;
    }

    /**
     * @param mixed $amount_individual
     */
    public function setAmountIndividual($amount_individual): ReferralRelation
    {
        $this->_amount_individual = $amount_individual;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): ReferralRelation
    {
        $this->_id = $id;
        return $this;
    }
}