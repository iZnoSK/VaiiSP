<?php

namespace App\Controllers;

use App\Models\Movie;

/**
 * Class HomeController
 * Example of simple controller
 * @package App\Controllers
 */
class HomeController extends AControllerRedirect
{
    /** Pomocou metódy presmerujeme stránku na hlavnú stránku zobrazujúcu všetky filmy
     * @inheritDoc
     */
    public function index()
    {
        //$movies je pole všetkých záznamov z tabuľky movies
        $movies = Movie::getAll();
        //v $data pod položkou 'movies' bude mať pole $movies
        return $this->html(
            [
                'movies' => $movies
            ]);
    }
}