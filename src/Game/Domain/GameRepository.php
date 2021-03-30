<?php


namespace App\Game\Domain;


use Ramsey\Uuid\UuidInterface;

interface GameRepository
{
    public function get(UuidInterface $gameId): ?Game;
}