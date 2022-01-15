<?php

namespace App;

use App\Core\DB\Connection;
use App\Models\Genre;
use App\Models\Movie;
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

    public static function checkIfGenreExists($genre) {
        $genre = Genre::getOneByUniqueColumn('g_name', $genre);
        if($genre) {
            return $genre;
        } else {
            return false;
        }
    }

    public static function checkIfMovieExists($title, $release) {
        $titles = Movie::getAll("m_title = ?", [$title]);
        $releases = Movie::getAll("m_release = ?", [$release]);
        foreach ($titles as $title) {
            foreach ($releases as $release) {
                if($title->getId() == $release->getId()){
                    return $title;
                }
            }
        }
        return false;
    }

}