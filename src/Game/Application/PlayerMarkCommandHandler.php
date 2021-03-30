<?php


namespace App\Game\Application;

use App\Game\Domain\Game;
use App\Game\Domain\GamePersister;
use App\Game\Domain\GameRepository;
use App\Game\Domain\PlayerMarkCommand;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

class PlayerMarkCommandHandler implements MessageHandlerInterface
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

    public function __invoke(PlayerMarkCommand $command): Game
    {
        $game = $this->gameRepository->get($command->getGameId());
        Assert::notNull($game);

        $game->playerMarksByNickName($command->getPlayerNickName(), $command->getTilePosition());
        $this->gamePersister->updateGame($game);
        return $game;
    }
}