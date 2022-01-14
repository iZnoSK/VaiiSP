<?php

namespace App\Models;

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

    public function getReviews()
    {
        return Review::getAll('movie_id = ?', [$this->id]);
    }

    public function getRatings()
    {
        return Rating::getAll('movie_id = ?', [$this->id]);
    }

    //TODO dorobit genres asi
}