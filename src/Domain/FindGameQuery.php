<?php


namespace App\Domain;


use Ramsey\Uuid\UuidInterface;

interface FindGameQuery
{
    public function execute(UuidInterface $gameId): Game;
}