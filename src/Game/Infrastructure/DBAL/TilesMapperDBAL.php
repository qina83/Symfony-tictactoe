<?php


namespace App\Game\Infrastructure\DBAL;

use App\Game\Domain\Model\Tile;
use Ramsey\Uuid\Rfc4122\UuidV4;

class TilesMapperDBAL
{
    /**
     * @param array $dbData
     * @return Tile[][]
     */
    public static function fromDb(array $dbData): array
    {
        $tiles = [];
        foreach ($dbData as $data){
            $id = UuidV4::fromString($data['uuid']);
            $row = intval($data['row']);
            $col = intval($data['col']);
            $tile = Tile::fromData($id, MarkMapperDBAL::fromDb($data['mark']));
            $tiles[$row][$col] = $tile;
        }

        return $tiles;
    }
}