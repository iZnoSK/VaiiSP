<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\ViewResponse;
use App\DatabaseValidator;
use App\FormValidator;
use App\Models\Movie;
use App\Models\MovieCreator;
use App\Models\MovieGenre;
use App\Models\User;
use App\Models\Rating;
use App\Models\Review;

/**
 * Kontrolér reprezentujúci možnosti, aké možeme robiť s filmom
 * @package App\Controllers
 */
class MovieController extends AControllerRedirect
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        $this->redirect('home');
    }

    /** Pomocou metódy sa prejde na formulár pridania nového filmu
     * Ak odoslanie formuláru skončí chybou, tá sa vypíše
     * @return ViewResponse
     * @throws \Exception
     */
    public function movieForm()
    {
        // v root.layout.view.php -> c=movie & a=movieForm
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        $genres = GenreController::getAllGenres();
        $actors = CreatorController::getAllActors();
        $directors = CreatorController::getAllDirectors();
        $screenwriters = CreatorController::getAllScreenwriters();
        $cameramen = CreatorController::getAllCameramen();
        $composers = CreatorController::getAllComposers();
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


    /** vytvor nový film
     * @throws \Exception
     */
    public function upload()
    {
        // v movieForm.view.php vo formulári -> c=movie & a=upload
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
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

        if(FormValidator::emptyInput([$title, $release, $length, $origin, $description, $actorIds, $directorId, $screenwriterId, $cameramanId, $composerId])) {
            $this->redirect('movie', 'movieForm', ['error' => 'Aspoň 1 z polí zostalo prázdne']);
        } else if(FormValidator::invalidYear($release)) {
            $this->redirect('movie', 'movieForm', ['error' => 'Neplatný rok vydania']);
        } else if(FormValidator::invalidLength($length)) {
            $this->redirect('movie', 'movieForm', ['error' => 'Neplatná dĺžka filmu']);
        } else if(DatabaseValidator::checkIfMovieExists($title, $release)) {
            $this->redirect('movie', 'movieForm', ['error' => 'Film sa už v databáze nachádza']);
        } else {
            if (isset($_FILES['fileOfMovie'])) {
                if ($_FILES["fileOfMovie"]["error"] == UPLOAD_ERR_OK) {
                    if(FormValidator::isImage($_FILES['fileOfMovie']['tmp_name'])) {
                        $nameOfFile = date('Y-m-d-H-i-s_') . basename($_FILES['fileOfMovie']['name']);
                        move_uploaded_file($_FILES['fileOfMovie']['tmp_name'], "public/files/movieImages/" . "$nameOfFile");
                    } else {
                        $this->redirect('movie', 'movieForm', ['error' => 'Problém s obrázkom']);
                        exit;
                    }
                } else {
                    $nameOfFile = "blank-poster.png";
                }
            } else {
                $this->redirect('movie', 'movieForm', ['error' => 'Problém s obrázkom']);
                exit;
            }
            //vytvor nový film
            $newMovie = new Movie();
            $newMovie->setTitle($title);
            $newMovie->setRelease($release);
            $newMovie->setLength($length);
            $newMovie->setOrigin($origin);
            $newMovie->setImg($nameOfFile);
            $newMovie->setDescription($description);
            $newMovie->save();
            $movie = DatabaseValidator::checkIfMovieExists($title, $release);
            //vytvor film žánre
            foreach ($genreIds as $genreId) {
                $movieGenre = new MovieGenre();
                $movieGenre->setId($movie->getId());
                $movieGenre->setGenreId($genreId);
                $movieGenre->add();
            }
            //vytvor film cast
            $this->createMovieCast($movie, $actorIds, $directorId, $screenwriterId, $cameramanId, $composerId);
            $this->redirect('home');
        }
    }


    /** zmaže film z DB
     * @throws \Exception
     */
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
        $this->redirect('home');
    }


    /** formulár na úpravu filmu v DB
     * @return ViewResponse
     * @throws \Exception
     */
    public function editMovieForm()
    {
        // v index.view.php -> c=movie & a=editMovieForm & id = $movie->getId()
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


    /** upraví film v DB
     * @throws \Exception
     */
    public function editMovie()
    {
        // v editMovie.view.php vo formulári -> c=home & a=edit
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

        if(FormValidator::emptyInput([$title, $release, $length, $origin, $description, $actorIds, $directorId, $screenwriterId, $cameramanId, $composerId])) {
            $this->redirect('movie', 'movieForm', ['error' => 'Aspoň 1 z polí zostalo prázdne']);
        } else if(FormValidator::invalidYear($release)) {
            $this->redirect('movie', 'editMovieForm', ['id' => $id ,'error' => 'Neplatný rok vydania']);
        } else if(FormValidator::invalidLength($length)) {
            $this->redirect('movie', 'editMovieForm', ['id' => $id ,'error' => 'Neplatná dĺžka filmu']);
        } else {
            //update film
            $movie = MOVIE::getOne($id);
            $movie->setTitle($title);
            $movie->setRelease($release);
            $movie->setLength($length);
            $movie->setOrigin($origin);
            $movie->setDescription($description);
            $movie->save();
            //update žánrov
            $genres = $movie->getGenres();
            $genres[0]->delete();
            foreach ($genreIds as $genreId) {
                $movieGenre = new MovieGenre();
                $movieGenre->setId($movie->getId());
                $movieGenre->setGenreId($genreId);
                $movieGenre->add();
            }
            //update movie cast
            $movieCast = $movie->getMovieCast();
            $movieCast[0]->delete();
            $this->createMovieCast($movie, $actorIds, $directorId, $screenwriterId, $cameramanId, $composerId);
            $this->redirect('home');
        }
    }

    /** vytvorí pre film všetkých tvorcov
     * @param $movie
     * @param $actorIds
     * @param $directorId
     * @param $screenwriterId
     * @param $cameramanId
     * @param $composerId
     * @throws \Exception
     */
    private function createMovieCast($movie, $actorIds, $directorId, $screenwriterId, $cameramanId, $composerId) {
        foreach ($actorIds as $actorId) {
            $movieCreator = new MovieCreator();
            $movieCreator->setId($movie->getId());
            $movieCreator->setCreatorId($actorId);
            $movieCreator->add();
        }

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
    }

    /** vráti všetky hodnotenia filmu s daným id
     * @return \App\Core\Responses\JsonResponse
     * @throws \Exception
     */
    public function getRatings() {
        $movieId = $this->request()->getValue('id');
        $movie = Movie::getOne($movieId);
        $ratings = $movie->getRatings();
        return $this->json($ratings);
    }

    /** vráti všetky recenzie filmu s daným id
     * @return \App\Core\Responses\JsonResponse
     * @throws \Exception
     */
    public function getReviews() {
        $movieId = $this->request()->getValue('id');
        $movie = Movie::getOne($movieId);
        $reviews = $movie->getReviews();
        return $this->json($reviews);
    }

    /** vráti profil filmu s daným id
     * @return ViewResponse
     * @throws \Exception
     */
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

    /** pridá recenziu filmu s daným id
     * @return \App\Core\Responses\JsonResponse
     * @throws \Exception
     */
    public function addReview()
    {
        if (!Auth::isLogged()) {
            $this->redirect("home");
        }
        $movieId = $this->request()->getValue('movieId');
        $userId = Auth::getId();
        $userLogin = Auth::getName();
        $text = trim($this->request()->getValue('reviewOfMovie'));
        if(!FormValidator::emptyInputReview($text)) {
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

    /** pridá hodnotenie filmu s daným id
     * @return \App\Core\Responses\JsonResponse
     * @throws \Exception
     */
    public function addRating()
    {
        if (!Auth::isLogged()) {
            $this->redirect("home");
        }
        $movieId = $this->request()->getValue('movieId');
        $userId = Auth::getId();
        $userLogin = Auth::getName();
        $percentage = trim($this->request()->getValue('ratingOfMovie'));
        if(!FormValidator::invalidRating($percentage)) {
            $rating = new Rating();
            $rating->setId($movieId);
            $rating->setUserId($userId);
            $rating->setUserLogin($userLogin);
            $rating->setPercentage($percentage);
            $rating->add();
            return $this->json("success");
        }
        return $this->json("error");
    }
}