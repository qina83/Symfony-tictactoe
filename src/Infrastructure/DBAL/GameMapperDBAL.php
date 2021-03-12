<?php


namespace App\Infrastructure\DBAL;


use App\Domain\Board;
use App\Domain\Game;
use App\Domain\Player;
use Ramsey\Uuid\Rfc4122\UuidV4;

class GameMapperDBAL
{
    /**
     * @param Player[] $players
     */
    public static function fromDb(array $dbData, array $players, Board $board): Game
    {
        $id = UuidV4::fromString($dbData['uuid']);
        $nextPlayerId = $dbData['next_player_id'] ? UuidV4::fromString($dbData['next_player_id']) : null;
        return Game::fromData($id, $nextPlayerId, $players, $board);
    }
}