<?php


namespace App\Game\Domain\Model;

use Exception;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Tile
{

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

    public static function fromData(string $id, ?Mark $mark): Tile{
        $tile = new Tile();
        $tile->id = UuidV4::fromString($id);
        $tile->mark = $mark;
        return $tile;
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