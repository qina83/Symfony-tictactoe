<?php

namespace App\Tests\Identity\Application;

use App\Identity\Application\CreateUserCommandHandler;
use App\Identity\Domain\Command\CreateUserCommand;
use App\Identity\Domain\Model\User;
use App\Identity\Domain\Repository\UserPersister;
use App\Identity\Domain\Repository\UserRepository;
use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;

class CreateUserCommandHandlerTest extends TestCase
{
    private Prophet $prophet;

    /** @var ObjectProphecy | UserPersister */
    private ObjectProphecy $userPersister;

    /** @var ObjectProphecy | UserRepository */
    private ObjectProphecy $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->prophet = new Prophet();
        $this->userPersister = $this->prophet->prophesize(UserPersister::class);
        $this->userRepository = $this->prophet->prophesize(UserRepository::class);
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
        parent::tearDown();
    }

    public function test_createUser_storeMustBeCalled()
    {
        $this->userRepository->getByNickname(Argument::any())->willReturn(null);
        $this->userPersister->store(Argument::any())->shouldBeCalled();
        $handler = new CreateUserCommandHandler($this->userPersister->reveal(), $this->userRepository->reveal());

        $handler(new CreateUserCommand("nick"));

        self::assertTrue(true); //to avoid that is marked as risky test. Assertion is made by prophecy
    }

    public function test_createUser_userWithSameNikcnameExists_mustThrowException()
    {
        $this->userRepository->getByNickname(Argument::any())->willReturn(new User(("nick")));
        $handler = new CreateUserCommandHandler($this->userPersister->reveal(), $this->userRepository->reveal());

        self::expectException(Exception::class);
        $handler(new CreateUserCommand("nick"));

    }
}
