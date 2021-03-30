<?php


namespace App\Game\Infrastructure\DBAL;


use App\Game\Domain\Mark;

class MarkMapperDBAL
{
    public static function fromDb($data): ?Mark
    {
        $mark = intval($data);
        if ($mark === 0) return null;
        if ($mark === 1) return Mark::createAsXMark();
        if ($mark === 2) return Mark::createAsOMark();
    }

    public static function toDb(?Mark $mark): int
    {
        if (!$mark) return 0;
        if ($mark->isX()) return 1;
        if ($mark->isO()) return 2;
    }
}