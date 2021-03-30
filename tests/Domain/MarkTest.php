<?php

namespace App\Tests\Domain;


use App\Game\Domain\Mark;
use PHPUnit\Framework\TestCase;

class MarkTest extends TestCase
{
    public function test_markCreateAsX_mustBeX()
    {
        $mark = Mark::createAsXMark();

        self::assertTrue($mark->isX());
        self::assertFalse($mark->isO());
    }

    public function test_markCreateAsO_mustBeO()
    {
        $mark = Mark::createAsOMark();

        self::assertFalse($mark->isX());
        self::assertTrue($mark->isO());
    }

    public function test_markAreEqual()
    {
        $mark1 = Mark::createAsOMark();
        $mark2 = Mark::createAsOMark();

        self::assertTrue($mark1->equalTo($mark2));
    }

    public function test_markAreNotEqual()
    {
        $mark1 = Mark::createAsOMark();
        $mark2 = Mark::createAsXMark();

        self::assertFalse($mark1->equalTo($mark2));
    }


}