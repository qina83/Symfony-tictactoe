<?php


namespace App\Game\Application;

use App\Game\Domain\Command\CreateGameCommand;
use App\Game\Domain\Model\Game;
use App\Game\Domain\Repository\GamePersister;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateGameCommandHandler implements MessageHandlerInterface
{
    private GamePersister $gamePersister;

    /**
     * CreateGameCommandHandler constructor.
     * @param GamePersister $gamePersister
     */
    public function __construct(GamePersister $gamePersister)
    {
        $this->gamePersister = $gamePersister;
    }

    public function __invoke(CreateGameCommand $command): UuidInterface
    {
        $game = new Game();
        $this->gamePersister->storeGame($game);
        return $game->getId();
    }
}