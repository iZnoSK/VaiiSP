<?php

namespace App\Controllers;

use App\Auth;
use App\FormValidator;
use App\Core\Responses\Response;
use App\Models\Movie;

class MovieController extends AControllerRedirect
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        // TODO: Implement index() method.
    }

    // v root.layout.view.php v navbare na tlačítku -> c=movie & a=movieForm;
    public function movieForm()
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

    // v movieForm.view.php vo formulári -> c=movie & a=upload
    public function upload()
    {
        //TODO upratať! krajšie spraviť
        //TODO URL check?
        //v input posielame login a password
        $title = $this->request()->getValue('titleOfMovie');
        $release = $this->request()->getValue('releaseOfMovie');
        $length = $this->request()->getValue('lengthOfMovie');
        $origin = $this->request()->getValue('originOfMovie');
        $description = $this->request()->getValue('descriptionOfMovie');

        if(FormValidator::emptyInputMovie($title, $release, $length, $origin, $description)) {
            $this->redirect('movie', 'movieForm', ['error' => 'Aspoň 1 z polí zostalo prázdne']);
        } else if(FormValidator::invalidYear($release)) {
            $this->redirect('movie', 'movieForm', ['error' => 'Neplatný rok vydania']);
        } else if(FormValidator::invalidLength($length)) {
            $this->redirect('movie', 'movieForm', ['error' => 'Neplatná dĺžka filmu']);
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
}