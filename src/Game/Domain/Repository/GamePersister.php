<?php


namespace App\Game\Domain\Repository;


use App\Game\Domain\Model\Game;
use App\Game\Domain\Model\Player;
use Ramsey\Uuid\UuidInterface;

interface GamePersister
{
    public function storeGame(Game $game);
    public function storePlayer(Player $player, UuidInterface $gameId);
    public function updateGame(Game $game);
}