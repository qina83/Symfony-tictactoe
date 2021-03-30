<?php


namespace App\Game\Infrastructure\DBAL;


use App\Game\Domain\Model\Board;
use App\Game\Domain\Model\Tile;
use App\Game\Domain\Model\Player;
use App\Game\Domain\Model\Game;
use App\Game\Domain\Repository\GamePersister;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class GamePersisterDBAL implements GamePersister
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

    public function storeGame(Game $game): void
    {
        try {
            $this->connection->beginTransaction();
            $this->store($game);
            $this->storeBoard($game->getBoard(), $game->getId());
            $this->storeTiles($game->getBoard()->getTiles(), $game->getId());
            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    private function storeBoard(Board $board, UuidInterface $gameId): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->insert('board')
            ->values([
                'uuid' => '?',
                'game_id' => '?'
            ])
            ->setParameter(0, $board->getId()->toString())
            ->setParameter(1, $gameId->toString());

        $queryBuilder->execute();
    }

    /**
     * @param Tile[][] $tiles
     */
    private function storeTiles(array $tiles, UuidInterface $gameId): void
    {
        for ($row = 1; $row <= 3; $row++) {
            for ($col = 1; $col <= 3; $col++) {
                $tile = $tiles[$row][$col];

                $queryBuilder = $this->connection->createQueryBuilder();
                $queryBuilder
                    ->insert('tile')
                    ->values([
                        'uuid' => '?',
                        'row' => '?',
                        'col' => '?',
                        'game_id' => '?'
                    ])
                    ->setParameter(0, $tile->getId()->toString())
                    ->setParameter(1, $row)
                    ->setParameter(2, $col)
                    ->setParameter(3, $gameId->toString());

                $queryBuilder->execute();
            }
        }
    }

    private function store(Game $game): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->insert('game')
            ->values([
                'uuid' => '?'
            ])
            ->setParameter(0, $game->getId()->toString());

        $queryBuilder->execute();
    }

    public function storePlayer(Player $player, UuidInterface $gameId): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->insert('player')
            ->values([
                'uuid' => '?',
                'mark' => '?',
                'nickName' => '?',
                'game_id' => '?',
                'user_id' => '?'
            ])
            ->setParameter(0, $player->getId()->toString())
            ->setParameter(1, $player->getMark()->isX() ? 1 : 2)
            ->setParameter(2, $player->getNickName())
            ->setParameter(3, $gameId->toString())
            ->setParameter(3, $player->getUserId());

        $queryBuilder->execute();
    }

    /**
     * @param Tile[][] $tiles
     */
    private function updateTiles(array $tiles): void
    {
        foreach ($tiles as $tileRow) {
            foreach ($tileRow as $tile) {
                $queryBuilder = $this->connection->createQueryBuilder();
                $queryBuilder
                    ->update('tile')
                    ->set('mark', MarkMapperDBAL::toDb($tile->getMark()))
                    ->where("uuid = '{$tile->getId()}'");

                $queryBuilder->execute();
            }
        }
    }

    private function updateGameStatus(Game $game)
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->update('game')
            ->set('next_player_id', "'{$game->getNextPlayerId()}'")
            ->where("uuid = '{$game->getId()}'");

        $queryBuilder->execute();
    }

    public function updateGame(Game $game)
    {
        try {
            $this->connection->beginTransaction();
            $this->updateTiles($game->getBoard()->getTiles());
            $this->updateGameStatus($game);
            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }
}