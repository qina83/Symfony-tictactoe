<?php


namespace App\Game\Infrastructure\CLI;

use App\Game\Domain\AddPlayerCommand;
use App\Game\Domain\CreateGameCommand;
use App\Game\Domain\Mark;
use App\Game\Domain\PlayerMarkCommand;
use App\Game\Domain\TilePosition;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Webmozart\Assert\Assert;

class PlayerMarksCLICommand extends Command
{
    protected static $defaultName = 'app:player-marks';
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        parent::__construct();

        $this->bus = $bus;
    }

    protected function configure()
    {
        parent::configure();
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Player marks')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to make your move')

            // configure an argument
            ->addArgument('gameId', InputArgument::REQUIRED, 'The id of game.')
            ->addArgument('nickname', InputArgument::REQUIRED, 'The nickname of player.')
            ->addArgument('row', InputArgument::REQUIRED, '1,2 or 3')
            ->addArgument('col', InputArgument::REQUIRED, '1,2 or 3')// ...
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $row = intval($input->getArgument('row'));
        $col = intval($input->getArgument('col'));
        $gameId = $input->getArgument('gameId');
        $uuid = UuidV4::fromString($gameId);

        $cmd = new PlayerMarkCommand(
            UuidV4::fromString($gameId),
            $input->getArgument('nickname'),
            new TilePosition($row, $col)
        );
        $envelope = $this->bus->dispatch($cmd);
        $handledStamp = $envelope->last(HandledStamp::class);
        $game = $handledStamp->getResult();
        if ($game->getWinner())
            $output->writeln("winner is {$game->getWinner()->getNickName()}");
        else
            $output->writeln("no winner yet");
        return Command::SUCCESS;
    }
}