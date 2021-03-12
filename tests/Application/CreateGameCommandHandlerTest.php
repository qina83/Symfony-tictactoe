<?php

namespace App\Tests\Application;

use App\Application\CreateGameCommandHandler;
use App\Domain\CreateGameCommand;
use App\Domain\GamePersister;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;


class CreateGameCommandHandlerTest extends TestCase
{
    private Prophet $prophet;

    /** @var ObjectProphecy | GamePersister */
    private ObjectProphecy $gamePersister;


    protected function setUp(): void
    {
        parent::setUp();
        $this->prophet = new Prophet();
        $this->gamePersister = $this->prophet->prophesize(GamePersister::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->prophet->checkPredictions();
    }

    public function test_admin()
    {
        $this->gamePersister->storeGame(Argument::any())->shouldBeCalled();
        $handler = new CreateGameCommandHandler($this->gamePersister->reveal());
        $gameId = $handler(new CreateGameCommand());

        self::assertNotNull($gameId);
    }
}
