<?php


namespace App\Infrastructure\CLI;

use App\Domain\CreateGameCommand;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class CreateGameCLICommand extends Command
{
    protected static $defaultName = 'app:create-game';
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
            ->setDescription('Creates a new game')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a new game. Game code will be returned');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cmd = new CreateGameCommand();
        $envelope = $this->bus->dispatch($cmd);
        $handledStamp = $envelope->last(HandledStamp::class);
        $output->writeln("New game created: " . $handledStamp->getResult());
        return Command::SUCCESS;
    }
}