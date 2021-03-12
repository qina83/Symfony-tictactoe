<?php


namespace App\Application;

use App\Domain\AddPlayerCommand;
use App\Domain\GamePersister;
use App\Domain\GameRepository;
use App\Domain\Mark;
use App\Domain\Player;
use App\Domain\StartGameCommand;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

class StartGameCommandHandler implements MessageHandlerInterface
{
    private GamePersister $gamePersister;
    private GameRepository $gameRepository;

    /**
     * AddPlayerCommandHandler constructor.
     * @param GamePersister $gamePersister
     * @param GameRepository $gameRepository
     */
    public function __construct(GamePersister $gamePersister, GameRepository $gameRepository)
    {
        $this->gamePersister = $gamePersister;
        $this->gameRepository = $gameRepository;
    }

    public function __invoke(StartGameCommand $command): void
    {
        $game = $this->gameRepository->get($command->getGameId());
        Assert::notNull($game);

        $game->startGame();
        $this->gamePersister->updateGame($game);
    }
}