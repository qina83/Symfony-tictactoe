<?php


namespace App\Identity\Domain\Command;

use Ramsey\Uuid\UuidInterface;

namespace App\Identity\Domain\Command;

use Webmozart\Assert\Assert;

class CreateUserCommand
{
    private string $playerNickName;

    /**
     * CreateUserCommand constructor.
     * @param string $playerNickName
     */
    public function __construct(string $playerNickName)
    {
        Assert::notEmpty($playerNickName);
        $this->playerNickName = $playerNickName;
    }


    /**
     * @return string
     */
    public function getPlayerNickName(): string
    {
        return $this->playerNickName;
    }


}