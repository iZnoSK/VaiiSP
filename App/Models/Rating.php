<?php

namespace App\Models;

/**
 * Trieda reprezentuje 1 percentuálne hodnotenie filmu konkrétneho užívateľa
 * @package App\Models
 */
class Rating extends \App\Core\Model
{
    /** Konštruktor triedy
     * @param int $id
     * @param int $user_id
     * @param string|null $user_login
     * @param int $ra_percentage
     */
    public function __construct(public int $id = 0, public int $user_id = 0, public ?string $user_login = null,
                                public int $ra_percentage = 0)
    {

    }

    /**
     * @return string[]
     */
    static public function setDbColumns()
    {
        return ['id', 'user_id','user_login', 'ra_percentage'];
    }

    /**
     * @return string
     */
    static public function setTableName()
    {
        return 'ratings';
    }

    /** Getter id používateľa
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /** Setter id používateľa
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
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

    /** Getter používateľského mena hodnotiaceho používateľa
     * @return string|null
     */
    public function getUserLogin(): ?string
    {
        return $this->user_login;
    }

    /** Setter používateľského mena hodnotiaceho používateľa
     * @param string|null $user_login
     */
    public function setUserLogin(?string $user_login): void
    {
        $this->user_login = $user_login;
    }

    /** Getter percentuálneho hodnotiaceho používateľa
     * @return int
     */
    public function getPercentage(): int
    {
        return $this->ra_percentage;
    }

    /** Setter percentuálneho hodnotiaceho používateľa
     * @param int $ra_percentage
     */
    public function setPercentage(int $ra_percentage): void
    {
        $this->ra_percentage = $ra_percentage;
    }

}