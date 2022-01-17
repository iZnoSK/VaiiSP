<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\Response;
use App\DatabaseValidator;
use App\FormValidator;
use App\Models\Creator;
use App\Models\MovieCreator;
use App\Models\Movie;

class CreatorController extends AControllerRedirect
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        $actors = self::getAllActors();
        $directors = self::getAllDirectors();
        $screenwriters = self::getAllScreenwriters();
        $cameramen = self::getAllCameramen();
        $composers = self::getAllComposers();

        return $this->html(
            [
                'actors' => $actors,
                'directors' => $directors,
                'screenwriters' => $screenwriters,
                'cameramen' => $cameramen,
                'composers' => $composers
            ]
        );
    }

    // v root.layout.view.php v navbare na tlačítku -> c=creator & a=creatorForm
    public function creatorForm()
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

    // v creatorForm.view.php vo formulári -> c=creator & a=addCreator
    public function addCreator()
    {
        //TODO URL check?
        $name = trim($this->request()->getValue('nameOfCreator'));
        $surname = trim($this->request()->getValue('surnameOfCreator'));
        $dateOfBirth = trim($this->request()->getValue('dateOfBirthOfCreator'));
        $placeOfBirth = trim($this->request()->getValue('placeOfBirthOfCreator'));
        $role = trim($this->request()->getValue('roleOfCreator'));
        $biography = trim($this->request()->getValue('biographyOfCreator'));

        if(FormValidator::emptyInputCreator($name, $surname, $dateOfBirth, $placeOfBirth, $role, $biography)) {
            $this->redirect('creator', 'creatorForm', ['error' => 'Aspoň 1 z polí zostalo prázdne']);
        } else if(DatabaseValidator::checkIfCreatorExists($name, $surname, $dateOfBirth)) {
            $this->redirect('creator', 'creatorForm', ['error' => 'Tvorca sa už nachádza v databáze']);
            //TODO check, či je role z tých 5 povolaní
        } else {
            if (isset($_FILES['fileOfCreator']) && FormValidator::isImage($_FILES['fileOfCreator']['tmp_name'])) {
                if ($_FILES["fileOfCreator"]["error"] == UPLOAD_ERR_OK) {
                    $nameOfFile = date('Y-m-d-H-i-s_') . basename($_FILES['fileOfCreator']['name']);
                    move_uploaded_file($_FILES['fileOfCreator']['tmp_name'], "public/files/creatorImages/" . "$nameOfFile");
                }
            } else {
                $this->redirect('creator', 'creatorForm', ['error' => 'Problém s obrázkom']);
                exit;
            }
            $creator = new Creator();
            $creator->setName($name);
            $creator->setSurname($surname);
            $creator->setRole($role);
            $creator->setDateOfBirth($dateOfBirth);
            $creator->setPlaceOfBirth($placeOfBirth);
            $creator->setImg($nameOfFile);
            $creator->setBiography($biography);
            $creator->save();
            $this->redirect('home');
        }
    }

    public function getProfile()
    {
        $creatorId = $this->request()->getValue('id');
        $creator = Creator::getOne($creatorId);

        $movieIds = MovieCreator::getAll('creator_id = ?', [$creatorId]);
        $movies = [];
        foreach ($movieIds as $movieId) {
            $movies[] = Movie::getOne($movieId->getId());
        }

        return $this->html(
            [
                'creator' => $creator,
                'movies' => $movies
            ]
        );
    }

    public static function getAllActors() {     //TODO inak spravit?
        return Creator::getAll("c_role = ?", ['Herec']);
    }

    public static function getAllDirectors() {     //TODO inak spravit?
        return Creator::getAll("c_role = ?", ['Režisér']);
    }

    public static function getAllScreenwriters() {     //TODO inak spravit?
        return Creator::getAll("c_role = ?", ['Scenárista']);
    }

    public static function getAllCameramen() {     //TODO inak spravit?
        return Creator::getAll("c_role = ?", ['Kameraman']);
    }

    public static function getAllComposers() {     //TODO inak spravit?
        return Creator::getAll("c_role = ?", ['Skladateľ']);
    }
}