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
    public static function fromData(UuidInterface $id, array $players): Game
    {
        $game = new Game();
        $game->id = $id;
        $game->players = $players;

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

        if (!$this->nextPlayerId || $this->nextPlayerId === $this->players[1]->getId())
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
        $player = array_filter($this->players,
            function (Player $pl) use ($nickname) {
                return $pl->getNickName() === $nickname;
            })[0];

        $this->playerMarks($player, $position);
    }




    public function isGameOver()
    {
        return $this->winner != null;
    }

    public function startGame()
    {
        Assert::count($this->players, 2);

        $this->board->clearBoard();
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
        $this->board = new Board();
        $this->players = [];
        $this->nextPlayerId = null;
        $this->winner = null;
    }

}