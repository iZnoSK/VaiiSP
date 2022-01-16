<?php

namespace App\Models;

class Rating extends \App\Core\Model
{
    public function __construct(public int $id = 0, public int $user_id = 0, public ?string $user_login = null,
                                public int $ra_percentage = 0)
    {

    }

    static public function setDbColumns()
    {
        return ['id', 'user_id','user_login', 'ra_percentage'];
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
     * @return string|null
     */
    public function getUserLogin(): ?string
    {
        return $this->user_login;
    }

    /**
     * @param string|null $user_login
     */
    public function setUserLogin(?string $user_login): void
    {
        $this->user_login = $user_login;
    }

    /**
     * @return int
     */
    public function getPercentage(): int
    {
        return $this->ra_percentage;
    }

    /**
     * @param int $ra_percentage
     */
    public function setPercentage(int $ra_percentage): void
    {
        $this->ra_percentage = $ra_percentage;
    }

}