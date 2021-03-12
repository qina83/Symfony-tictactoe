<?php


namespace App\Application;


use App\Domain\GamePersister;
use App\Domain\GameRepository;
use App\Domain\PlayerMarkCommand;
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

    public function __invoke(PlayerMarkCommand $command): void
    {
        $game = $this->gameRepository->get($command->getGameId());
        Assert::notNull($game);

        $game->playerMarksByNickName($command->getPlayerNickName(), $command->getTilePosition());
        $this->gamePersister->store($game);
    }
}