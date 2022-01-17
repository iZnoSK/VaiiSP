<?php

namespace App;

use App\Models\Creator;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;

/**
 * Trieda ponúka pomocné služby v DB
 * @package App
 */
class DatabaseValidator
{
    /** Skontroluje, či sa v DB používateľ s daným loginom nachádza, ak áno, vráti ho, ak nie, vráti false
     * @param $login
     * @return User|false
     * @throws \Exception
     */
    public static function checkIfUserExists($login) {
        $user = User::getAll('u_login = ?', [$login]);
        if($user) {
            return $user[0];
        } else {
            return false;
        }
    }

    /** Skontroluje, či sa v DB používateľ s daným emailom nachádza, ak áno, vráti ho, ak nie, vráti false
     * @param $email
     * @return User|false
     * @throws \Exception
     */
    public static function checkIfEmailExists($email) {
        $user = User::getAll('u_email = ?', [$email]);
        if($user) {
            return $user[0];
        } else {
            return false;
        }
    }

    /** Skontroluje, či sa v DB žáner s daným názvom nachádza, ak áno, vráti ho, ak nie, vráti false
     * @param $genre
     * @return Genre|false
     * @throws \Exception
     */
    public static function checkIfGenreExists($genre) {
        $genre = Genre::getAll('g_name = ?', [$genre]);
        if($genre) {
            return $genre[0];
        } else {
            return false;
        }
    }

    /** Skontroluje, či sa v DB film s daným názvom a rokom vydania nachádza, ak áno, vráti ho, ak nie, vráti false
     * @param $title
     * @param $release
     * @return Movie|false
     * @throws \Exception
     */
    public static function checkIfMovieExists($title, $release) {
        $movie = Movie::getAll('m_title = ? AND m_release = ?', [$title, $release]);
        if($movie) {
            return $movie[0];
        }
        return false;
    }


    /** Skontroluje, či sa v DB tvorca s daným meno, priezviskom a dátum narodenia nachádza, ak áno, vráti ho, ak nie, vráti false
     * @param string $name
     * @param string $surname
     * @param string $dateOfBirth
     * @return Creator|false
     * @throws \Exception
     */
    public static function checkIfCreatorExists(string $name, string $surname, string $dateOfBirth)
    {
        $creator = Creator::getAll("c_name = ? AND c_surname = ? AND c_date_of_birth = ?", [$name, $surname, $dateOfBirth]);
        if($creator) {
            return $creator[0];
        }
        return false;
    }
}