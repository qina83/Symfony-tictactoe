<?php


namespace App\Domain;


class ThreeInARowResult
{
    private bool $result;
    private int $mark;

    /** @var TilePosition[]  */
    private array $positions;

    /**
     * @return TilePosition[]
     */
    public function getPositions(): array
    {
        return $this->positions;
    }

    private function __construct(bool $result, int $state, array $positions)
    {
        $this->result = $result;
        $this->mark = $state;
        $this->positions = $positions;
    }


    /**
     * @param TilePosition[] $positions
     * @return ThreeInARowResult
     */
    public static function noThreeInARowResult()
    {
        return new ThreeInARowResult(false, 0, []);
    }

    /**
     * @param TilePosition[] $positions
     * @return ThreeInARowResult
     */
    public static function threeOInARowResult(array $positions)
    {
        return new ThreeInARowResult(true, 1, $positions);
    }

      public static function threeXInARowResult(array $positions)
    {
        return new ThreeInARowResult(true, 2, $positions);
    }

    /**
     * @return bool
     */
    public function result(): bool
    {
        return $this->result;
    }

    public function isO(): bool
    {
        return $this->mark == 1;
    }

    public function isX(): bool
    {
        return $this->mark == 2;
    }


}