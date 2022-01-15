<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\Response;
use App\Models\Movie;
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
}