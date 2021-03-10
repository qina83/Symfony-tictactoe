<?php


namespace App\Domain;

use Exception;

class Tile
{
    private int $mark;

    /**
     * Tile constructor.
     */
    public function __construct()
    {
        $this->clean();
    }

    public function markWithO(): void
    {
        if (!$this->isClean()) throw new Exception("Tile is not clean");
        $this->mark = 1;
    }

    public function markWithX(): void
    {
        if (!$this->isClean()) throw new Exception("Tile is not clean");
        $this->mark = 2;
    }

    public function clean(): void
    {
        $this->mark = 0;
    }

    public function isClean(): bool
    {
        return $this->mark == 0;
    }

    public function isO(): bool
    {
        return $this->mark == 1;
    }

    public function isX(): bool
    {
        return $this->mark == 2;
    }

    public function markedAs(Tile $tile){
        return $tile->mark == $this->mark;
    }

}