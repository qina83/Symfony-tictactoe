<?php


namespace App\Identity\Infrastructure\DBAL;


use App\Identity\Domain\Model\User;
use App\Identity\Domain\Repository\UserRepository;
use Ramsey\Uuid\UuidInterface;

class UserRepositoryDBAL implements UserRepository
{

    public function get(UuidInterface $gameId): ?User
    {
       return null;
    }
}