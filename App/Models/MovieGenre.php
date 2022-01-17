<?php

namespace App\Models;

/**
 * Trieda reprezentuje 1 žáner v konkrétnom filme
 * @package App\Models
 */
class MovieGenre extends \App\Core\Model
{
    /** Konštruktor triedy
     * @param int $id
     * @param int $genre_id
     */
    public function __construct(public int $id = 0, public int $genre_id = 0)
    {

    }

    /**
     * @return string[]
     */
    static public function setDbColumns()
    {
        return ['id', 'genre_id'];
    }

    /**
     * @return string
     */
    static public function setTableName()
    {
        return 'movie_genres';
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

    /** Getter id žánru
     * @return int
     */
    public function getGenreId(): int
    {
        return $this->genre_id;
    }

    /** Setter id žánru
     * @param int $genre_id
     */
    public function setGenreId(int $genre_id): void
    {
        $this->genre_id = $genre_id;
    }
}