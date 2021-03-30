<?php


namespace App\Game\Domain\Repository;


use App\Game\Domain\Model\Game;
use Ramsey\Uuid\UuidInterface;

interface GameRepository
{
    public function get(UuidInterface $gameId): ?Game;
}