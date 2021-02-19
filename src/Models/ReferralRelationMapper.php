<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */


namespace App\Models;


class ReferralRelationMapper extends DatabaseMapper
{
    protected string $table = "referral_relation";
    public function getReferralsByParentId($user_id): array
    {
        return $this->QueryList("SELECT a.*, b.username FROM `$this->table` AS a LEFT JOIN users AS b ON a.child_id = b.rowid
                                        WHERE a.parent_id = '$user_id'
                                        ORDER BY b.username ASC");
    }

    public function map($data): ReferralRelation
    {
        $obj = new ReferralRelation();
        return $obj
            ->setId($data['id'])
            ->setParent($data['parent_id'])
            ->setAmountTotal($data['amount_total'])
            ->setAmountIndividual($data['amount_individual'])
            ->setChild($data['child_id']);
    }

    public function deleteRelation(int $parent_id, int $child_id, int $level=1) {
        return $this->Delete($this->table, "`parent_id`=$parent_id AND `child_id`=$child_id AND `level`=$level");
    }
    public function updateRelation(int $parent_id, int $child_id, int $ref_back, int $level=1) {
        return $this->Update($this->table, array("ref_back" => $ref_back), "`parent_id`=$parent_id AND `child_id`=$child_id AND `level`=$level");
    }
    public function createRelation($parent_id, $child_id): ReferralRelation
    {
        $item = $this->Insert($this->table, array("parent_id" => $parent_id, "child_id" => $child_id, "level" => 1));
        return $this->map($item);
    }
    public function getUsersWithReferral(): array
    {
        return $this->QueryList("SELECT a.*, b.*, c.username as ref_name FROM users AS a LEFT JOIN `$this->table` AS b ON a.rowid = b.child_id
                                        LEFT JOIN users AS c ON b.parent_id = c.rowid
                                        ORDER BY a.username ASC");
    }

    public function getParent($child_id)
    {
        return $this->QuerySingle("SELECT a.*, b.username FROM `$this->table` AS a 
                                          LEFT JOIN `users` AS b ON a.parent_id=b.rowid 
                                          WHERE a.child_id=$child_id LIMIT 1");

    }

    public function createTable()
    {
        $this->db->query("CREATE TABLE `$this->table` (
	`parent_id` INT NOT NULL,
	`child_id` INT NOT NULL,
	`level` INT NOT NULL,
	`amount_total` DECIMAL NOT NULL DEFAULT '0',
	`amount_individual` DECIMAL NOT NULL DEFAULT '0',
	`ref_back` INT NOT NULL DEFAULT '0',
	`last_reset` TIMESTAMP
);");
    }
}