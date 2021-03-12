<?php


namespace App\Domain;

use Exception;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Board
{
    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    private UuidInterface $id;

    /** @var Tile[][] */
    private array $tiles;

    /** @var TilePosition[][] */
    private array $winnerPositions;

    /**
     * Board constructor.
     */
    private function __construct()
    {
        $this->id = Uuid::uuid4();

        $this->winnerPositions = [
            [
                new TilePosition(1, 1),
                new TilePosition(1, 2),
                new TilePosition(1, 3),
            ],
            [
                new TilePosition(2, 1),
                new TilePosition(2, 2),
                new TilePosition(2, 3),
            ],
            [
                new TilePosition(3, 1),
                new TilePosition(3, 2),
                new TilePosition(3, 3),
            ],
            [
                new TilePosition(1, 1),
                new TilePosition(2, 1),
                new TilePosition(3, 1),
            ],
            [
                new TilePosition(1, 2),
                new TilePosition(2, 2),
                new TilePosition(3, 2),
            ],
            [
                new TilePosition(1, 3),
                new TilePosition(2, 3),
                new TilePosition(3, 3),
            ],
            [
                new TilePosition(1, 1),
                new TilePosition(2, 2),
                new TilePosition(3, 3),
            ],
            [
                new TilePosition(1, 3),
                new TilePosition(2, 2),
                new TilePosition(3, 1),
            ]
        ];
    }


    /**
     * @param string $id
     * @param Tile[][] $tiles
     * @return Board
     */
    public static function fromData(string $id, array $tiles): Board
    {
        $board = new Board();
        $board->id = UuidV4::fromString($id);
        $board->tiles =$tiles;
        return $board;
    }

    public static function emptyBoard(): Board
    {
        $board = new Board();
        $board->tiles = [];
        for ($row = 1; $row <= 3; $row++) {
            for ($col = 1; $col <= 3; $col++) {
                $board->tiles[$row][$col] = new Tile();
            }
        }
        return $board;
    }

    private function isPositionOutOfRange(TilePosition $position): bool
    {
        return
            $position->getRow() < 1 ||
            $position->getRow() > 3 ||
            $position->getCol() < 1 ||
            $position->getCol() > 3;
    }


    public function getTile(TilePosition $position): Tile
    {
        if ($this->isPositionOutOfRange($position)) throw new Exception("Position not exists");
        return $this->tiles[$position->getRow()][$position->getCol()];
    }

    /**
     * @return Tile[][]
     */
    public function getTiles(): array
    {
        return $this->tiles;
    }

    public function clearBoard()
    {
        foreach ($this->tiles as $tileRow) {
            foreach ($tileRow as $tile) {
                $tile->clean();
            }
        }
    }

    public function markTile(TilePosition $position, Mark $mark)
    {
        if ($this->isPositionOutOfRange($position)) throw new Exception("Position not exists");
        $this->tiles[$position->getRow()][$position->getCol()]->mark($mark);
    }

    public function isClean(): bool
    {
        $res = true;
        foreach ($this->tiles as $tileRow) {
            foreach ($tileRow as $tile) {
                $res = $res && $tile->isClean();
            }
        }
        return $res;
    }

    public function checkThreeInARaw(): ThreeInARowResult
    {
        foreach ($this->winnerPositions as $position) {
            $res = $this->checkARow($position);
            if ($res->result()) return $res;
        }

        return ThreeInARowResult::noThreeInARowResult();
    }

    /**
     * @param TilePosition[] $positions
     */
    private function checkARow(array $positions): ThreeInARowResult
    {
        $pos1 = $positions[0];
        $pos2 = $positions[1];
        $pos3 = $positions[2];

        $tile1 = $this->tiles[$pos1->getRow()][$pos1->getCol()];
        $tile2 = $this->tiles[$pos2->getRow()][$pos2->getCol()];
        $tile3 = $this->tiles[$pos3->getRow()][$pos3->getCol()];

        if (!$tile1->isClean()
            && $tile1->markedAs($tile2)
            && $tile1->markedAs($tile3)) {

            return ThreeInARowResult::threeInARow($positions, $tile1->getMark());
        }
        return ThreeInARowResult::noThreeInARowResult();
    }
}