<?php

namespace App;

use App\Models\User;

/**
 * Trieda ponúka pomocné služby pri registrácii a prihlásení používateľa
 * @package App
 */
class Auth
{
    /** Metóda slúžiaca pre prihlásenie používateľa
     * @param $login string - meno používateľa
     * @param $password string - heslo používateľa
     * @return bool či sa podarilo alebo nepodarilo prihlásiť
     */
    public static function login(string $login, string $password)
    {
        $user = DatabaseValidator::checkIfUserExists($login);
        if($user) {
            if ($login == $user->getLogin() && self::verifyPassword($password, $user->getPassword()))
            {
                $_SESSION['name'] = $login;
                $_SESSION['id'] = $user->getId();
                return true;
            }
            else
            {
                return false;
            }
        }
        return false;
    }

    /** Metóda, ktorá slúži na zistenie, či je používateľ prihlásený
     * @return bool je používateľ prihlásený
     */
    public static function isLogged()
    {
        return isset($_SESSION['name']);
    }

    /** Metóda vráti používateľské meno, ak je používateľ prihlásený
     * @return mixed|string používateľské meno používateľa
     */
    public static function getName()
    {
        return (Auth::isLogged() ? $_SESSION['name'] : "");
    }

    /** Metóda vráti Id užívateľa v DB, ak je používateľ prihlásený
     * @return mixed|string Id používateľa
     */
    public static function getId()
    {
        return (Auth::isLogged() ? $_SESSION['id'] : "");
    }

    /** Metóda vráti zahashované heslo
     * @param $password
     * @return string
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }

    /**
     * Metóda, pomocou ktorej sa odhlási používateľ
     */
    public static function logout()
    {
        unset($_SESSION['name']);
        unset($_SESSION['id']);
        session_destroy();
    }
}