<?php


namespace App\Infrastructure\CLI;

use App\Domain\AddPlayerCommand;
use App\Domain\CreateGameCommand;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class AddPlayerToGameCLICommand extends Command
{
    protected static $defaultName = 'app:add-player';
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
            ->setDescription('Add player to game')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to add a player to an existing game. Needs gameid and player nickname')

            // configure an argument
            ->addArgument('gameId', InputArgument::REQUIRED, 'The id of game.')
            ->addArgument('nickname', InputArgument::REQUIRED, 'The nickname of player.')
            // ...
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cmd = new AddPlayerCommand(UuidV4::fromString($input->getArgument('gameId')), $input->getArgument('nickname'));
        $envelope = $this->bus->dispatch($cmd);
        $handledStamp = $envelope->last(HandledStamp::class);
        $output->writeln("Player added");
        return Command::SUCCESS;
    }
}