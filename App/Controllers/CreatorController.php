<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\ViewResponse;
use App\DatabaseValidator;
use App\FormValidator;
use App\Models\Creator;
use App\Models\MovieCreator;
use App\Models\Movie;

/**
 * Trieda reprezentuje kontrolér akéhokoľvek tvorcu(herca, režiséra, scenáristu, kameramana, skladateľa)
 * @package App\Controllers
 */
class CreatorController extends AControllerRedirect
{
    /** Pomocou metódy presmerujeme stránku na hlavnú stránku zobrazujúcu všetkých tvorcov
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

    /** Pomocou metódy sa prejde na formulár pridania nového tvorcu
     * Ak odoslanie formuláru skončí chybou, tá sa vypíše
     * @return ViewResponse
     */
    public function creatorForm()
    {
        // v root.layout.view.php -> c=creator & a=creatorForm
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
     * Metóda slúži na skontrolovanie vstupov vo formulári pre pridanie tvorcu
     * @throws \Exception
     */
    public function addCreator()
    {
        // v creatorForm.view.php -> c=creator & a=addCreator
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }
        $name = trim($this->request()->getValue('nameOfCreator'));
        $surname = trim($this->request()->getValue('surnameOfCreator'));
        $dateOfBirth = trim($this->request()->getValue('dateOfBirthOfCreator'));
        $placeOfBirth = trim($this->request()->getValue('placeOfBirthOfCreator'));
        $role = trim($this->request()->getValue('roleOfCreator'));
        $biography = trim($this->request()->getValue('biographyOfCreator'));

        if(FormValidator::emptyInput([$name, $surname, $dateOfBirth, $placeOfBirth, $role, $biography])) {
            $this->redirect('creator', 'creatorForm', ['error' => 'Aspoň 1 z polí zostalo prázdne']);
        } else if(FormValidator::invalidTypeOfWord($name)) {
            $this->redirect('creator', 'creatorForm', ['error' => 'Meno musí byť slovo']);
        } else if(FormValidator::invalidTypeOfWord($name)) {
            $this->redirect('creator', 'creatorForm', ['error' => 'Priezvisko musí byť slovo']);
        } else if(FormValidator::invalidRole($role)) {
            $this->redirect('creator', 'creatorForm', ['error' => 'Neexistujúce povolanie']);
        } else if(DatabaseValidator::checkIfCreatorExists($name, $surname, $dateOfBirth)) {
            $this->redirect('creator', 'creatorForm', ['error' => 'Tvorca sa už nachádza v databáze']);
        } else {
            if (isset($_FILES['fileOfCreator'])) {
                if ($_FILES["fileOfCreator"]["error"] == UPLOAD_ERR_OK) {
                    if(FormValidator::isImage($_FILES['fileOfCreator']['tmp_name'])) {
                        $nameOfFile = date('Y-m-d-H-i-s_') . basename($_FILES['fileOfCreator']['name']);
                        move_uploaded_file($_FILES['fileOfCreator']['tmp_name'], "public/files/creatorImages/" . "$nameOfFile");
                    } else {
                        $this->redirect('creator', 'creatorForm', ['error' => 'Problém s obrázkom']);
                        exit;
                    }
                } else {
                    $nameOfFile = "2022-01-17-22-03-57_user.jpg";
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


    /** Presmerovanie na profil konkrétneho tvorcu
     * @return ViewResponse
     * @throws \Exception
     */
    public function getProfile()
    {
        //získanie tvorcu
        $creatorId = $this->request()->getValue('id');
        $creator = Creator::getOne($creatorId);
        //získanie všetkých jeho filmov
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

    /** Získanie všetkých hercov z DB
     * @return Creator[]
     * @throws \Exception
     */
    public static function getAllActors() {
        return Creator::getAll("c_role = ?", ['Herec']);
    }

    /** Získanie všetkých režisérov z DB
     * @return Creator[]
     * @throws \Exception
     */
    public static function getAllDirectors() {
        return Creator::getAll("c_role = ?", ['Režisér']);
    }

    /** Získanie všetkých scenáristov z DB
     * @return Creator[]
     * @throws \Exception
     */
    public static function getAllScreenwriters() {
        return Creator::getAll("c_role = ?", ['Scenárista']);
    }

    /** Získanie všetkých kameramanov z DB
     * @return Creator[]
     * @throws \Exception
     */
    public static function getAllCameramen() {
        return Creator::getAll("c_role = ?", ['Kameraman']);
    }

    /** Získanie všetkých skladateľov z DB
     * @return Creator[]
     * @throws \Exception
     */
    public static function getAllComposers() {
        return Creator::getAll("c_role = ?", ['Skladateľ']);
    }
}