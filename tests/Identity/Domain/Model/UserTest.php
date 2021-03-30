<?php

namespace App\Tests\Identity\Domain\Model;

use App\Identity\Domain\Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_userStartEnabled(){
        $user = new User("nick");

        self::assertTrue($user->isEnabled());
    }

    public function test_disable(){
        $user = new User("nick");

        $user->disable();

        self::assertFalse($user->isEnabled());
    }

    public function test_enable(){
        $user = new User("nick");

        $user->disable();
        $user->enable();

        self::assertTrue($user->isEnabled());
    }
}
