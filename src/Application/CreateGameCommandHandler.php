<?php


namespace App\Application;

use App\Domain\CreateGameCommand;
use App\Domain\Game;
use App\Domain\GamePersister;
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