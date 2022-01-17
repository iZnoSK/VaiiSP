<?php

namespace App\Models;

/**
 * Trieda reprezentuje 1 konkrétneho tvorcu (herca, režiséra, scenáristu, kameramana, skladateľa)
 * @package App\Core
 */
class Creator extends \App\Core\Model
{
    public function __construct(public int $id = 0, public ?string $c_name = null, public ?string $c_surname = null,
                                public ?string $c_date_of_birth = null, public ?string $c_place_of_birth = null,
                                public ?string $c_role = null, public ?string $c_img = null, public ?string $c_biography = null)
    {

    }

    /**
     * @return string[]
     */
    static public function setDbColumns()
    {
        return ['id', 'c_name', 'c_surname', 'c_date_of_birth', 'c_place_of_birth', 'c_role', 'c_img', 'c_biography'];
    }

    /**
     * @return string
     */
    static public function setTableName()
    {
        return 'creators';
    }

    /** Getter id tvorcu
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Setter id tvorcu
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /** Getter krstného mena tvorcu
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->c_name;
    }

    /** Setter krstného mena tvorcu
     * @param string|null $c_name
     */
    public function setName(?string $c_name): void
    {
        $this->c_name = $c_name;
    }

    /** Getter priezviska tvorcu
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->c_surname;
    }

    /** Setter priezviska tvorcu
     * @param string|null $c_surname
     */
    public function setSurname(?string $c_surname): void
    {
        $this->c_surname = $c_surname;
    }

    /** Getter dátumu narodenia tvorcu
     * @return string|null
     */
    public function getDateOfBirth(): ?string
    {
        return $this->c_date_of_birth;
    }

    /** Setter dátumu narodenia tvorcu
     * @param string|null $c_date_of_birth
     */
    public function setDateOfBirth(?string $c_date_of_birth): void
    {
        $this->c_date_of_birth = $c_date_of_birth;
    }

    /** Getter miesta narodenia tvorcu
     * @return string|null
     */
    public function getPlaceOfBirth(): ?string
    {
        return $this->c_place_of_birth;
    }

    /** Setter miesta narodenia tvorcu
     * @param string|null $c_place_of_birth
     */
    public function setPlaceOfBirth(?string $c_place_of_birth): void
    {
        $this->c_place_of_birth = $c_place_of_birth;
    }

    /** Getter povolania tvorcu
     * @return string|null
     */
    public function getRole(): ?string
    {
        return $this->c_role;
    }

    /** Setter povolanie tvorcu
     * @param string|null $c_role
     */
    public function setRole(?string $c_role): void
    {
        $this->c_role = $c_role;
    }

    /** Getter fotky tvorcu
     * @return string|null
     */
    public function getImg(): ?string
    {
        return $this->c_img;
    }

    /** Setter fotky tvorcu
     * @param string|null $c_img
     */
    public function setImg(?string $c_img): void
    {
        $this->c_img = $c_img;
    }

    /** Getter biografie tvorcu
     * @return string|null
     */
    public function getBiography(): ?string
    {
        return $this->c_biography;
    }

    /** Setter biografie tvorcu
     * @param string|null $c_biography
     */
    public function setBiography(?string $c_biography): void
    {
        $this->c_biography = $c_biography;
    }


    /** Getter mena a priezviska tvorcu
     * @return string|null
     */
    public function getFullName(): ?string
    {
        return ($this->c_name . " " . $this->c_surname);
    }
}