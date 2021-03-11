<?php


namespace App\Domain;


use Ramsey\Uuid\UuidInterface;

class AddPlayerCommand
{
     private UuidInterface $gameId;
     private string $playerNickName;

    /**
     * AddPlayerCommand constructor.
     * @param UuidInterface $gameId
     * @param string $playerNickName
     */
    public function __construct(UuidInterface $gameId, string $playerNickName)
    {
        $this->gameId = $gameId;
        $this->playerNickName = $playerNickName;
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