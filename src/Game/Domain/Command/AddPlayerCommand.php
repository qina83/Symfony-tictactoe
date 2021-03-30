<?php


namespace App\Game\Domain\Command;


use App\Game\Domain\Model\Mark;
use Ramsey\Uuid\UuidInterface;

class AddPlayerCommand
{
    private UuidInterface $gameId;
    private string $playerNickName;
    private Mark $mark;

    /**
     * AddPlayerCommand constructor.
     * @param UuidInterface $gameId
     * @param string $playerNickName
     * @param Mark $mark
     */
    public function __construct(UuidInterface $gameId, string $playerNickName, Mark $mark)
    {
        $this->gameId = $gameId;
        $this->playerNickName = $playerNickName;
        $this->mark = $mark;
    }

    /**
     * @return Mark
     */
    public function getMark(): Mark
    {
        return $this->mark;
    }


    /**
     * @return UuidInterface
     */
    public function getGameId(): UuidInterface
    {
        return $this->gameId;
    }

    /**
     * @return string
     */
    public function getPlayerNickName(): string
    {
        return $this->playerNickName;
    }

}