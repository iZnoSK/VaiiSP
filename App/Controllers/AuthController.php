<?php

namespace App\Controllers;

use App\Auth;
use App\DatabaseValidator;
use App\FormValidator;
use App\Models\Pouzivatel;

class AuthController extends AControllerRedirect
{
    /**
     * @inheritDoc
     */
    public function index()
    {

    }

    // v root.layout.view.php v navbare na tlačítku -> c=auth & a=loginForm
    public function loginForm()
    {
        if (Auth::isLogged()) {
            $this->redirect("home");
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
        //TODO URL check
        //v input posielame login a password
        $login = $this->request()->getValue('loginOfUser');
        $password = $this->request()->getValue('passwordOfUser');
        $logged = Auth::login($login, $password);
        if ($logged)
        {
            $this->redirect('home');
        }
        else
        {
            $this->redirect('auth', 'loginForm', ['error' => 'Zlý e-mail alebo heslo']);
        }
    }

    // v root.layout.view.php v navbare na tlačítku -> c=auth & a=signUpForm
    public function signUpForm()
    {
        if (Auth::isLogged()) {
            $this->redirect("home");
        }
        return $this->html(
            [
                'error' => $this->request()->getValue('error')
            ]
        );
    }

    // v singUp.view.php vo formulári -> c=auth & a=signUp
    public function signUp()
    {
        //TODO URL check
        //v input posielame login a password
        $login = $this->request()->getValue('loginOfUser');
        $email = $this->request()->getValue('emailOfUser');
        $password = $this->request()->getValue('passwordOfUser');
        $repeatedPassword = $this->request()->getValue('repeatedPasswordOfUser');

        if (FormValidator::emptyInputSignUp($login, $email, $password, $repeatedPassword)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'emptyInput']);
            //TODO asi netreba, ale skontrolovat ci to metodu exitne
        } else if(FormValidator::invalidLogin($login)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'username']);
        } else if(FormValidator::invalidEmail($email)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'email']);
        } else if(FormValidator::notMatchingPasswords($password, $repeatedPassword)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'passwordMatch']);
        } else if(DatabaseValidator::checkIfUserExists($login)) {
            $this->redirect('auth', 'signUpForm', ['error' => 'usertaken']);
        } else {
            //TODO sql injection?
            $newUser = new Pouzivatel();
            $newUser->setLogin($login);
            $newUser->setEmail($email);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);   //TODO asi presunut hashovanie do Auth
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
        //TODO URL check maybe?
        Auth::logout();
        $this->redirect('home');
    }
}