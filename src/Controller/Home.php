<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

namespace App\Controller;

use App\Models\ReferralRelationMapper;
use App\Models\UserMapper;
use App\Services\AuthService;

class Home extends Base
{

    public function login($data)
    {
        $this->csrf_check();
        #$service = new AuthService();
        #if($service->login($_POST['username'], $_POST['password'])) {
        if(1 == 1) {
            $map = new UserMapper();
            $user = $map->getUser($_POST['username']);
            if (!$user) {
                $user = $map->createUser($_POST['username']);
                if($_POST['referral']) {
                    $rmap = new ReferralRelationMapper();
                    $parent = $map->getUser($_POST['referral']);
                    if($parent)
                        $rmap->createRelation($parent->getId(), $user->getId());
                }
            }
            $map->setUserLogin($_POST['username']);
            $_SESSION['user'] = $_POST['username'];
            $_SESSION['logged_in'] = true;
            return $this->rest_response(array("status" => 1));
        } else {
            $_SESSION['user'] = null;
            $_SESSION['logged_in'] = false;
            return $this->rest_response(array("status" => 0, "message" => "invalid credentials"));
        }
    }

    public function logout($data)
    {
        $this->csrf_check();

        $_SESSION['user'] = null;
        $_SESSION['logged_in'] = false;
        return $this->rest_response(array("status" => 1));
    }

    public function status($data)
    {
        if(!isset($_SESSION['csrf'])) {
            $_SESSION['csrf'] = uniqid("csrf", true);
        }
        if ($_SESSION['logged_in'] === true) {
            $map = new UserMapper();
            $user = $map->getUser($_SESSION['user']);
            if($user) {
                return $this->rest_response(array("status" => 1,
                    "ebesucher_login" => EBESUCHER_CONFIGURATION["login"],
                    "csrfToken" => $_SESSION['csrf'],
                    "user" => array(
                        "username" => $user->getUsername(),
                        "balance" => $user->getBalance(),
                        "is_admin" => $user->isAdmin(),
                        "is_blocked" => $user->isBlocked(),
                        "user_information" => $user->getUserInformation()
                    )));
            }
        }
        return $this->rest_response(array("status" => 0, "message" => "not logged in", "csrfToken" => $_SESSION['csrf']));
    }
}