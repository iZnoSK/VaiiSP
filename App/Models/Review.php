<?php

namespace App\Models;

/**
 * Trieda reprezentuje 1 recenziu filmu konkrétnym používateľom
 * @package App\Models
 */
class Review extends \App\Core\Model
{
    /** Konštruktor triedy
     * @param int $id
     * @param int $user_id
     * @param string|null $user_login
     * @param string|null $re_text
     */
    public function __construct(public int     $id = 0, public int $user_id = 0, public ?string $user_login = null,
                                public ?string $re_text = null)
    {

    }

    /**
     * @return string[]
     */
    static public function setDbColumns()
    {
        return ['id', 'user_id', 'user_login', 're_text'];
    }

    /**
     * @return string
     */
    static public function setTableName()
    {
        return 'reviews';
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

    /** Getter textu recenzie
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->re_text;
    }

    /** Setter textu recenzie
     * @param string|null $re_text
     */
    public function setText(?string $re_text): void
    {
        $this->re_text = $re_text;
    }

    /** Getter používateľského mena používateľa, ktorý napísal recenziu
     * @return string|null
     */
    public function getUserLogin(): ?string
    {
        return $this->user_login;
    }

    /** Setter používateľského mena používateľa, ktorý napísal recenziu
     * @param string|null $user_login
     */
    public function setUserLogin(?string $user_login): void
    {
        $this->user_login = $user_login;
    }
}