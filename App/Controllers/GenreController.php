<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\ViewResponse;
use App\DatabaseValidator;
use App\FormValidator;
use App\Models\Genre;

/**
 * Trieda reprezentuje kontrolér žánru
 * @package App\Controllers
 */
class GenreController extends AControllerRedirect
{
    /**
     * @inheritDoc
     */
    public function index()
    {
        $this->redirect('home');
    }


    /**
     * Metóda dovolí prihlásenej osobe prejsť na formulár pridania žánru
     * @return ViewResponse
     */
    public function genreForm()
    {
        // v root.layout.view.php -> c=genre & a=genreForm
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        return $this->html(
            [
                'error' => $this->request()->getValue('error')
            ]
        );
    }


    /**
     * Metóda dovolí prihlásenej osobe pridať žáner, ktorý bol poslaný pomocou formuláru
     * @throws \Exception
     */
    public function addGenre()
    {
        // v genreForm.view.php -> c=genre & a=addGenre
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        $genreName = trim($this->request()->getValue('genreName'));
        if(FormValidator::emptyInput([$genreName])) {
            $this->redirect('genre', 'genreForm', ['error' => 'Aspoň 1 z polí zostalo prázdne']);
        } else if(FormValidator::tooManyChars(30, $genreName)) {
            $this->redirect('genre', 'genreForm', ['error' => 'Názov žánru je príliš dlhý']);
        } else if(FormValidator::invalidTypeOfWord($genreName)) {
            $this->redirect('genre', 'genreForm', ['error' => 'Názov žánru nebolo slovo']);
        } else if(DatabaseValidator::checkIfGenreExists($genreName)) {
            $this->redirect('genre', 'genreForm', ['error' => 'Žáner sa už nachádza v databáze']);
        } else {
            $genre = new Genre();
            $genre->setName($genreName);
            $genre->add();
            $this->redirect('home');
        }
    }

    /** Metóda získa všetky žánre z databázy
     * @return Genre[]
     * @throws \Exception
     */
    public static function getAllGenres() {
        return Genre::getAll();
    }
}