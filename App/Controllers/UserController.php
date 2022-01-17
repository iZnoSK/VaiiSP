<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\Response;
use App\DatabaseValidator;
use App\FormValidator;
use App\Models\Movie;
use App\Models\MovieCreator;
use App\Models\MovieGenre;
use App\Models\Pouzivatel;

class UserController extends AControllerRedirect
{
    /**
     * @inheritDoc
     */
    public function index()
    {
        if(!Auth::isLogged()) {
            $this->redirect('home');
        }
        $user = Pouzivatel::getOne(Auth::getId());
        $movies = [];
        foreach ($user->getRatings() as $rating) {
            $movies[] = Movie::getOne($rating->getId());
        }
        return $this->html(
            [
                'user' => $user,
                'movies' => $movies
            ]
        );
    }

    public function getProfile()
    {
        //TODO ked nemas ziadny rating ani review, tak to funguje - ked mas obe, tak to funguje
        //TODO keď nemáš žiadny rating alebo review, tak nie - OPRAVIT AJ VO VIEW
        $userId = $this->request()->getValue('id');
        $user = Pouzivatel::getOne($userId);
        $movies = [];
        foreach ($user->getRatings() as $rating) {
            $movies[] = Movie::getOne($rating->getId());
        }
        return $this->html(
            [
                'user' => $user,
                'movies' => $movies
            ]
        );
    }

    public function removeUser() {
        if((!Auth::isLogged()) || (Auth::getId() != $this->request()->getValue('id'))) {
            $this->redirect('home');
        }
        $userId = $this->request()->getValue('id');
        if ($userId > 0)
        {
            $user = Pouzivatel::getOne($userId);
            if($movieReview = $user->getReviews()[0]) {
                $movieReview->delete();
            }
            if($movieRating = $user->getRatings()[0]) {
                $movieRating->delete();
            }
            $user->delete();
        }
        Auth::logout();
        $this->redirect('home');
    }

    // v index.view.php -> c=movie & a=editMovieForm & id = $movie->getId()
    public function editUserForm()
    {
        if((!Auth::isLogged()) || (Auth::getId() != $this->request()->getValue('id'))) {
            $this->redirect('home');
        }
        $userId = $this->request()->getValue('id');
        $user = Pouzivatel::getOne($userId);
        return $this->html(
            [
                'error' => $this->request()->getValue('error'),
                'user' => $user,
            ]
        );
    }

    // v editMovie.view.php vo formulári -> c=home & a=edit
    public function editUser()
    {
        //TODO upratať! krajšie spraviť
        if((!Auth::isLogged()) || (Auth::getId() != $this->request()->getValue('id'))) {
            $this->redirect('home');
        }
        $oldPassword = trim($this->request()->getValue('oldPasswordOfUser'));
        $newPassword = trim($this->request()->getValue('newPasswordOfUser'));
        $repeatedPassword = trim($this->request()->getValue('repeatedPasswordOfUser'));

        //TODO kontrola či sa staré heslo zhoduje
        if(FormValidator::notMatchingPasswords($newPassword, $repeatedPassword)) {
            $this->redirect('user', 'editUserForm', ['error' => 'Heslá sa nezhodujú']);
        } else {
            if (isset($_FILES['fileOfUser']) && FormValidator::isImage($_FILES['fileOfUser']['tmp_name'])) {
                if ($_FILES["fileOfUser"]["error"] == UPLOAD_ERR_OK) {
                    //uloženie obrázku
                    $nameOfFile = date('Y-m-d-H-i-s_') . basename($_FILES['fileOfUser']['name']);
                    move_uploaded_file($_FILES['fileOfUser']['tmp_name'], "public/files/userImages/" . "$nameOfFile");
                }
            } else {
                $this->redirect('user', 'editUserForm', ['error' => 'Problém s obrázkom']);
                exit;
            }
            $user = Pouzivatel::getOne(Auth::getId());
            $user->setImg($nameOfFile);
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);   //TODO asi presunut hashovanie do Auth?
            $user->setPassword($hashedPassword);
            $user->save();
            $user->redirect('user');
        }
    }
}