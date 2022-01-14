<?php

namespace App;

//TODO ci sa zadal dostatocny pocet znakov v hesle (aj na klientovi, aj na serveri)?
//TODO login moze byt max 20 znakov, heslo aspon 8 (aj na klientovi, aj na serveri)
//TODO heslo tiez len cisla a pismena (asi len na serveri)
class FormValidator
{
    //TODO pozriet ako sa robi variabilny pocet premennych, poslat to a v cykle skontrolovat - univerzalne pre vsetky formulare?
    public static function emptyInputSignUp($login, $email, $password, $repeatedPassword) {
        if(empty(trim($login)) || empty(trim($email)) || empty(trim($password)) || empty(trim($repeatedPassword))) {
            return true;
        } else {
            return false;
        }
    }

    public static function emptyInputLogin($login,$password) {
        if(empty(trim($login)) || empty(trim($password))) {
            return true;
        } else {
            return false;
        }
    }

    public static function emptyInputMovie($title, $release, $length, $origin, $description) {
        if(empty(trim($title)) || empty(trim($release)) || empty(trim($length)) || empty(trim($origin)) || empty(trim($description))) {
            return true;
        } else {
            return false;
        }
    }

    public static function isImage($path) {
        $a = getimagesize($path);
        $image_type = $a[2];    //$a[2] has the image type.

        if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
        {
            return true;
        }
        return false;
    }

    //TODO skontrolovat ako sa robia tie regex veci?
    public static function invalidLogin($login) {
        if(!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
            return true;
        } else {
            return false;
        }
    }

    public static function invalidEmail($email) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    public static function notMatchingPasswords($password, $repeatedPassword) {
        if($password !== $repeatedPassword) {
            return true;
        } else {
            return false;
        }
    }

    public static function invalidYear($year) {
        if(!is_numeric($year)) {
            return true;
        } else if ($year < 1900 || $year > 2030) {
            return true;
        } else
            return false;
    }

    public static function invalidLength($length) {
        if(!is_numeric($length)) {
            return true;
        } else if ($length < 1 || $length > 900) {
            return true;
        } else
            return false;
    }

}