<?php


namespace App\Infrastructure\DBAL;


use App\Domain\Game;
use Ramsey\Uuid\Rfc4122\UuidV4;

class GameMapperDBAL
{

    public static function fromDb(array $dbData): Game
    {
        $id = UuidV4::fromString($dbData['uuid']);
      //  $game = Game::fromData($id);
      return new Game();
      //return $game;
    }
}