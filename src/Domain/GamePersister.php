<?php


namespace App\Domain;


use Ramsey\Uuid\UuidInterface;

interface GamePersister
{
    public function store(Game $game);
    public function storePlayer(Player $player, UuidInterface $gameId);
}