<?php

namespace App\Models;

class Genre extends \App\Core\Model
{
    public function __construct(public int $id = 0, public ?string $g_name = null)
    {

    }

    static public function setDbColumns()
    {
        return ['id', 'g_name'];
    }

    static public function setTableName()
    {
        return 'genres';
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
        return $this->g_name;
    }

    /**
     * @param string|null $g_name
     */
    public function setName(?string $g_name): void
    {
        $this->g_name = $g_name;
    }


}