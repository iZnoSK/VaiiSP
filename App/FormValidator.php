<?php

namespace App;

//TODO ci sa zadal dostatocny pocet znakov v hesle (aj na klientovi, aj na serveri)?
//TODO login moze byt max 20 znakov, heslo aspon 8 (aj na klientovi, aj na serveri)
//TODO heslo tiez len cisla a pismena (asi len na serveri)
class FormValidator
{
    public static function invalidTypeOfLogin($login) {
        if(!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
            return true;
        } else {
            return false;
        }
    }

    public static function invalidTypeOfWord($input)
    {
        if(!preg_match("/^[a-zA-ZáéíýúäôľščťžňďěřůÁÉÍÝÚĽŠČŤŽŇĎĚŘŮ\s]*$/i", $input)) {
            return true;
        }
        return false;
    }

    public static function notEnoughChars($numberOfCharacters, $input) {
        if(strlen($input) < $numberOfCharacters) {
            return true;
        }
        return false;
    }

    public static function tooManyChars($numberOfCharacters, $input) {
        if(strlen($input) > $numberOfCharacters) {
            return true;
        }
        return false;
    }

    public static function emptyInput(array $inputs) {
        foreach ($inputs as $input) {
            if(empty($input)) {
                return true;
            }
        }
        return false;
    }

    //TODO pozriet ako sa robi variabilny pocet premennych, poslat to a v cykle skontrolovat - univerzalne pre vsetky formulare?
    public static function emptyInputSignUp($login, $email, $password, $repeatedPassword) {
        if(empty($login) || empty($email) || empty($password) || empty($repeatedPassword)) {
            return true;
        } else {
            return false;
        }
    }

    public static function emptyInputLogin($login,$password) {
        if(empty($login) || empty($password)) {
            return true;
        } else {
            return false;
        }
    }

    public static function emptyInputMovie($title, $release, $length, $origin, $description) {
        if(empty($title) || empty($release) || empty($length) || empty($origin) || empty($description)) {
            return true;
        } else {
            return false;
        }
    }

    public static function emptyInputReview($review) {
        if(empty($review)) {
            return true;
        } else {
            return false;
        }
    }

    public static function emptyInputGenre($genre) {
        if(empty($genre)) {
            return true;
        } else {
            return false;
        }
    }

    public static function emptyInputCreator($name, $surname, $dateOfBirth, $placeOfBirth, $role, $biography) {
        if(empty($name) || empty($surname) || empty($dateOfBirth) || empty($placeOfBirth) || empty($role) || empty($biography)) {
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

    public static function invalidRating($percentage) {
        if(!is_numeric($percentage)) {
            return true;
        } else if ($percentage < 1 || $percentage > 100) {
            return true;
        } else
            return false;
    }
}