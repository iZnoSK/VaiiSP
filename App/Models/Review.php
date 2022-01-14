<?php

namespace App\Models;

class Review extends \App\Core\Model
{
    public function __construct(public int $user_id = 0, public int $movie_id = 0, public ?string $re_text = null)
    {

    }

    static public function setDbColumns()
    {
        return ['user_id', 'movie_id', 're_text'];
    }

    static public function setTableName()
    {
        return 'reviews';
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movie_id;
    }

    /**
     * @param int $movie_id
     */
    public function setMovieId(int $movie_id): void
    {
        $this->movie_id = $movie_id;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->re_text;
    }

    /**
     * @param string|null $re_text
     */
    public function setText(?string $re_text): void
    {
        $this->re_text = $re_text;
    }
}