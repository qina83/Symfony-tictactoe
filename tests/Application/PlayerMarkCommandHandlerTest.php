<?php

namespace App\Tests\Application;

use App\Application\PlayerMarkCommandHandler;
use App\Domain\Game;
use App\Domain\GamePersister;
use App\Domain\GameRepository;
use App\Domain\Mark;
use App\Domain\Player;
use App\Domain\PlayerMarkCommand;
use App\Domain\TilePosition;
use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Ramsey\Uuid\Uuid;

class PlayerMarkCommandHandlerTest extends TestCase
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

    public function test_gameIdNotExists_mustThrowException(){
        $this->gameRepository->get(Argument::any())->willReturn(null);
        $handler = new PlayerMarkCommandHandler($this->gamePersister->reveal(), $this->gameRepository->reveal());

        self::expectException(Exception::class);

        $handler(new PlayerMarkCommand( Uuid::uuid4(), "aPlayer", new TilePosition(1,1)));
    }

    public function test_addPlayer_mustStoreGame(){
        $game = new Game();
        $player1 = new Player("player1", Mark::createAsXMark());
        $player2 = new Player("player2", Mark::createAsOMark());
        $game->addPlayer($player1);
        $game->addPlayer($player2);
        $game->startGame();

        $this->gameRepository->get(Argument::any())->willReturn($game);

        $handler = new PlayerMarkCommandHandler($this->gamePersister->reveal(), $this->gameRepository->reveal());
        $this->gamePersister->updateGame($game)->shouldBeCalled();
        $handler(new PlayerMarkCommand( Uuid::uuid4(), "player1", new TilePosition(1,1)));

        self::assertTrue(true); //to avoid that is marked as risky test. Assertion is made by prophecy
    }
}
