<?php

namespace App\Controllers;

use App\Auth;

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

    // v root.layout.view.php na tlačítku -> c=auth & a=logout
    public function logout()
    {
        Auth::logout();
        $this->redirect('home');
    }

    // v loginForm.view.php vo formulári -> c=auth & a=login
    public function login()
    {
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
}