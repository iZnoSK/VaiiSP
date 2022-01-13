<?php

namespace App;

use App\Core\DB\Connection;
use App\Models\Pouzivatel;

class DatabaseValidator
{
    public static function checkIfUserExists($login) {
        $user = Pouzivatel::getOneByUniqueColumn('u_login', $login);
        if($user) {
            return $user;
        } else {
            return false;
        }
    }

    public static function checkIfEmailExists($email) {
        $user = Pouzivatel::getOneByUniqueColumn('u_email', $email);
        if($user) {
            return $user;
        } else {
            return false;
        }
    }

}