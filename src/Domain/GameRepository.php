<?php


namespace App\Domain;


use Ramsey\Uuid\UuidInterface;

interface GameRepository
{
    public function get(UuidInterface $gameId): ?Game;
}