<?php

namespace App\Models;

/**
 * Trieda reprezentuje 1 tvorcu v konkrétnom filme
 * @package App\Models
 */
class MovieCreator extends \App\Core\Model
{
    /** Konštruktor triedy
     * @param int $id
     * @param int $creator_id
     */
    public function __construct(public int $id = 0, public int $creator_id = 0)
    {

    }

    /**
     * @return string[]
     */
    static public function setDbColumns()
    {
        return ['id', 'creator_id'];
    }

    /**
     * @return string
     */
    static public function setTableName()
    {
        return 'movie_creators';
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

    /** Getter id tvorcu
     * @return int
     */
    public function getCreatorId(): int
    {
        return $this->creator_id;
    }

    /** Setter id tvorcu
     * @param int $creator_id
     */
    public function setCreatorId(int $creator_id): void
    {
        $this->creator_id = $creator_id;
    }
}