<?php


namespace App\Identity\Infrastructure\DBAL;


use App\Identity\Domain\Model\User;

class UserMapperDBAL
{
    public static function fromDB(array $dbData): User
    {
        $id = $dbData["uuid"];
        $nickname = $dbData["nickname"];

        return User::fromData($id, $nickname);
    }
}