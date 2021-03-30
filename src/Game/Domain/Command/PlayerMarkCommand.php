<?php


namespace App\Game\Domain\Command;

use App\Game\Domain\Model\TilePosition;
use Ramsey\Uuid\UuidInterface;

class PlayerMarkCommand
{
    private UuidInterface $gameId;
    private string $playerNickName;
    private TilePosition $tilePosition;

    /**
     * PlayerMarkCommand constructor.
     * @param UuidInterface $gameId
     * @param string $playerNickName
     * @param TilePosition $tilePosition
     */
    public function __construct(UuidInterface $gameId, string $playerNickName, TilePosition $tilePosition)
    {
        $this->gameId = $gameId;
        $this->playerNickName = $playerNickName;
        $this->tilePosition = $tilePosition;
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

    /**
     * @return TilePosition
     */
    public function getTilePosition(): TilePosition
    {
        return $this->tilePosition;
    }


}