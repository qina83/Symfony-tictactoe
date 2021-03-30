<?php

namespace App\Identity\Domain\Repository;

use App\Identity\Domain\Model\User;
use Ramsey\Uuid\UuidInterface;

interface UserPersister
{
    public function store(User $user);
}