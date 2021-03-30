<?php


namespace App\Game\Infrastructure\DBAL;


use App\Game\Domain\Model\Board;
use App\Game\Domain\Model\Game;
use App\Game\Domain\Repository\GameRepository;
use App\Game\Domain\Model\Player;
use App\Game\Domain\Model\Tile;
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
        $players = $this->getPlayers($gameId);
        $board = $this->getBoard($gameId);

        $game = $this->getGame($gameId, $players, $board);
        return $game;
    }


    /**
     * @param UuidInterface $gameId
     * @return Tile[][]
     */
    private function getTiles(UuidInterface $gameId): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $data = $queryBuilder
            ->select('*')
            ->from('tile',)
            ->where('game_id=?')
            ->setParameter(0, $gameId->toString())
            ->execute()
            ->fetchAllAssociative();

        return TilesMapperDBAL::fromDb($data);
    }

    private function getBoard(UuidInterface $gameId): ?Board
    {

        $tiles = $this->getTiles($gameId);

        $queryBuilder = $this->connection->createQueryBuilder();

        $dbGame = $queryBuilder
            ->select('uuid')
            ->from('board',)
            ->where('game_id=?')
            ->setParameter(0, $gameId->toString())
            ->execute()
            ->fetchAllAssociative();

        if (0 == \count($dbGame)) {
            return null;
        }

        return BoardMapperDBAL::fromDb($dbGame[0], $tiles);
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

    /**
     * @param Player[] $players
     */
    private function getGame(UuidInterface $gameId, array $players, Board $board): ?Game
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $dbGame = $queryBuilder
            ->select('*')
            ->from('game',)
            ->where('uuid=?')
            ->setParameter(0, $gameId->toString())
            ->execute()
            ->fetchAllAssociative();

        if (0 == \count($dbGame)) {
            return null;
        }

        return GameMapperDBAL::fromDb($dbGame[0],$players, $board);
    }
}