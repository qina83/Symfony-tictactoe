<?php


namespace App\Game\Infrastructure\DBAL;


use App\Game\Domain\Model\Mark;
use App\Game\Domain\Model\Player;

class PlayerMapperDBAL
{
    public static function fromDB(array $dbData): Player
    {
        $id = $dbData["uuid"];
        $nickname = $dbData["nickname"];
        $userId = $dbData["user_id"];
        $mark = intval($dbData["mark"]);

        return Player::fromData($id, $nickname,$userId, $mark === 1 ? Mark::createAsXMark() : Mark::createAsOMark());
    }
}