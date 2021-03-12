<?php


namespace App\Infrastructure\DBAL;


use App\Domain\Player;

class PlayerMapperDBAL
{
    public static function fromDB(array $dbData): Player{
        $id = $dbData["uuid"];
        $nickname = $dbData["nickname"];
        $mark = $dbData["mark"];

        if ($mark === 1)
            return Player::createOPlayer($nickname); //TODO miss id
        else return
            Player::createXPlayer($nickname);
    }
}