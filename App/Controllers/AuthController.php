<?php

namespace App\Controllers;

use App\Auth;
use App\DatabaseValidator;
use App\FormValidator;
use App\Models\Pouzivatel;

// TODO rozdelit na 2 controllery? signUp a login
class AuthController extends AControllerRedirect
{
    /**
     * @inheritDoc
     */
    public function index()
    {
        $this->redirect('auth', 'loginForm');        //TODO redirect inde? chybová stránka? home?
    }

    // v root.layout.view.php v navbare na tlačítku -> c=auth & a=loginForm;
    // ak zavoláme login a pouzivatel zada zly login alebo heslo, tak redirectujeme spat na loginForm
    // a ten error je len odtial
    public function loginForm()
    {
        if (Auth::isLogged()) {
            $this->redirect('home');
        }
        return $this->html(
            [
                'error' => $this->request()->getValue('error')
            ]
        );
    }

    // v loginForm.view.php vo formulári -> c=auth & a=login
    public function login()
    {
        //TODO URL check?
        //v input posielame login a password
        $login = trim($this->request()->getValue('loginOfUser'));
        $password = trim($this->request()->getValue('passwordOfUser'));
         if(FormValidator::emptyInputLogin($login, $password)) {
             $this->redirect('auth', 'loginForm', ['error' => 'Aspoň 1 z polí zostalo prázdne']);
         } else if(FormValidator::invalidLogin($login)) {
             $this->redirect('auth', 'loginForm', ['error' => 'Nesprávny formát loginu']);
         } else {
            $logged = Auth::login($login, $password);
            if ($logged) {
                $this->redirect('home');
            } else {
                $this->redirect('auth', 'loginForm', ['error' => 'Nesprávny login alebo heslo']);
            }
        }
    }

    // v root.layout.view.php v navbare na tlačítku -> c=auth & a=signUpForm
    public function signUpForm()
    {
        if (Auth::isLogged()) {
            $this->redirect('home');
        }
        return $this->html(
            [
                'error' => $this->request()->getValue('error')
            ]
        );
    }

    // v signUp.view.php vo formulári -> c=auth & a=signUp
    public function signUp()
    {
        //TODO upratať! krajšie spraviť
        //TODO URL check?
        //v input posielame login, email, password 2krát
        $login = trim($this->request()->getValue('loginOfUser'));
        $email = trim($this->request()->getValue('emailOfUser'));
        //$poster = $this->request()->getValue('fileOfUser');
        $password = trim($this->request()->getValue('passwordOfUser'));
        $repeatedPassword = trim($this->request()->getValue('repeatedPasswordOfUser'));

        if (FormValidator::emptyInputSignUp($login, $email, $password, $repeatedPassword)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'Aspoň 1 z polí zostalo prázdne']);
        } else if(FormValidator::invalidLogin($login)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'Nesprávny formát loginu']);
        } else if(FormValidator::invalidEmail($email)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'Nesprávny formát e-mailu']);
        } else if(FormValidator::notMatchingPasswords($password, $repeatedPassword)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'Heslá sa nezhodujú']);
        } else if(DatabaseValidator::checkIfUserExists($login)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'Login je už zabraný']);
        } else if(DatabaseValidator::checkIfEmailExists($email)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'E-mail je už zabraný']);
        } else {
            if (isset($_FILES['fileOfUser']) && FormValidator::isImage($_FILES['fileOfUser']['tmp_name'])) {
                if ($_FILES["fileOfUser"]["error"] == UPLOAD_ERR_OK) {
                    //uloženie obrázku
                    $nameOfFile = date('Y-m-d-H-i-s_') . basename($_FILES['fileOfUser']['name']);
                    move_uploaded_file($_FILES['fileOfUser']['tmp_name'], "public/files/userImages/" . "$nameOfFile");
                }
            } else {
                $this->redirect('auth', 'signUpForm', ['error' => 'Problém s obrázkom']);
                exit;
            }
            //TODO sql injection
            $newUser = new Pouzivatel();
            $newUser->setLogin($login);
            $newUser->setEmail($email);
            $newUser->setImg($nameOfFile);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);   //TODO asi presunut hashovanie do Auth?
            $newUser->setPassword($hashedPassword);
            $newUser->save();
            $logged = Auth::login($login, $password);
            if ($logged)
            {
                $this->redirect('home');
            } else {
                //TODO ak sa nepodari prihlasit? asi netreba, neviem
            }
        }
    }

    // v root.layout.view.php na tlačítku -> c=auth & a=logout
    public function logout()
    {
        if (Auth::isLogged()) {
            Auth::logout();
        }
        $this->redirect('home');
    }
}