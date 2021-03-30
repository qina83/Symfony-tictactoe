<?php


namespace App\Identity\Application;

use App\Identity\Domain\Command\CreateUserCommand;
use App\Game\Domain\Mark;
use App\Game\Domain\Player;
use App\Identity\Domain\Model\User;
use App\Identity\Domain\Repository\UserPersister;
use App\Identity\Domain\Repository\UserRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

class CreateUserCommandHandler implements MessageHandlerInterface
{
    private UserPersister $userPersister;
    private UserRepository $userRepository;

    /**
     * CreateUserCommandHandler constructor.
     * @param UserPersister $userPersister
     * @param UserRepository $userRepository
     */
    public function __construct(UserPersister $userPersister, UserRepository $userRepository)
    {
        $this->userPersister = $userPersister;
        $this->userRepository = $userRepository;
    }


    public function __invoke(CreateUserCommand $command): string
    {
        $nickname = $command->getPlayerNickName();
        $userWithSameNickname = $this->userRepository->getByNickname($nickname);
        Assert::null($userWithSameNickname);

        $user = new User($command->getPlayerNickName());
        $this->userPersister->store($user);
        return $user->getId();
    }
}