<?php

namespace App\Controllers;

use App\Auth;
use App\DatabaseValidator;
use App\FormValidator;
use App\Core\Responses\Response;
use App\Models\Movie;
use App\Models\Rating;
use App\Models\Review;

class MovieController extends AControllerRedirect
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        // TODO: Implement index() method.
    }

    // v root.layout.view.php v navbare na tlačítku -> c=movie & a=movieForm
    public function movieForm()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        //TODO možno tu pridať id filmu, ak ide o úpravu a poslať ten film z db
        return $this->html(
            [
                'error' => $this->request()->getValue('error')
            ]
        );

    }

    // v movieForm.view.php vo formulári -> c=movie & a=upload
    public function upload()
    {
        //TODO upratať! krajšie spraviť
        //TODO URL check?
        //v input posielame login a password
        $title = trim($this->request()->getValue('titleOfMovie'));
        $release = trim($this->request()->getValue('releaseOfMovie'));
        $length = trim($this->request()->getValue('lengthOfMovie'));
        $origin = trim($this->request()->getValue('originOfMovie'));
        $description = trim($this->request()->getValue('descriptionOfMovie'));

        if(FormValidator::emptyInputMovie($title, $release, $length, $origin, $description)) {
            $this->redirect('movie', 'movieForm', ['error' => 'Aspoň 1 z polí zostalo prázdne']);
        } else if(FormValidator::invalidYear($release)) {
            $this->redirect('movie', 'movieForm', ['error' => 'Neplatný rok vydania']);
        } else if(FormValidator::invalidLength($length)) {
            $this->redirect('movie', 'movieForm', ['error' => 'Neplatná dĺžka filmu']);
        } else if(DatabaseValidator::checkIfMovieExists($title, $release)) {
            $this->redirect('movie', 'movieForm', ['error' => 'Film sa už v databáze nachádza']);
        } else {
            if (isset($_FILES['fileOfMovie']) && FormValidator::isImage($_FILES['fileOfMovie']['tmp_name'])) {
                if ($_FILES["fileOfMovie"]["error"] == UPLOAD_ERR_OK) {
                    $nameOfFile = date('Y-m-d-H-i-s_') . basename($_FILES['fileOfMovie']['name']);
                    move_uploaded_file($_FILES['fileOfMovie']['tmp_name'], "public/files/movieImages/" . "$nameOfFile");
                }
            } else {
                $this->redirect('movie', 'movieForm', ['error' => 'Problém s obrázkom']);
                exit;
            }

            $newMovie = new Movie();
            $newMovie->setTitle($title);
            $newMovie->setRelease($release);
            $newMovie->setLength($length);
            $newMovie->setOrigin($origin);
            $newMovie->setImg($nameOfFile);
            $newMovie->setDescription($description);
            $newMovie->save();
            $this->redirect('home');
        }
    }

    public function removeMovie() {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        $movieId = $this->request()->getValue('id');
        if ($movieId > 0)
        {
            $movie = Movie::getOne($movieId);
            if($movieReview = $movie->getReviews()[0]) {
                $movieReview->delete();
            }
            if($movieRating = $movie->getRatings()[0]) {
                $movieRating->delete();
            }
            $movie->delete();
        }
        //presmerovat vystup na home
        $this->redirect('home');
    }

    // v index.view.php -> c=movie & a=editMovieForm & id = $movie->getId()
    public function editMovieForm()
    {
        if (!Auth::isLogged())
        {
            $this->redirect('home');
        }
        $movie = MOVIE::getOne($this->request()->getValue('id'));
        return $this->html(
            [
                'movie' => $movie,
                'error' => $this->request()->getValue('error')
            ]
        );
    }

    // v editMovie.view.php vo formulári -> c=home & a=edit
    public function editMovie()
    {
        //TODO upratať! krajšie spraviť
        //TODO URL check?
        if (!Auth::isLogged()) {
            $this->redirect("home");
        }

        $id = $this->request()->getValue('id');
        $title = trim($this->request()->getValue('titleOfMovie'));
        $release = trim($this->request()->getValue('releaseOfMovie'));
        $length = trim($this->request()->getValue('lengthOfMovie'));
        $origin = trim($this->request()->getValue('originOfMovie'));
        $description = trim($this->request()->getValue('descriptionOfMovie'));

        if(FormValidator::emptyInputMovie($title, $release, $length, $origin, $description)) {
            $this->redirect('movie', 'editMovieForm',['id' => $id ,'error' => 'Aspoň 1 z polí zostalo prázdne']);
        } else if(FormValidator::invalidYear($release)) {
            $this->redirect('movie', 'editMovieForm', ['id' => $id ,'error' => 'Neplatný rok vydania']);
        } else if(FormValidator::invalidLength($length)) {
            $this->redirect('movie', 'editMovieForm', ['id' => $id ,'error' => 'Neplatná dĺžka filmu']);
        } else if(DatabaseValidator::checkIfMovieExists($title, $release)) {
            $this->redirect('movie', 'editMovieForm', ['id' => $id ,'error' => 'Film sa už v databáze nachádza']);
        } else {
            $movie = MOVIE::getOne($id);
            $movie->setTitle($title);
            $movie->setRelease($release);
            $movie->setLength($length);
            $movie->setOrigin($origin);
            $movie->setDescription($description);
            $movie->save();
            $this->redirect('home');
        }
    }

/*    public function getProfile()
    {
        $userId = $this->request()->getValue('id');
        $movie = Movie::getOne($userId);
        return $this->html(
            [
                'movie' => $movie
            ]
        );
    }*/
}