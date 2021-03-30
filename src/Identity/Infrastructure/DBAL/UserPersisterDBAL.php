<?php


namespace App\Identity\Infrastructure\DBAL;


use App\Identity\Domain\Model\User;
use App\Identity\Domain\Repository\UserPersister;
use Doctrine\DBAL\Connection;

class UserPersisterDBAL implements UserPersister
{
    private Connection $connection;

    /**
     * GamePersisterDBAL constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function store(User $user)
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->insert('user')
            ->values([
                'uuid' => '?',
                'nickName' => '?'
            ])
            ->setParameter(0, $user->getId()->toString())
            ->setParameter(1, $user->getNickName());

        $queryBuilder->execute();
    }
}