<?php

namespace App\Controllers;

use App\Auth;
use App\Core\DB\Connection;
use App\DatabaseValidator;
use App\FormValidator;
use App\Core\Responses\Response;
use App\Models\Creator;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieCreator;
use App\Models\MovieGenre;
use App\Models\User;
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
        $actors = CreatorController::getAllActors();
        $directors = CreatorController::getAllDirectors();
        $screenwriters = CreatorController::getAllScreenwriters();
        $cameramen = CreatorController::getAllCameramen();
        $composers = CreatorController::getAllComposers();
        //TODO možno tu pridať id filmu, ak ide o úpravu a poslať ten film z db
        return $this->html(
            [
                'error' => $this->request()->getValue('error'),
                'genres' => $genres,
                'actors' => $actors,
                'directors' => $directors,
                'screenwriters' => $screenwriters,
                'cameramen' => $cameramen,
                'composers' => $composers
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

        $actorIds = $this->request()->getValue('actorsOfMovie');
        $directorId = $this->request()->getValue('directorOfMovie');
        $screenwriterId = $this->request()->getValue('screenwriterOfMovie');
        $cameramanId = $this->request()->getValue('cameramanOfMovie');
        $composerId = $this->request()->getValue('composerOfMovie');

        //TODO check, ci nie su prazdne selectboxy
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

            foreach ($actorIds as $actorId) {
                $movieCreator = new MovieCreator();
                $movieCreator->setId($movie->getId());
                $movieCreator->setCreatorId($actorId);
                $movieCreator->add();
            }

            //TODO asi metóda
            $movieCreator = new MovieCreator();
            $movieCreator->setId($movie->getId());
            $movieCreator->setCreatorId($directorId);
            $movieCreator->add();

            $movieCreator = new MovieCreator();
            $movieCreator->setId($movie->getId());
            $movieCreator->setCreatorId($screenwriterId);
            $movieCreator->add();

            $movieCreator = new MovieCreator();
            $movieCreator->setId($movie->getId());
            $movieCreator->setCreatorId($cameramanId);
            $movieCreator->add();

            $movieCreator = new MovieCreator();
            $movieCreator->setId($movie->getId());
            $movieCreator->setCreatorId($composerId);
            $movieCreator->add();

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
            if($movieCast = $movie->getMovieCast()[0]) {
                $movieCast->delete();
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
        $actors = CreatorController::getAllActors();
        $directors = CreatorController::getAllDirectors();
        $screenwriters = CreatorController::getAllScreenwriters();
        $cameramen = CreatorController::getAllCameramen();
        $composers = CreatorController::getAllComposers();

        //TODO dať takéto veci do Movie!!!
        $genresOfMovie = $movie->getGenres();
        $genreIds = [];
        foreach ($genresOfMovie as $genre) {
            $genreIds[] = $genre->getGenreId();
        }

        $PreviousDirector = $movie->getDirector();
        $PreviousScreenwriter = $movie->getScreenwriter();
        $PreviousCameraman = $movie->getCameraman();
        $PreviousComposer = $movie->getComposer();
        $PreviousActors = $movie->getActors();
        $PreviousActorsIds = [];
        foreach ($PreviousActors as $previousActor) {
            $PreviousActorsIds[] = $previousActor->getId();
        }

        return $this->html(
            [
                'error' => $this->request()->getValue('error'),
                'movie' => $movie,
                'genres' => $genres,
                'genresIds' => $genreIds,
                'actors' => $actors,
                'directors' => $directors,
                'screenwriters' => $screenwriters,
                'cameramen' => $cameramen,
                'composers' => $composers,
                'PreviousDirectorId' => $PreviousDirector->getId(),
                'PreviousScreenwriterId' => $PreviousScreenwriter->getId(),
                'PreviousCameramanId' => $PreviousCameraman->getId(),
                'PreviousComposerId' => $PreviousComposer->getId(),
                'PreviousActorsIds' => $PreviousActorsIds
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

        $actorIds = $this->request()->getValue('actorsOfMovie');
        $directorId = $this->request()->getValue('directorOfMovie');
        $screenwriterId = $this->request()->getValue('screenwriterOfMovie');
        $cameramanId = $this->request()->getValue('cameramanOfMovie');
        $composerId = $this->request()->getValue('composerOfMovie');

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

            $movieCast = $movie->getMovieCast();
            $movieCast[0]->delete();

            foreach ($actorIds as $actorId) {
                $movieCreator = new MovieCreator();
                $movieCreator->setId($movie->getId());
                $movieCreator->setCreatorId($actorId);
                $movieCreator->add();
            }

            //TODO asi metóda
            $movieCreator = new MovieCreator();
            $movieCreator->setId($movie->getId());
            $movieCreator->setCreatorId($directorId);
            $movieCreator->add();

            $movieCreator = new MovieCreator();
            $movieCreator->setId($movie->getId());
            $movieCreator->setCreatorId($screenwriterId);
            $movieCreator->add();

            $movieCreator = new MovieCreator();
            $movieCreator->setId($movie->getId());
            $movieCreator->setCreatorId($cameramanId);
            $movieCreator->add();

            $movieCreator = new MovieCreator();
            $movieCreator->setId($movie->getId());
            $movieCreator->setCreatorId($composerId);
            $movieCreator->add();

            $this->redirect('home');
        }
    }

    public function getRatings() {
        $movieId = $this->request()->getValue('id');
        $movie = Movie::getOne($movieId);
        $ratings = $movie->getRatings();
        return $this->json($ratings);
    }

    public function getReviews() {
        $movieId = $this->request()->getValue('id');
        $movie = Movie::getOne($movieId);
        $reviews = $movie->getReviews();
        return $this->json($reviews);
    }

    public function getProfile()
    {
        $movieId = $this->request()->getValue('id');
        $movie = Movie::getOne($movieId);

        $reviewUsers = [];
        foreach ($movie->getReviews() as $review) {
            $reviewUsers[] = User::getOne($review->getUserId());
        }

        $ratingUsers = [];
        foreach ($movie->getRatings() as $rating) {
            $ratingUsers[] = User::getOne($rating->getUserId());
        }

/*        $movieCast = [];
        foreach ($movie->getMovieCast() as $cast) {
            $movieCast[] = Creator::getOne($cast->getCreatorId());
        }*/
        $director = $movie->getDirector();
        $screenwriter = $movie->getScreenwriter();
        $cameraman = $movie->getCameraman();
        $composer = $movie->getComposer();
        $actors = $movie->getActors();

        $hasRating = false;
        $ratings = Rating::getAll('user_id = ?', [Auth::getId()]);
        foreach ($ratings as $rating) {
            if($rating->getId() == $movieId) {
                $hasRating = true;
            }
        }

        $hasReview = false;
        $reviews = Review::getAll('user_id = ?', [Auth::getId()]);
        foreach ($reviews as $review) {
            if($review->getId() == $movieId) {
                $hasReview = true;
            }
        }

        return $this->html(
            [
                'movie' => $movie,
                'reviewUsers' => $reviewUsers,
                'ratingUsers' => $ratingUsers,
                'director' => $director,
                'screenwriter' => $screenwriter,
                'cameraman' => $cameraman,
                'composer' => $composer,
                'actors' => $actors,
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
        $userLogin = Auth::getName();
        $text = trim($this->request()->getValue('reviewOfMovie'));
        if(!FormValidator::emptyInputReview($text)) {                                     //mozno nejaku chybovu hlasku
            $review = new Review();
            $review->setId($movieId);
            $review->setUserId($userId);
            $review->setUserLogin($userLogin);
            $review->setText($text);
            $review->add();
            return $this->json("success");
        }
        return $this->json("error");
    }

    public function addRating()
    {
        if (!Auth::isLogged()) {
            $this->redirect("home");
        }
        $movieId = $this->request()->getValue('movieId');
        $userId = Auth::getId();
        $userLogin = Auth::getName();
        $percentage = trim($this->request()->getValue('ratingOfMovie'));
        if(!FormValidator::invalidRating($percentage)) {                                     //mozno nejaku chybovu hlasku
            $rating = new Rating();
            $rating->setId($movieId);
            $rating->setUserId($userId);
            $rating->setUserLogin($userLogin);
            $rating->setPercentage($percentage);
            $rating->add();
            //TODO prepocitaj final rating, aby sa updateol
            return $this->json("success");
        }
        return $this->json("error");
    }
}