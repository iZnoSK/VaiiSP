<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\Response;
use App\DatabaseValidator;
use App\FormValidator;
use App\Models\Genre;

class GenreController extends AControllerRedirect
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        $this->redirect('home');
    }

    // v root.layout.view.php v navbare na tlačítku -> c=genre & a=genreForm
    public function genreForm()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        return $this->html(
            [
                'error' => $this->request()->getValue('error')
            ]
        );
    }

    // v genreForm.view.php vo formulári -> c=genre & a=addGenre
    public function addGenre()
    {
        //TODO URL check?
        $genreName = trim($this->request()->getValue('genreName'));
        if(FormValidator::emptyInputGenre($genreName)) {
            $this->redirect('genre', 'genreForm', ['error' => 'Aspoň 1 z polí zostalo prázdne']);
        } else if(DatabaseValidator::checkIfGenreExists($genreName)) {
            $this->redirect('genre', 'genreForm', ['error' => 'Žáner sa už nachádza v databáze']);
        } else {
            $genre = new Genre();
            $genre->setName($genreName);
            $genre->add();
            $this->redirect('home');
        }
    }

    public static function getAllGenres() {     //TODO inak spravit?
        return Genre::getAll();
    }
}