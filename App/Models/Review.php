<?php

namespace App\Models;

class Review extends \App\Core\Model
{
    public function __construct(public int $id = 0, public int $user_id = 0, public ?string $user_login = null,
                                public ?string $re_text = null)
    {

    }

    static public function setDbColumns()
    {
        return ['id', 'user_id', 'user_login', 're_text'];
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
}