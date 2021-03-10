<?php


namespace App\Domain;


class Player
{
    private string $nickName;
    private int $mark;
    private Board $board;

    /**
     * Player constructor.
     * @param string $nickName
     * @param int $mark
     * @param Board $board
     */
    public function __construct(string $nickName, int $mark, Board $board)
    {
        $this->nickName = $nickName;
        $this->mark = $mark;
        $this->board = $board;
    }


    public function getNickName(): string
    {
        return $this->nickName;
    }

    public static function createXPlayer(string $nickName, Board $board)
    {
        return new Player($nickName, 2, $board);
    }

    public static function createOPlayer(string $nickName, Board $board)
    {
        return new Player($nickName, 1, $board);
    }

    public function isX()
    {
        return $this->mark == 2;
    }

    public function isO()
    {
        return $this->mark == 1;
    }

    public function mark(TilePosition $position)
    {
        if ($this->isO())
            $this->board->markTileAsO($position);
        else
            $this->board->markTileAsX($position);
    }
}