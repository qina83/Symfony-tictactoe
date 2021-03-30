<?php


namespace App\Identity\Infrastructure\DBAL;


use App\Identity\Domain\Model\User;
use App\Identity\Domain\Repository\UserRepository;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\UuidInterface;

class UserRepositoryDBAL implements UserRepository
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

    public function get(UuidInterface $userId): ?User
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $dbGame = $queryBuilder
            ->select('*')
            ->from('user',)
            ->where('uuid=?')
            ->setParameter(0, $userId->toString())
            ->execute()
            ->fetchAllAssociative();

        if (0 == \count($dbGame)) {
            return null;
        }

        return UserMapperDBAL::fromDb($dbGame[0]);
    }

    public function getByNickname(string $nickname): ?User
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $dbGame = $queryBuilder
            ->select('*')
            ->from('user',)
            ->where('nickname=?')
            ->setParameter(0, $nickname)
            ->execute()
            ->fetchAllAssociative();

        if (0 == \count($dbGame)) {
            return null;
        }

        return UserMapperDBAL::fromDb($dbGame[0]);
    }
}