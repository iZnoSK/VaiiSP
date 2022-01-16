<?php

namespace App\Models;

class MovieCreator extends \App\Core\Model
{
    public function __construct(public int $id = 0, public int $creator_id = 0)
    {

    }

    static public function setDbColumns()
    {
        return ['id', 'creator_id'];
    }

    static public function setTableName()
    {
        return 'movie_creators';
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
    public function getCreatorId(): int
    {
        return $this->creator_id;
    }

    /**
     * @param int $creator_id
     */
    public function setCreatorId(int $creator_id): void
    {
        $this->creator_id = $creator_id;
    }
}