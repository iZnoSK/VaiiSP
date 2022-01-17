<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\ViewResponse;
use App\FormValidator;
use App\Models\Movie;
use App\Models\User;

/**
 * Kontrolér reprezentujúci používateľove možnosti-načítanie profilov užívateľov, zmenu svojich údajov a zrušenie svojho konta
 * @package App\Controllers
 */
class UserController extends AControllerRedirect
{
    /** Ak nie je používateľ prihlásený, tak zobrazí domovskú stránku, ak je, zobrazí jeho profil
     * @inheritDoc
     */
    public function index()
    {
        if(!Auth::isLogged()) {
            $this->redirect('home');
        }
        $user = User::getOne(Auth::getId());

        $moviesReview = [];
        foreach ($user->getReviews() as $review) {
            $moviesReview[] = Movie::getOne($review->getId());
        }

        $moviesRating = [];
        foreach ($user->getRatings() as $rating) {
            $moviesRating[] = Movie::getOne($rating->getId());
        }

        return $this->html(
            [
                'user' => $user,
                'moviesRating' => $moviesRating,
                'moviesReview' => $moviesReview
            ]
        );
    }

    /** Vráti profil používateľa s daným id z DB
     * @return ViewResponse
     * @throws \Exception
     */
    public function getProfile()
    {
        $userId = $this->request()->getValue('id');
        $user = User::getOne($userId);

        $moviesRating = [];
        foreach ($user->getRatings() as $rating) {
            $moviesRating[] = Movie::getOne($rating->getId());
        }

        $moviesReview = [];
        foreach ($user->getReviews() as $review) {
            $moviesReview[] = Movie::getOne($review->getId());
        }
        return $this->html(
            [
                'user' => $user,
                'moviesRating' => $moviesRating,
                'moviesReview' => $moviesReview
            ]
        );
    }

    /** Zrušenie svojho účtu
     * @throws \Exception
     */
    public function removeUser() {
        if((!Auth::isLogged()) || (Auth::getId() != $this->request()->getValue('id'))) {
            $this->redirect('home');
        }
        $userId = $this->request()->getValue('id');
        if ($userId > 0)
        {
            $user = User::getOne($userId);
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


    /** Pomocou metódy sa prejde na formulár zmeny používateľových údajov.
     * Ak odoslanie formuláru skončí chybou, tá sa vypíše
     * @return ViewResponse
     * @throws \Exception
     */
    public function editUserForm()
    {
        // v index.view.php -> c=movie & a=editMovieForm & id = $movie->getId()
        if((!Auth::isLogged()) || (Auth::getId() != $this->request()->getValue('id'))) {
            $this->redirect('home');
        }
        $userId = $this->request()->getValue('id');
        $user = User::getOne($userId);
        return $this->html(
            [
                'error' => $this->request()->getValue('error'),
                'user' => $user,
            ]
        );
    }


    /** Metóda slúži na skontrolovanie vstupov vo formulári pre prihlásenie a na následnú zmenu údajov
     * @throws \Exception
     */
    public function editUser()
    {
        // v editMovie.view.php vo formulári -> c=home & a=edit
        if((!Auth::isLogged()) || (Auth::getId() != $this->request()->getValue('id'))) {
            $this->redirect('home');
        }
        $oldPassword = trim($this->request()->getValue('oldPasswordOfUser'));
        $newPassword = trim($this->request()->getValue('newPasswordOfUser'));
        $repeatedPassword = trim($this->request()->getValue('repeatedPasswordOfUser'));
        $user = User::getOne(Auth::getId());

        if(!Auth::verifyPassword($oldPassword, $user->getPassword())) {
            $this->redirect('user', 'editUserForm', ['error' => 'Zadali ste nesprávne staré heslo', 'id' => Auth::getId()]);
        } else if(FormValidator::notMatchingPasswords($newPassword, $repeatedPassword)) {
            $this->redirect('user', 'editUserForm', ['error' => 'Heslá sa nezhodujú']);
        } else {
            if (isset($_FILES['fileOfUser']) && FormValidator::isImage($_FILES['fileOfUser']['tmp_name'])) {
                if ($_FILES["fileOfUser"]["error"] == UPLOAD_ERR_OK) {
                    $nameOfFile = date('Y-m-d-H-i-s_') . basename($_FILES['fileOfUser']['name']);
                    move_uploaded_file($_FILES['fileOfUser']['tmp_name'], "public/files/userImages/" . "$nameOfFile");
                }
            } else {
                $this->redirect('user', 'editUserForm', ['error' => 'Problém s obrázkom']);
                exit;
            }
            $user->setImg($nameOfFile);
            $user->setPassword(Auth::hashPassword($newPassword));
            $user->save();
            $this->redirect('user');
        }
    }
}