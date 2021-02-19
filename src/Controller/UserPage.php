<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

namespace App\Controller;


use App\Models\User;
use App\Models\UserMapper;

class UserPage extends Base
{
    protected ?User $user;
    protected ?UserMapper $user_map;

    public function checkPermission(): bool
    {
        $this->user_map = new UserMapper();
        $this->user = $this->user_map->getUser($_SESSION['user']);
        return $this->user->getId() > 0;
    }
}