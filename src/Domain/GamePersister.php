<?php


namespace App\Domain;


interface GamePersister
{
    public function store(Game $game);
}