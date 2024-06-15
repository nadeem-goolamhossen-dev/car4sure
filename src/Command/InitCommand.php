<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'InitCommand',
    description: 'Add a short description for your command',
    aliases: ['app:init'],
    hidden: false
)]
class InitCommand extends Command
{
    /**
     * Tables
     */
    const TABLES = ['user'];

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Configurations
     *
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Initialise app')
            ->setHelp('This command initialises the app')
        ;
    }

    /**
     * Execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Start initialising app');

        $io->text('- Recreating database');
        shell_exec('php bin/console d:d:d --force');
        shell_exec('php bin/console d:d:c');

        $io->text('- Executing migrations');
        shell_exec('php bin/console d:m:m -n');

        $io->text('- Loading fixtures');
        shell_exec('php bin/console d:f:l -n');

        $io->success('App has been initialised successfully.');

        return Command::SUCCESS;
    }
}
