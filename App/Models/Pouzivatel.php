<?php

namespace App\Models;

const ADMIN = "admin";
const COMMON = "common";

//TODO možno dorobiť admin prihlasovanie - viac práv - momentálne majú všetci použivatelia rovnaké práva
//TODO rename to User
class Pouzivatel extends \App\Core\Model
{

    public function __construct(public int $id = 0, public ?string $u_login = null, public ?string $u_email = null,
                                public ?string $u_img = null, public ?string $u_password = null,
                                public ?string $u_role = COMMON)
    {

    }

    static public function setDbColumns()
    {
        return ['id', 'u_login', 'u_email','u_img', 'u_password', 'u_role'];
    }

    static public function setTableName()
    {
        return "users";
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
    public function getLogin(): ?string
    {
        return $this->u_login;
    }

    /**
     * @param string|null $u_login
     */
    public function setLogin(?string $u_login): void
    {
        $this->u_login = $u_login;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->u_email;
    }

    /**
     * @param string|null $u_email
     */
    public function setEmail(?string $u_email): void
    {
        $this->u_email = $u_email;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->u_password;
    }

    /**
     * @param string|null $u_password
     */
    public function setPassword(?string $u_password): void
    {
        $this->u_password = $u_password;
    }

    /**
     * @return string|null
     */
    public function getRole(): ?string
    {
        return $this->u_role;
    }

    /**
     * @param string|null $u_role
     */
    public function setRole(?string $u_role): void
    {
        $this->u_role = $u_role;
    }

    /**
     * @return string|null
     */
    public function getImg(): ?string
    {
        return $this->u_img;
    }

    /**
     * @param string|null $u_img
     */
    public function setImg(?string $u_img): void
    {
        $this->u_img = $u_img;
    }

    public function getReviews()
    {
        return Review::getAll('user_id = ?', [$this->id]);
    }

    public function getRatings()
    {
        return Rating::getAll('user_id = ?', [$this->id]);
    }
}