<?php

namespace App\Tests\Domain;

use App\Game\Domain\Board;
use App\Game\Domain\Mark;
use App\Game\Domain\ThreeInARowResult;
use App\Game\Domain\TilePosition;
use Exception;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    private Board $board;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->board = Board::emptyBoard();
    }

    public function ThreeNonInARowDataProvider(): array
    {
        return [
            [[new TilePosition(1, 1), new TilePosition(2, 1), new TilePosition(1, 3)]],
            [[new TilePosition(2, 1), new TilePosition(1, 2), new TilePosition(2, 3)]],
            [[new TilePosition(3, 3), new TilePosition(3, 2), new TilePosition(1, 3)]]
        ];
    }

    public function ThreeInARowDataProvider(): array
    {
        return [
            [[new TilePosition(1, 1), new TilePosition(1, 2), new TilePosition(1, 3)]],
            [[new TilePosition(2, 1), new TilePosition(2, 2), new TilePosition(2, 3)]],
            [[new TilePosition(3, 1), new TilePosition(3, 2), new TilePosition(3, 3)]],
            [[new TilePosition(1, 1), new TilePosition(2, 1), new TilePosition(3, 1)]],
            [[new TilePosition(1, 2), new TilePosition(2, 2), new TilePosition(3, 2)]],
            [[new TilePosition(1, 3), new TilePosition(2, 3), new TilePosition(3, 3)]],
            [[new TilePosition(1, 1), new TilePosition(2, 2), new TilePosition(3, 3)]],
            [[new TilePosition(3, 1), new TilePosition(2, 2), new TilePosition(1, 3)]]
        ];
    }

    /**
     * @return TilePosition[]
     *
     */
    public function inRangePositionDataProvider(): array
    {
        return [
            [new TilePosition(1, 1)],
            [new TilePosition(1, 2)],
            [new TilePosition(1, 3)],
            [new TilePosition(2, 1)],
            [new TilePosition(2, 2)],
            [new TilePosition(2, 3)],
            [new TilePosition(3, 1)],
            [new TilePosition(3, 2)],
            [new TilePosition(3, 3)]
        ];
    }

    public function outOfRangePositionDataProvider(): array
    {
        return [
            [new TilePosition(0, -1)],
            [new TilePosition(0, 0)],
            [new TilePosition(0, 1)],
            [new TilePosition(0, 2)],
            [new TilePosition(0, 3)],
            [new TilePosition(0, 4)],
            [new TilePosition(0, 5)],
            [new TilePosition(-1, 0)],
            [new TilePosition(0, 0)],
            [new TilePosition(1, 0)],
            [new TilePosition(2, 0)],
            [new TilePosition(3, 0)],
            [new TilePosition(4, 0)],
            [new TilePosition(5, 0)]
        ];
    }

    /**
     * @dataProvider inRangePositionDataProvider
     */
    public function test_setTileAsX_mustTileBeMarkedAsX(TilePosition $position)
    {
        $mark = Mark::createAsXMark();
        $this->board->markTile($position, $mark);

        self::assertTrue($this->board->getTile($position)->getMark()->isX());
    }

    /**
     * @dataProvider inRangePositionDataProvider
     */
    public function test_setTileAsO_mustTileBeMarkedAsO(TilePosition $position)
    {
        $mark = Mark::createAsOMark();
        $this->board->markTile($position, $mark);

        self::assertTrue($this->board->getTile($position)->getMark()->isO());
    }


    /**
     * @dataProvider outOfRangePositionDataProvider
     */
    public function test_markTile_PositionNotValid_mustThrowException(TilePosition $position)
    {
        $mark = Mark::createAsOMark();
        self::expectException(Exception::class);

        $this->board->markTile($position, $mark);
    }


    /**
     * @dataProvider ThreeInARowDataProvider
     * @param TilePosition[] $threeTilePosition
     */
    public function test_ThreeInARow(array $threeTilePosition)
    {
        foreach ($threeTilePosition as $item) {
            $mark = Mark::createAsOMark();
            $this->board->markTile($item, $mark);
        }

        $res = $this->board->checkThreeInARaw();

        self::assertTrue($res->result());
    }


    /**
     * @dataProvider ThreeNonInARowDataProvider
     * @param TilePosition[] $threeTilePosition
     */
    public function test_ThreeNoInARow(array $threeTilePosition)
    {
        foreach ($threeTilePosition as $item) {
            $mark = Mark::createAsOMark();
            $this->board->markTile($item, $mark);
        }

        $res = $this->board->checkThreeInARaw();

        self::assertFalse($res->result());
    }

    public function test_isClear_trueScenario()
    {
        self::assertTrue($this->board->isClean());
    }

    public function test_isClear_falseScenario()
    {
        $mark = Mark::createAsOMark();
        $this->board->markTile(new TilePosition(1,1), $mark);
        self::assertFalse($this->board->isClean());
    }

    public function test_cleanBoard()
    {
        $mark = Mark::createAsOMark();
        $this->board->markTile(new TilePosition(1,1), $mark);
        $this->board->clearBoard();

        self::assertTrue($this->board->isClean());
    }

}


