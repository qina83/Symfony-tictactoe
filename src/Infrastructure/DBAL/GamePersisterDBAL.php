<?php


namespace App\Infrastructure\DBAL;


use App\Domain\Board;
use App\Domain\Tile;
use App\Domain\Player;
use App\Domain\Game;
use App\Domain\GamePersister;
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

    public function store(Game $game): void
    {
        try {
            $this->connection->beginTransaction();
            $this->storeBoard($game->getBoard());
            $this->storeTiles($game->getBoard()->getTiles(), $game->getBoard()->getId());
            $this->storeGame($game, $game->getBoard()->getId());
            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    private function storeBoard(Board $board): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->insert('board')
            ->values([
                'uuid' => '?',
            ])
            ->setParameter(0, $board->getId()->toString());

        $queryBuilder->execute();
    }

    /**
     * @param Tile[][] $tiles
     */
    private function storeTiles(array $tiles, UuidInterface $boardId): void
    {

        foreach ($tiles as $tileRow) {
            foreach ($tileRow as $tile) {
                $queryBuilder = $this->connection->createQueryBuilder();
                $queryBuilder
                    ->insert('tile')
                    ->values([
                        'uuid' => '?',
                        'mark' => '?',
                        'board_id' => '?'
                    ])
                    ->setParameter(0, $tile->getId()->toString())
                    ->setParameter(1, $tile->getMark()) //servirebbe un mapper. Per velocità ho messo il metodo get esposto.
                    ->setParameter(2, $boardId->toString());

                $queryBuilder->execute();
            }
        }
    }

    private function storeGame(Game $game, UuidInterface $boardId): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->insert('game')
            ->values([
                'uuid' => '?',
                'board_id' => '?'
            ])
            ->setParameter(0, $game->getId()->toString())
            ->setParameter(1, $boardId->toString());

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
                'game_id' => '?'
            ])
            ->setParameter(0, $player->getId()->toString())
            ->setParameter(1, $player->getMark())
            ->setParameter(2, $player->getNickName())
            ->setParameter(3, $gameId->toString());

        $queryBuilder->execute();
    }
}