<?php


namespace App\Game\Domain\Model;


use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Player
{
    /**
     * @return UuidInterface
     */
    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }
    private UuidInterface $id;
    private UuidInterface $userId;
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

    public function __construct(string $nickName, string $userId, Mark $mark)
    {
        $this->id = Uuid::uuid4();
        $this->nickName = $nickName;
        $this->userId = UuidV4::fromString($userId);
        $this->mark = $mark;
    }

    public static function fromData(string $id, string $nickName, string $userId, Mark $mark):Player
    {
        $player = new Player($nickName,$userId, $mark);
        $player->id = UuidV4::fromString($id);
        return $player;
    }


    public function getNickName(): string
    {
        return $this->nickName;
    }

    public function sameMarkOf(Player $player){
        return $this->mark->equalTo($player->mark);
    }
}