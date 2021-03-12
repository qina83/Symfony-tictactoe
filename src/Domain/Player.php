<?php


namespace App\Domain;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Player
{
    private UuidInterface $id;
    private string $nickName;
    private Mark $mark;

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getMark(): Mark
    {
        return $this->mark;
    }

    /**
     * Player constructor.
     * @param string $nickName
     * @param Mark $mark
     */
    public function __construct(string $nickName, Mark $mark)
    {
        $this->id = Uuid::uuid4();
        $this->nickName = $nickName;
        $this->mark = $mark;
    }


    public function getNickName(): string
    {
        return $this->nickName;
    }

    public function sameMarkOf(Player $player){
        return $this->mark->equalTo($player->mark);
    }
}