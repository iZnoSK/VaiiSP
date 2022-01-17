<?php

namespace App;

use App\Models\Creator;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;

class DatabaseValidator
{
    public static function checkIfUserExists($login) {
        $user = User::getAll('u_login = ?', [$login]);
        if($user) {
            return $user[0];
        } else {
            return false;
        }
    }

    public static function checkIfEmailExists($email) {
        $user = User::getAll('u_email = ?', [$email]);
        if($user) {
            return $user[0];
        } else {
            return false;
        }
    }

    public static function checkIfGenreExists($genre) {
        $genre = Genre::getAll('g_name = ?', [$genre]);
        if($genre) {
            return $genre[0];
        } else {
            return false;
        }
    }

    public static function checkIfMovieExists($title, $release) {
        $movie = Movie::getAll('m_title = ? AND m_release = ?', [$title, $release]);
        if($movie) {
            return $movie[0];
        }
        return false;
    }

    public static function checkIfCreatorExists(string $name, string $surname, string $dateOfBirth)
    {
        $creator = Creator::getAll("c_name = ? AND c_surname = ? AND c_date_of_birth = ?", [$name, $surname, $dateOfBirth]);
        if($creator) {
            return $creator[0];
        }
        return false;
    }
}