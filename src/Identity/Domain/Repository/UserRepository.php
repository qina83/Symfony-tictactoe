<?php

namespace App\Identity\Domain\Repository;

use App\Identity\Domain\Model\User;
use Ramsey\Uuid\UuidInterface;

interface UserRepository
{
    public function get(UuidInterface $userId): ?User;
    public function getByNickname(string $nickname): ?User;
}