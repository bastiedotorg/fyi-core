<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

namespace App\Controller;

use App\Models\ReferralRelationMapper;

class Referral extends UserPage
{

    public function list($data) {
        $map = new ReferralRelationMapper();
        return $this->rest_response(array("status" => 1, "parent"=> $map->getParent($this->user->getId()), "referrals" => $map->getReferralsByParentId($this->user->getId())));
    }

    public function delete_ref($data) {
        $map = new ReferralRelationMapper();
        if($map->deleteRelation($this->user->getId(), intval($_POST['user_id']))) {
            return $this->rest_ok();
        } else {
            return $this->rest_error("Not found");
        }
    }

    public function alter_ref($data) {
        $map = new ReferralRelationMapper();
        if($_POST['ref_back'] > 100 || $_POST['ref_back'] < 0) {
            return $this->rest_error("Invalid value");
        }
        if($map->updateRelation($this->user->getId(), intval($_POST['user_id']), intval($_POST['ref_back']))) {
            return $this->rest_ok();
        } else {
            return $this->rest_error("Not found");
        }
    }
    public function new_parent($data)
    {
        $map = new ReferralRelationMapper();

        // check if user has parent
        if($map->getParent($this->user->getId())) {
            return $this->rest_error("You already have a parent ref");
        } else {
            // fetch user id
            $user = $this->user_map->getUser($_POST['username']);
            if(!$user) {
                return $this->rest_error("User not found");
            }
            $map->createRelation($user->getId(), $this->user->getId());
            return $this->rest_ok();
        }
    }
}