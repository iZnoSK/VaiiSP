<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\ViewResponse;
use App\DatabaseValidator;
use App\FormValidator;
use App\Models\User;

/**
 * Kontroler, ktorý slúži pre prihlásenie, odhlásenie a registráciu používateľa
 * @package App\Controllers
 */
class AuthController extends AControllerRedirect
{
    /**
     * @inheritDoc
     */
    public function index()
    {
        $this->redirect('auth', 'loginForm');
    }

    /** Pomocou metódy sa prejde na formulár prihlásenia používateľa.
     * Ak odoslanie formuláru skončí chybou, tá sa vypíše
     * @return ViewResponse
     */
    public function loginForm()
    {
        // v root.layout.view.php -> c=auth & a=loginForm;
        if (Auth::isLogged()) {
            $this->redirect('home');
        }
        return $this->html(
            [
                'error' => $this->request()->getValue('error')
            ]
        );
    }

    /**
     * Metóda slúži na skontrolovanie vstupov vo formulári pre prihlásenie
     */
    public function login()
    {
        // v loginForm.view.php vo formulári -> c=auth & a=login
        if (Auth::isLogged()) {
            $this->redirect('home');
        }
        $login = trim($this->request()->getValue('loginOfUser'));
        $password = trim($this->request()->getValue('passwordOfUser'));
        if (FormValidator::emptyInput([$login, $password])) {
            $this->redirect('auth', 'loginForm', ['error' => 'Aspoň 1 z polí zostalo prázdne']);
        } else if (FormValidator::invalidTypeOfLogin($login)) {
            $this->redirect('auth', 'loginForm', ['error' => 'Nesprávny formát loginu']);
        } else if(FormValidator::notEnoughChars(3, $login)) {
            $this->redirect('auth', 'loginForm', ['error' => 'Login je príliš krátky']);
        } else if(FormValidator::notEnoughChars(8, $password)) {
            $this->redirect('auth', 'loginForm', ['error' => 'Heslo je príliš krátke']);
        } else if(FormValidator::tooManyChars(20, $login)) {
            $this->redirect('auth', 'loginForm', ['error' => 'Login je príliš dlhý']);
        } else {
            $logged = Auth::login($login, $password);
            if ($logged) {
                $this->redirect('home');
            } else {
                $this->redirect('auth', 'loginForm', ['error' => 'Nesprávny login alebo heslo']);
            }
        }
    }

    /** Pomocou metódy sa prejde na formulár zaregistrovania používateľa.
     * Ak odoslanie formuláru skončí chybou, tá sa vypíše
     * @return ViewResponse
     */
    public function signUpForm()
    {
        // v root.layout.view.php -> c=auth & a=signUpForm
        if (Auth::isLogged()) {
            $this->redirect('home');
        }
        return $this->html(
            [
                'error' => $this->request()->getValue('error')
            ]
        );
    }

    /**
     * Metóda slúži na skontrolovanie vstupov vo formulári pre prihlásenie
     * @throws \Exception
     */
    public function signUp()
    {
        // v signUp.view.php vo formulári -> c=auth & a=signUp
        if (Auth::isLogged()) {
            $this->redirect('home');
        }
        $login = trim($this->request()->getValue('loginOfUser'));
        $email = trim($this->request()->getValue('emailOfUser'));
        $password = trim($this->request()->getValue('passwordOfUser'));
        $repeatedPassword = trim($this->request()->getValue('repeatedPasswordOfUser'));

        if (FormValidator::emptyInput([$login, $email, $password, $repeatedPassword])) {
            $this->redirect('auth', 'signUpForm', ['error' => 'Aspoň 1 z polí zostalo prázdne']);
        } else if (FormValidator::invalidTypeOfLogin($login)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'Nesprávny formát loginu']);
        } else if (FormValidator::invalidEmail($email)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'Nesprávny formát e-mailu']);
        } else if(FormValidator::notEnoughChars(3, $login)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'Login je príliš krátky']);
        } else if(FormValidator::notEnoughChars(8, $password)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'Heslo je príliš krátke']);
        } else if(FormValidator::tooManyChars(20, $login)) {
            $this->redirect('auth', 'loginForm', ['error' => 'Login je príliš dlhý']);
        } else if (FormValidator::notMatchingPasswords($password, $repeatedPassword)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'Heslá sa nezhodujú']);
        } else if (DatabaseValidator::checkIfUserExists($login)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'Login je už zabraný']);
        } else if (DatabaseValidator::checkIfEmailExists($email)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'E-mail je už zabraný']);
        } else {
            if (isset($_FILES['fileOfUser']) && FormValidator::isImage($_FILES['fileOfUser']['tmp_name'])) {
                if ($_FILES["fileOfUser"]["error"] == UPLOAD_ERR_OK) {
                    $nameOfFile = date('Y-m-d-H-i-s_') . basename($_FILES['fileOfUser']['name']);
                    move_uploaded_file($_FILES['fileOfUser']['tmp_name'], "public/files/userImages/" . "$nameOfFile");
                }
            } else {
                $this->redirect('auth', 'signUpForm', ['error' => 'Problém s obrázkom']);
                exit;
            }
            $newUser = new User();
            $newUser->setLogin($login);
            $newUser->setEmail($email);
            $newUser->setImg($nameOfFile);
            $newUser->setPassword(Auth::hashPassword($password));
            $newUser->save();
            $logged = Auth::login($login, $password);
            if ($logged) {
                $this->redirect('home');
            } else {
                $this->redirect('auth', 'signUpForm', ['error' => 'Nepodarilo sa prihlásiť']);
            }
        }
    }

    /**
     * Metóda slúži na odhlásenie používateľa
     */
    public function logout()
    {
        // v root.layout.view.php na tlačítku -> c=auth & a=logout
        if (Auth::isLogged()) {
            Auth::logout();
        }
        $this->redirect('home');
    }
}