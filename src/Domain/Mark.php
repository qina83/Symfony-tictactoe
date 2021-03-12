<?php


namespace App\Domain;


class Mark
{
    private int $state;

    /**
     * Mark constructor.
     * @param int $state
     */
    private function __construct(int $state)
    {
        $this->state = $state;
    }

    public function isO(): bool
    {
        return $this->state === 1;
    }

    public function isX(): bool
    {
        return $this->state === 2;
    }

    public function equalTo(Mark $mark)
    {
        return $this->state === $mark->state;
    }

    public static function createAsOMark():Mark
    {
        return new Mark(1);
    }

    public static function createAsXMark():Mark
    {
        return new Mark(2);
    }
}


