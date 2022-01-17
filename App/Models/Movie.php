<?php

namespace App\Models;

use App\Models\Rating;
use App\Models\Review;
use App\Models\MovieGenre;
use App\Models\MovieCreator;

/**
 * Trieda reprezentuje 1 konkrétny film
 * @package App\Models
 */
class Movie extends \App\Core\Model
{
    /** Konštruktor triedy film
     * @param int $id
     * @param string|null $m_title
     * @param int $m_release
     * @param int $m_length
     * @param string|null $m_origin
     * @param string|null $m_img
     * @param string|null $m_description
     */
    public function __construct(public int     $id = 0, public ?string $m_title = null, public int $m_release = 0,
                                public int     $m_length = 0, public ?string $m_origin = null,
                                public ?string $m_img = null, public ?string $m_description = null)
    {

    }

    /**
     * @return string[]
     */
    static public function setDbColumns()
    {
        return ['id', 'm_title', 'm_release', 'm_length', 'm_origin', 'm_img', 'm_description'];
    }

    /**
     * @return string
     */
    static public function setTableName()
    {
        return 'movies';
    }

    /** Getter id filmu
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Setter id filmu
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /** Getter názvu filmu
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->m_title;
    }

    /** Setter názvu filmu
     * @param string|null $m_title
     */
    public function setTitle(?string $m_title): void
    {
        $this->m_title = $m_title;
    }

    /** Getter roku vydania filmu
     * @return int
     */
    public function getRelease(): int
    {
        return $this->m_release;
    }

    /** Setter roku vydania filmu
     * @param int $m_release
     */
    public function setRelease(int $m_release): void
    {
        $this->m_release = $m_release;
    }

    /** Getter dĺžky filmu v minútach
     * @return int
     */
    public function getLength(): int
    {
        return $this->m_length;
    }

    /** Setter dĺžky filmu v minútach
     * @param int $m_length
     */
    public function setLength(int $m_length): void
    {
        $this->m_length = $m_length;
    }

    /** Getter krajiny pôvodu filmu
     * @return string|null
     */
    public function getOrigin(): ?string
    {
        return $this->m_origin;
    }

    /** Setter krajiny pôvodu filmu
     * @param string|null $m_origin
     */
    public function setOrigin(?string $m_origin): void
    {
        $this->m_origin = $m_origin;
    }

    /** Getter plagátu filmu
     * @return string|null
     */
    public function getImg(): ?string
    {
        return $this->m_img;
    }

    /** Setter plagátu filmu
     * @param string|null $m_img
     */
    public function setImg(?string $m_img): void
    {
        $this->m_img = $m_img;
    }

    /** Getter popisu filmu
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->m_description;
    }

    /** Setter popisu filmu
     * @param string|null $m_description
     */
    public function setDescription(?string $m_description): void
    {
        $this->m_description = $m_description;
    }

    // ---------------------------------

    public function getFinalRating()
    {
        $finalRating = 0;
        $counter = 0;
        $ratings = $this->getRatings();
        if ($ratings) {
            foreach ($ratings as $rating) {
                $counter++;
                $finalRating = ($finalRating + $rating->getPercentage());
            }
            $finalRating /= $counter;
        }
        return (int)$finalRating;
    }


    /** Vráti všetky recenzie na daný film
     * @return Review[]
     * @throws \Exception
     */
    public function getReviews()
    {
        return Review::getAll('id = ?', [$this->id]);
    }

    /** Vráti všetky hodnotenia daného filmu
     * @return Rating[]
     * @throws \Exception
     */
    public function getRatings()
    {
        return Rating::getAll('id = ?', [$this->id]);
    }

    /** Vráti všetky žánre filmu
     * @return MovieGenre[]
     * @throws \Exception
     */
    public function getGenres()
    {
        return MovieGenre::getAll('id = ?', [$this->id]);
    }

    /** Vráti názvy žánrov filmu oddelené čiarkou
     * @return string
     * @throws \Exception
     */
    public function getGenresString()
    {
        $movieGenres = $this->getGenres();
        $genreNames = [];
        foreach ($movieGenres as $movieGenre) {
            $genreNames[] = Genre::getOne($movieGenre->getGenreId())->getName();
        }
        $genres = implode(", ", $genreNames);
        return $genres;
    }


    /** Vráti všetkých tvorcov daného filmu
     * @return MovieCreator[]
     * @throws \Exception
     */
    public function getMovieCast()
    {
        return MovieCreator::getAll('id = ?', [$this->id]);
    }

    /** Vráti režiséra daného filmu
     * @return Creator|false
     * @throws \Exception
     */
    public function getDirector()
    {
        $movieCast = $this->getMovieCast();
        foreach ($movieCast as $cast) {
            $creator = Creator::getOne($cast->getCreatorId());
            if ($creator->getRole() == "Režisér") {
                return $creator;
            }
        }
        return false;
    }


    /** Vráti scenáristu daného filmu
     * @return Creator|false|null
     * @throws \Exception
     */
    public function getScreenwriter()
    {
        $movieCast = $this->getMovieCast();
        foreach ($movieCast as $cast) {
            $creator = Creator::getOne($cast->getCreatorId());
            if ($creator->getRole() == "Scenárista") {
                return $creator;
            }
        }
        return false;
    }


    /** Vráti kameramana daného filmu
     * @return Creator|false|null
     * @throws \Exception
     */
    public function getCameraman()
    {
        $movieCast = $this->getMovieCast();
        foreach ($movieCast as $cast) {
            $creator = Creator::getOne($cast->getCreatorId());
            if ($creator->getRole() == "Kameraman") {
                return $creator;
            }
        }
        return false;
    }


    /** Vráti skladateľa daného filmu
     * @return Creator|false|null
     * @throws \Exception
     */
    public function getComposer()
    {
        $movieCast = $this->getMovieCast();
        foreach ($movieCast as $cast) {
            $creator = Creator::getOne($cast->getCreatorId());
            if ($creator->getRole() == "Skladateľ") {
                return $creator;
            }
        }
        return false;
    }

    /** vráti všetkých hercov daného filmu
     * @return array
     * @throws \Exception
     */
    public function getActors()
    {
        $movieCast = $this->getMovieCast();
        $actors = [];
        foreach ($movieCast as $cast) {
            $creator = Creator::getOne($cast->getCreatorId());
            if ($creator->getRole() == "Herec") {
                $actors[] = $creator;
            }
        }
        return $actors;
    }
}