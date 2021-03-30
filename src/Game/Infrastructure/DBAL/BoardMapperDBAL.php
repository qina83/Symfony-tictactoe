<?php


namespace App\Game\Infrastructure\DBAL;


use App\Game\Domain\Model\Board;
use App\Game\Domain\Model\Tile;
use Ramsey\Uuid\Rfc4122\UuidV4;

class BoardMapperDBAL
{
    /**
     * @param array $dbData
     * @param Tile[][] $tiles
     * @return Board
     */
    public static function fromDb(array $dbData, array $tiles): Board
    {
        $id = UuidV4::fromString($dbData['uuid']);
        return Board::fromData($id, $tiles);
    }
}