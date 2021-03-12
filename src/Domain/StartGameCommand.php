<?php


namespace App\Domain;


use Ramsey\Uuid\UuidInterface;

class StartGameCommand
{
    private UuidInterface $gameId;

    /**
     * StartGameCommand constructor.
     * @param UuidInterface $gameId
     */
    public function __construct(UuidInterface $gameId)
    {
        $this->gameId = $gameId;
    }

    /**
     * @return UuidInterface
     */
    public function getGameId(): UuidInterface
    {
        return $this->gameId;
    }
}