<?php

namespace App\Tests\Application;

use App\Game\Application\AddPlayerCommandHandler;
use App\Game\Domain\AddPlayerCommand;
use App\Game\Domain\Game;
use App\Game\Domain\GamePersister;
use App\Game\Domain\GameRepository;
use App\Game\Domain\Mark;
use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Ramsey\Uuid\Uuid;

class AddPlayerCommandHandlerTest extends TestCase
{
    private Prophet $prophet;

    /** @var ObjectProphecy | GamePersister */
    private ObjectProphecy $gamePersister;

    /** @var ObjectProphecy | GameRepository */
    private ObjectProphecy $gameRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->prophet = new Prophet();
        $this->gamePersister = $this->prophet->prophesize(GamePersister::class);
        $this->gameRepository = $this->prophet->prophesize(GameRepository::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->prophet->checkPredictions();
    }

    public function test_gameIdNotExists_mustThrowException()
    {
        $this->gameRepository->get(Argument::any())->willReturn(null);
        $handler = new AddPlayerCommandHandler($this->gamePersister->reveal(), $this->gameRepository->reveal());

        self::expectException(Exception::class);

        $handler(new AddPlayerCommand(Uuid::uuid4(), "aPlayer", Mark::createAsOMark()));
    }

    public function test_addPlayer_mustStoreGame()
    {
        $game = new Game();

        $this->gameRepository->get(Argument::any())->willReturn($game);
        $this->gamePersister->storePlayer(Argument::any(), Argument::any())->shouldBeCalled();
        $handler = new AddPlayerCommandHandler($this->gamePersister->reveal(), $this->gameRepository->reveal());

        $handler(new AddPlayerCommand(Uuid::uuid4(), "aPlayer", Mark::createAsOMark()));

        self::assertTrue(true); //to avoid that is marked as risky test. Assertion is made by prophecy
    }
}
