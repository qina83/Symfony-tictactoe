<?php


namespace App\Game\Domain\Model;


class TilePosition
{
    private int $row;
    private int $col;

    /**
     * TilePosition constructor.
     * @param int $row
     * @param int $col
     */
    public function __construct(int $row, int $col)
    {
        $this->row = $row;
        $this->col = $col;
    }

    /**
     * @return int
     */
    public function getRow(): int
    {
        return $this->row;
    }

    /**
     * @return int
     */
    public function getCol(): int
    {
        return $this->col;
    }


}