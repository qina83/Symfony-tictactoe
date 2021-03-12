<?php


namespace App\Application;

use App\Domain\AddPlayerCommand;
use App\Domain\GamePersister;
use App\Domain\GameRepository;
use App\Domain\Mark;
use App\Domain\Player;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

class AddPlayerCommandHandler implements MessageHandlerInterface
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

    public function __invoke(AddPlayerCommand $command): void
    {
        $game = $this->gameRepository->get($command->getGameId());
        Assert::notNull($game);

        $player = new Player($command->getPlayerNickName(), $command->getMark());
        $game->addPlayer($player);
        $this->gamePersister->storePlayer($player, $game->getId());
    }
}