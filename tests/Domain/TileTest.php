<?php

namespace App\Tests\Domain;

use App\Domain\Mark;
use App\Domain\Tile;
use PHPUnit\Framework\TestCase;

class TileTest extends TestCase
{
    private Tile $tile;

    public function setUp(): void
    {
        parent::setUp();
        $this->tile = new Tile();
    }



    public function test_tileAlreadyMarked_markTile_mustThrowException()
    {
        $mark = Mark::createAsXMark();
        $this->tile->mark($mark);

        self::expectException(\Exception::class);
        $this->tile->mark($mark);

    }

    public function test_cleanTileAfterX_mustReturnIsCleanTrue()
    {
        $mark = Mark::createAsXMark();
        $this->tile->clean();

        self::assertTrue($this->tile->isClean());
    }

    public function test_cleanTileAfterX_getMarkMustReturnNull()
    {
        $mark = Mark::createAsXMark();
        $this->tile->mark($mark);
        $this->tile->clean();

        self::assertNull($this->tile->getMark());
    }


    public function test_sameOf()
    {
        $tile1 = new Tile();
        $mark = Mark::createAsXMark();
        $tile1->mark($mark);
        $tile2 = new Tile();
        $mark = Mark::createAsXMark();
        $tile2->mark($mark);

        self::assertTrue($tile1->markedAs($tile2));
    }

    public function test_sameOfEmpty()
    {
        $tile1 = new Tile();
        $tile2 = new Tile();

        self::assertTrue($tile1->markedAs($tile2));
    }

    public function test_tilesWithXAndO_markedAsReturnFalse()
    {
        $tile1 = new Tile();
        $mark = Mark::createAsOMark();
        $tile1->mark($mark);
        $tile2 = new Tile();
        $mark = Mark::createAsXMark();
        $tile2->mark($mark);

        self::assertFalse($tile1->markedAs($tile2));
    }

    public function test_tilesMarkedAndClean_markedAsReturnFalse()
    {
        $tile1 = new Tile();
        $mark = Mark::createAsOMark();
        $tile1->mark($mark);
        $tile2 = new Tile();

        self::assertFalse($tile1->markedAs($tile2));
    }


}
