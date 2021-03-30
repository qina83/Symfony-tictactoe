<?php


namespace App\Game\Application;

use App\Game\Domain\Model\Game;
use App\Game\Domain\Repository\GamePersister;
use App\Game\Domain\Repository\GameRepository;
use App\Game\Domain\Command\PlayerMarkCommand;
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