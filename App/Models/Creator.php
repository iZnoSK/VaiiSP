<?php

namespace App\Models;

class Creator extends \App\Core\Model
{
    public function __construct(public int $id = 0, public ?string $c_name = null, public ?string $c_surname = null,
                                public ?string $c_date_of_birth = null, public ?string $c_place_of_birth = null,
                                public ?string $c_role = null, public ?string $c_img = null, public ?string $c_biography = null)
    {

    }

    static public function setDbColumns()
    {
        return ['id', 'c_name', 'c_surname', 'c_date_of_birth', 'c_place_of_birth', 'c_role', 'c_img', 'c_biography'];
    }

    static public function setTableName()
    {
        return 'creators';
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
    public function getName(): ?string
    {
        return $this->c_name;
    }

    /**
     * @param string|null $c_name
     */
    public function setName(?string $c_name): void
    {
        $this->c_name = $c_name;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->c_surname;
    }

    /**
     * @param string|null $c_surname
     */
    public function setSurname(?string $c_surname): void
    {
        $this->c_surname = $c_surname;
    }

    /**
     * @return string|null
     */
    public function getDateOfBirth(): ?string
    {
        return $this->c_date_of_birth;
    }

    /**
     * @param string|null $c_date_of_birth
     */
    public function setDateOfBirth(?string $c_date_of_birth): void
    {
        $this->c_date_of_birth = $c_date_of_birth;
    }

    /**
     * @return string|null
     */
    public function getPlaceOfBirth(): ?string
    {
        return $this->c_place_of_birth;
    }

    /**
     * @param string|null $c_place_of_birth
     */
    public function setPlaceOfBirth(?string $c_place_of_birth): void
    {
        $this->c_place_of_birth = $c_place_of_birth;
    }

    /**
     * @return string|null
     */
    public function getRole(): ?string
    {
        return $this->c_role;
    }

    /**
     * @param string|null $c_role
     */
    public function setRole(?string $c_role): void
    {
        $this->c_role = $c_role;
    }

    /**
     * @return string|null
     */
    public function getImg(): ?string
    {
        return $this->c_img;
    }

    /**
     * @param string|null $c_img
     */
    public function setImg(?string $c_img): void
    {
        $this->c_img = $c_img;
    }

    /**
     * @return string|null
     */
    public function getBiography(): ?string
    {
        return $this->c_biography;
    }

    /**
     * @param string|null $c_biography
     */
    public function setBiography(?string $c_biography): void
    {
        $this->c_biography = $c_biography;
    }

    public function getFullName(): ?string
    {
        return ($this->c_name . " " . $this->c_surname);
    }
}