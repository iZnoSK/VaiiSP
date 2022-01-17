<?php

namespace App\Models;

/**
 * Trieda reprezentuje 1 konkrétny žáner filmu
 * @package App\Models
 */
class Genre extends \App\Core\Model
{
    /** Konštruktor triedy žáner
     * @param int $id
     * @param string|null $g_name
     */
    public function __construct(public int $id = 0, public ?string $g_name = null)
    {

    }

    /**
     * @return string[]
     */
    static public function setDbColumns()
    {
        return ['id', 'g_name'];
    }

    /**
     * @return string
     */
    static public function setTableName()
    {
        return 'genres';
    }

    /**
     * Getter id žánru
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Setter id žánru
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Getter názvu žánru
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->g_name;
    }

    /**
     * Setter názvu žánru
     * @param string|null $g_name
     */
    public function setName(?string $g_name): void
    {
        $this->g_name = $g_name;
    }
}