<?php

namespace App\Models;
use App\Models\Rating;
use App\Models\Review;
use App\Models\MovieGenre;
use App\Models\MovieCreator;

//TODO vyriesit problem s dlhym descriptionom - rozdelit ho nejako na uvodnu stranku (prvych 100 znakov alebo take cosi)
class Movie extends \App\Core\Model
{
    public function __construct(public int $id = 0, public ?string $m_title = null, public int $m_release = 0,
                                public int $m_length = 0, public ?string $m_origin = null,
                                public ?string $m_img = null, public ?string $m_description = null)
    {

    }

    static public function setDbColumns()
    {
        return ['id', 'm_title', 'm_release', 'm_length', 'm_origin', 'm_img', 'm_description'];
    }

    static public function setTableName()
    {
        return 'movies';
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->m_title;
    }

    /**
     * @param string|null $m_title
     */
    public function setTitle(?string $m_title): void
    {
        $this->m_title = $m_title;
    }

    /**
     * @return int
     */
    public function getRelease(): int
    {
        return $this->m_release;
    }

    /**
     * @param int $m_release
     */
    public function setRelease(int $m_release): void
    {
        $this->m_release = $m_release;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->m_length;
    }

    /**
     * @param int $m_length
     */
    public function setLength(int $m_length): void
    {
        $this->m_length = $m_length;
    }

    /**
     * @return string|null
     */
    public function getOrigin(): ?string
    {
        return $this->m_origin;
    }

    /**
     * @param string|null $m_origin
     */
    public function setOrigin(?string $m_origin): void
    {
        $this->m_origin = $m_origin;
    }

    /**
     * @return string|null
     */
    public function getImg(): ?string
    {
        return $this->m_img;
    }

    /**
     * @param string|null $m_img
     */
    public function setImg(?string $m_img): void
    {
        $this->m_img = $m_img;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->m_description;
    }

    /**
     * @param string|null $m_description
     */
    public function setDescription(?string $m_description): void
    {
        $this->m_description = $m_description;
    }

    // ---------------------------------

    //TODO prepocitavat vzdy ked pribudne novy rating, nie takto
    public function getFinalRating()
    {
        $finalRating = 0;
        $counter = 0;
        foreach ($this->getRatings() as $rating) {
            $counter++;
            $finalRating = ($finalRating + $rating->getPercentage());
        }
        $finalRating /= $counter;
        return (int)$finalRating;
    }

    public function getReviews()
    {
        return Review::getAll('id = ?', [$this->id]);
    }

    public function getRatings()
    {
        return Rating::getAll('id = ?', [$this->id]);
    }

    public function getGenres()
    {
        return MovieGenre::getAll('id = ?', [$this->id]);
    }

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

    public function getMovieCast()
    {
        return MovieCreator::getAll('id = ?', [$this->id]);
    }

    public function getDirector()
    {
        foreach ($this->getMovieCast() as $cast) {
            $creator = Creator::getOne($cast->getCreatorId());
            if($creator->getRole() == "Režisér") {
                return $creator;
            }
        }
        return false;
    }

    public function getScreenwriter()
    {
        foreach ($this->getMovieCast() as $cast) {
            $creator = Creator::getOne($cast->getCreatorId());
            if($creator->getRole() == "Scenárista") {
                return $creator;
            }
        }
        return false;
    }

    public function getCameraman()
    {
        foreach ($this->getMovieCast() as $cast) {
            $creator = Creator::getOne($cast->getCreatorId());
            if($creator->getRole() == "Kameraman") {
                return $creator;
            }
        }
        return false;
    }

    public function getComposer()
    {
        foreach ($this->getMovieCast() as $cast) {
            $creator = Creator::getOne($cast->getCreatorId());
            if($creator->getRole() == "Skladateľ") {
                return $creator;
            }
        }
        return false;
    }

    public function getActors()
    {
        $actors = [];
        foreach ($this->getMovieCast() as $cast) {
            $creator = Creator::getOne($cast->getCreatorId());
            if($creator->getRole() == "Herec") {
                $actors[] = $creator;
            }
        }
        return $actors;
    }
}