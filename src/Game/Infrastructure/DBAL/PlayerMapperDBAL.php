<?php


namespace App\Game\Infrastructure\DBAL;


use App\Game\Domain\Mark;
use App\Game\Domain\Player;

class PlayerMapperDBAL
{
    public static function fromDB(array $dbData): Player
    {
        $id = $dbData["uuid"];
        $nickname = $dbData["nickname"];
        $mark = intval($dbData["mark"]);

        return Player::fromData($id, $nickname, $mark === 1 ? Mark::createAsXMark() : Mark::createAsOMark());
    }
}