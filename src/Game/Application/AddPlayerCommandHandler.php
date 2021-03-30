<?php


namespace App\Game\Application;

use App\Identity\Domain\Repository\UserRepository;

use App\Game\Domain\Command\AddPlayerCommand;
use App\Game\Domain\Repository\GamePersister;
use App\Game\Domain\Repository\GameRepository;
use App\Game\Domain\Model\Player;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

class AddPlayerCommandHandler implements MessageHandlerInterface
{
    private GamePersister $gamePersister;
    private GameRepository $gameRepository;
    private UserRepository $userRepository;

    /**
     * AddPlayerCommandHandler constructor.
     * @param GamePersister $gamePersister
     * @param GameRepository $gameRepository
     * @param UserRepository $userRepository
     */
    public function __construct(GamePersister $gamePersister, GameRepository $gameRepository, UserRepository $userRepository)
    {
        $this->gamePersister = $gamePersister;
        $this->gameRepository = $gameRepository;
        $this->userRepository = $userRepository;
    }


    public function __invoke(AddPlayerCommand $command): void
    {
        $game = $this->gameRepository->get($command->getGameId());
        Assert::notNull($game);

        $exUser = $this->userRepository->getByNickname($command->getPlayerNickName());
        Assert::notNull($exUser);

        $player = new Player($command->getPlayerNickName(), "fa05b2ac-5988-42d6-a48d-ee62ad63ad02", $command->getMark());
        $game->addPlayer($player);
        $this->gamePersister->storePlayer($player, $game->getId());
    }
}