<?php

namespace App;

use App\Core\DB\Connection;
use App\Models\Pouzivatel;

class DatabaseValidator
{
    public static function checkIfUserExists($login) {
        $user = Pouzivatel::getOneByColumn('u_login', $login);
        if($user) {
            return $user;
        } else {
            return false;
        }
    }
}