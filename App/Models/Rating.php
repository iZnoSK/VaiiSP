<?php

namespace App\Models;

class Rating extends \App\Core\Model
{
    public function __construct(public int $id = 0, public int $user_id = 0, public ?int $ra_percentage = null)
    {

    }

    static public function setDbColumns()
    {
        return ['id', 'user_id', 'ra_percentage'];
    }

    static public function setTableName()
    {
        return 'ratings';
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
     * @return int|null
     */
    public function getPercentage(): ?int
    {
        return $this->ra_percentage;
    }

    /**
     * @param int|null $ra_percentage
     */
    public function setPercentage(?int $ra_percentage): void
    {
        $this->ra_percentage = $ra_percentage;
    }
}