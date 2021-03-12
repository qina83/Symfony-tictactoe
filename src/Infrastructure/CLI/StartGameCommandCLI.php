<?php


namespace App\Infrastructure\CLI;

use App\Domain\AddPlayerCommand;
use App\Domain\CreateGameCommand;
use App\Domain\Mark;
use App\Domain\PlayerMarkCommand;
use App\Domain\StartGameCommand;
use App\Domain\TilePosition;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Webmozart\Assert\Assert;

class StartGameCommandCLI extends Command
{
    protected static $defaultName = 'app:start-game';
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
            ->setDescription('Start game')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to start existing game')

            // configure an argument
            ->addArgument('gameId', InputArgument::REQUIRED, 'The id of game.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $cmd = new StartGameCommand(
            UuidV4::fromString($input->getArgument('gameId'))
        );

        $this->bus->dispatch($cmd);
        $output->writeln("game started");
        return Command::SUCCESS;
    }
}