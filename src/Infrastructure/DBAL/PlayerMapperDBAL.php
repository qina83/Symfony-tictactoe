<?php


namespace App\Infrastructure\DBAL;


use App\Domain\Mark;
use App\Domain\Player;

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