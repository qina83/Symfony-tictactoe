<?php


namespace App\Domain;


use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class Game
{
    private UuidInterface $id;
    private Board $board;

    /** @var Player[] */
    private array $players;
    private ?UuidInterface $nextPlayerId;
    private ?Player $winner;

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }


    /**
     * Game constructor.
     */
    public function __construct()
    {
        $this->resetGame();
        $this->id = Uuid::uuid4();
    }

    /**
     * @param Player[] $players
     */
    public static function fromData(UuidInterface $id, ?UuidInterface $nextPlayerId, array $players, Board $board): Game
    {
        $game = new Game();
        $game->id = $id;
        $game->nextPlayerId = $nextPlayerId;
        $game->players = $players;
        $game->board = $board;
        return $game;
    }

    /**
     * @return Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    public function addPlayer(Player $player)
    {
        if (count($this->players) === 2) throw new Exception("Maximum number of player reached");
        if (count($this->players) === 0) {
            $this->players[] = $player;
        }
        else
        {
            if ($this->players[0]->sameMarkOf($player)) throw new Exception("Player with this mark already exists");
            else
                $this->players[] = $player;
        }
    }


    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    private function checkWinnerAndChangeTurn()
    {
        $threeInARowResult = $this->board->checkThreeInARaw();

        if ($threeInARowResult->result()) {
            $winnerMark = $threeInARowResult->getMark();
            if ($winnerMark->equalTo($this->players[0]->getMark())) {
                $this->winner = $this->players[0];
            } else
                $this->winner = $this->players[1];
        }

        if (!$this->nextPlayerId || $this->nextPlayerId->equals($this->players[1]->getId()))
            $this->nextPlayerId = $this->players[0]->getId();
        else
            $this->nextPlayerId = $this->players[1]->getId();
    }

    public function playerMarks(Player $player, TilePosition $position)
    {
        Assert::eq($this->nextPlayerId, $player->getId());
        Assert::false($this->isGameOver());

        $this->board->getTile($position)->mark($player->getMark());

        $this->checkWinnerAndChangeTurn();
    }

    public function playerMarksByNickName(string $nickname, TilePosition $position)
    {
        foreach ($this->players as $player) {
            if ($player->getNickName() === $nickname)
                $this->playerMarks($player, $position);
        }
    }


    public function isGameOver()
    {
        return $this->winner != null;
    }

    public function startGame()
    {
        Assert::count($this->players, 2);
        $this->checkWinnerAndChangeTurn();
    }

    /**
     * @return UuidInterface|null
     */
    public function getNextPlayerId(): ?UuidInterface
    {
        return $this->nextPlayerId;
    }

    /**
     * @return UuidInterface|null
     */
    public function getWinner(): ?Player
    {
        return $this->winner;
    }

    public function resetGame()
    {
        $this->board = Board::emptyBoard();
        $this->players = [];
        $this->nextPlayerId = null;
        $this->winner = null;
    }

}