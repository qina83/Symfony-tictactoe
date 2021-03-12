<?php


namespace App\Domain;

use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Tile
{
    //TODO Mark maybe is a domain object
    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }
    private UuidInterface $id;
    private ?Mark $mark;

    /**
     * Tile constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->clean();
    }

    /**
     * @return int
     */
    public function getMark(): ?Mark
    {
        return $this->mark;
    }

    public function mark(Mark $mark): void
    {
        if (!$this->isClean()) throw new Exception("Tile is not clean");
        $this->mark =$mark;
    }

    public function clean(): void
    {
        $this->mark = null;
    }

    public function isClean(): bool
    {
        return !$this->mark;
    }

    public function markedAs(Tile $tile){
        if ($this->isClean() && $this->isClean()) return true;

        if (($this->isClean() && !$tile->isClean()) ||
            (!$this->isClean() && $tile->isClean())) return false;

        return $tile->mark->equalTo($this->mark);
    }

}