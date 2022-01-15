<?php

namespace App\Models;

class MovieGenre extends \App\Core\Model
{
    public function __construct(public int $id = 0, public int $genre_id = 0)
    {

    }

    static public function setDbColumns()
    {
        return ['id', 'genre_id'];
    }

    static public function setTableName()
    {
        return 'movie_genres';
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
     * @return int
     */
    public function getGenreId(): int
    {
        return $this->genre_id;
    }

    /**
     * @param int $genre_id
     */
    public function setGenreId(int $genre_id): void
    {
        $this->genre_id = $genre_id;
    }
}