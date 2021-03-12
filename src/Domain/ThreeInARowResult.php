<?php


namespace App\Domain;


class ThreeInARowResult
{
    private bool $result;
    private ?Mark $mark;

    /** @var TilePosition[] */
    private array $positions;

    /**
     * @return TilePosition[]
     */
    public function getPositions(): array
    {
        return $this->positions;
    }

    private function __construct(bool $result = false, array $positions = [], ?Mark $mark = null)
    {
        $this->result = $result;
        $this->mark = $mark;
        $this->positions = $positions;
    }


    /**
     * @param TilePosition[] $positions
     * @return ThreeInARowResult
     */
    public static function noThreeInARowResult()
    {
        return new ThreeInARowResult();
    }

    /**
     * @param TilePosition[] $positions
     * @return ThreeInARowResult
     */
    public static function threeInARow(array $positions, Mark $mark)
    {
        return new ThreeInARowResult(true, $positions, $mark);
    }

    /**
     * @return bool
     */
    public function result(): bool
    {
        return $this->result;
    }


    /**
     * @return Mark|null
     */
    public function getMark(): ?Mark
    {
        return $this->mark;
    }


}