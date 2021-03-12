<?php


namespace App\Infrastructure\DBAL;


use App\Domain\Game;
use App\Domain\GameRepository;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\UuidInterface;

class GameRepositoryDBAL implements GameRepository
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

    public function get(UuidInterface $gameId): ?Game
    {
        $game = $this->getGame($gameId);
        if (!$game) return null;



    }

    /**
     * @return Player[]
     */
    private function getPlayers(UuidInterface $gameId): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $dbPlayers = $queryBuilder
            ->select('uuid, nickname, mark')
            ->from('player')
            ->where('game_id=?')
            ->setParameter(0, $gameId->toString())
            ->execute()
            ->fetchAllAssociative();


        $players = [];
        foreach ($dbPlayers as $dbPlayer) {
            $players[] = PlayerMapperDBAL::fromDB($dbPlayer);
        }

        return $players;

    }

    private function getGame(UuidInterface $gameId): ?Game
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $dbGame = $queryBuilder
            ->select('uuid')
            ->from('game',)
            ->where('uuid=?')
            ->setParameter(0, $gameId->toString())
            ->execute()
            ->fetchAllAssociative();

        if (0 == \count($dbGame)) {
            return null;
        }

        return GameMapperDBAL::fromDb($dbGame[0]);
    }
}