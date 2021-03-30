<?php


namespace App\Identity\Domain\Model;


use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;

class User
{
    private UuidInterface $id;
    private string $nickname;
    private bool $disabled;

    /**
     * User constructor.
     * @param string $nickname
     */
    public function __construct(string $nickname)
    {
        $this->id = UuidV4::uuid4();
        $this->disabled = false;
        $this->nickname = $nickname;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return !$this->disabled;
    }

    public static function fromData(UuidInterface $id, string $nickname): User
    {
        $user = new User($nickname);
        $user->id = $id;
        return $user;
    }

    public function disable(){
        $this->disabled = true;
    }

    public function enable(){
        $this->disabled = false;
    }

}