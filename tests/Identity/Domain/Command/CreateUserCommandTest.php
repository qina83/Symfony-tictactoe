<?php

namespace App\Tests\Identity\Domain\Command;

use App\Identity\Domain\Command\CreateUserCommand;
use Exception;
use PHPUnit\Framework\TestCase;

class CreateUserCommandTest extends TestCase
{
    public function test_constructor_nicknameMustBeNotEmpty()
    {
        self::expectException(Exception::class);
        new CreateUserCommand("");
    }
}
