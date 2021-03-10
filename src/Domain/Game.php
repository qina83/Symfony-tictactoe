<?php


namespace App\Domain;


use Exception;
use Webmozart\Assert\Assert;

class Game
{
    private Board $board;
    private ?Player $player1;
    private ?Player $player2;
    private ?Player $nextPlayer;
    private ?Player $winner;


    /**
     * Game constructor.
     */
    public function __construct()
    {
        $this->resetGame();
    }


    /**
     * @return Player|null
     */
    public function getWinner(): ?Player
    {
        return $this->winner;
    }

    /**
     * @return Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * @return Player|null
     */
    public function getPlayer1(): ?Player
    {
        return $this->player1;
    }

    /**
     * @return Player|null
     */
    public function getPlayer2(): ?Player
    {
        return $this->player2;
    }

    public function addPlayer(string $nickName)
    {
        if (!$this->player1) {
            $this->player1 = Player::createOPlayer($nickName, $this->board);
        } else if (!$this->player2) {
            $this->player2 = Player::createXPlayer($nickName, $this->board);
        } else throw new Exception("Maximum number of player reached");
    }

    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return [$this->player1, $this->player2];
    }

    private function checkWinnerAndChangeTurn()
    {
        $threeInARowResult = $this->board->checkThreeInARaw();

        if ($threeInARowResult->result()) {
            if ($threeInARowResult->isO()) {
                $this->winner = $this->player1;
            } else
                $this->winner = $this->player2;
        }

        if (!$this->nextPlayer || $this->nextPlayer === $this->player2)
            $this->nextPlayer = $this->player1;
        else
            $this->nextPlayer = $this->player2;
    }

    public function player1Mark(TilePosition $position)
    {
        Assert::true($this->isPlayer1Turn());
        Assert::false($this->isGameOver());

        $this->player1->mark($position);
        $this->checkWinnerAndChangeTurn();
    }

    public function player2Mark(TilePosition $position)
    {
        Assert::true($this->isPlayer2Turn());
        Assert::false($this->isGameOver());
        $this->player1->mark($position);
        $this->checkWinnerAndChangeTurn();
    }

    public function isPlayer1Turn()
    {
        return $this->player1 === $this->nextPlayer;
    }

    public function isPlayer2Turn()
    {
        return $this->player2 === $this->nextPlayer;
    }

    public function isGameOver()
    {
        return $this->winner != null;
    }

    public function startGame()
    {
        Assert::notNull($this->player1);
        Assert::notNull($this->player2);

        $this->board->clearBoard();
        $this->checkWinnerAndChangeTurn();
    }

    public function resetGame(){
        $this->board = new Board();
        $this->player1 = null;
        $this->player2 = null;
        $this->nextPlayer = null;
        $this->winner = null;
    }

}