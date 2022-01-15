<?php

namespace App\Controllers;

use App\Auth;
use App\Core\DB\Connection;
use App\DatabaseValidator;
use App\FormValidator;
use App\Core\Responses\Response;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieGenre;
use App\Models\Pouzivatel;
use App\Models\Rating;
use App\Models\Review;

class MovieController extends AControllerRedirect
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        $this->redirect('home');
    }

    // v root.layout.view.php v navbare na tlačítku -> c=movie & a=movieForm
    public function movieForm()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        $genres = GenreController::getAllGenres();
        //TODO možno tu pridať id filmu, ak ide o úpravu a poslať ten film z db
        return $this->html(
            [
                'error' => $this->request()->getValue('error'),
                'genres' => $genres
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
        $genreIds = $this->request()->getValue('genresOfMovie');
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
            //TODO toto by mala byť asi transakcia
            $newMovie = new Movie();
            $newMovie->setTitle($title);
            $newMovie->setRelease($release);
            $newMovie->setLength($length);
            $newMovie->setOrigin($origin);
            $newMovie->setImg($nameOfFile);
            $newMovie->setDescription($description);
            $newMovie->save();

            $movie = DatabaseValidator::checkIfMovieExists($title, $release);

            foreach ($genreIds as $genreId) {
                $movieGenre = new MovieGenre();
                $movieGenre->setId($movie->getId());
                $movieGenre->setGenreId($genreId);
                $movieGenre->add();
            }

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
            if($movieGenre = $movie->getGenres()[0]) {
                $movieGenre->delete();
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

        $genres = GenreController::getAllGenres();

        //TODO dať takéto veci do Movie!!!
        $genresOfMovie = $movie->getGenres();
        $genreIds = [];
        foreach ($genresOfMovie as $genre) {
            $genreIds[] = $genre->getGenreId();
        }

        return $this->html(
            [
                'movie' => $movie,
                'genres' => $genres,
                'genresIds' => $genreIds,
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
        $genreIds = $this->request()->getValue('genresOfMovie');
        $description = trim($this->request()->getValue('descriptionOfMovie'));

        if(FormValidator::emptyInputMovie($title, $release, $length, $origin, $description)) {
            $this->redirect('movie', 'editMovieForm',['id' => $id ,'error' => 'Aspoň 1 z polí zostalo prázdne']);
        } else if(FormValidator::invalidYear($release)) {
            $this->redirect('movie', 'editMovieForm', ['id' => $id ,'error' => 'Neplatný rok vydania']);
        } else if(FormValidator::invalidLength($length)) {
            $this->redirect('movie', 'editMovieForm', ['id' => $id ,'error' => 'Neplatná dĺžka filmu']);
        } else {
            $movie = MOVIE::getOne($id);
            $movie->setTitle($title);
            $movie->setRelease($release);
            $movie->setLength($length);
            $movie->setOrigin($origin);
            $movie->setDescription($description);
            $movie->save();

            $genres = $movie->getGenres();
            $genres[0]->delete();
            foreach ($genreIds as $genreId) {
                $movieGenre = new MovieGenre();
                $movieGenre->setId($movie->getId());
                $movieGenre->setGenreId($genreId);
                $movieGenre->add();
            }

            $this->redirect('home');
        }
    }

    public function getProfile()
    {
        $movieId = $this->request()->getValue('id');
        $movie = Movie::getOne($movieId);

        $reviewUsers = [];
        foreach ($movie->getReviews() as $review) {
            $reviewUsers[] = Pouzivatel::getOne($review->getUserId());
        }

        $ratingUsers = [];
        foreach ($movie->getRatings() as $rating) {
            $ratingUsers[] = Pouzivatel::getOne($rating->getUserId());
        }

        $hasRating = Rating::getOneByUniqueColumn('user_id', Auth::getId());
        $hasReview = Review::getOneByUniqueColumn('user_id', Auth::getId());
        return $this->html(
            [
                'movie' => $movie,
                'reviewUsers' => $reviewUsers,
                'ratingUsers' => $ratingUsers,
                'hasRating' => $hasRating,
                'hasReview' => $hasReview
            ]
        );
    }

    public function addReview()
    {
        if (!Auth::isLogged()) {
            $this->redirect("home");
        }
        $movieId = $this->request()->getValue('movieId');
        $userId = Auth::getId();
        $text = trim($this->request()->getValue('reviewOfMovie'));
        if(!FormValidator::emptyInputReview($text)) {                                     //mozno nejaku chybovu hlasku
            $review = new Review();
            $review->setId($movieId);
            $review->setUserId($userId);
            $review->setText($text);
            $review->add();
        }
        $this->redirect('movie', 'getProfile', ['id' => $movieId]);
    }

    public function addRating()
    {
        if (!Auth::isLogged()) {
            $this->redirect("home");
        }
        $movieId = $this->request()->getValue('movieId');
        $userId = Auth::getId();
        $percentage = trim($this->request()->getValue('ratingOfMovie'));
        if(!FormValidator::invalidRating($percentage)) {                                     //mozno nejaku chybovu hlasku
            $rating = new Rating();
            $rating->setId($movieId);
            $rating->setUserId($userId);
            $rating->setPercentage($percentage);
            $rating->add();
        }
        $this->redirect('movie', 'getProfile', ['id' => $movieId]);
    }
}