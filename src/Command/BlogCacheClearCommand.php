<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BlogCacheClearCommand extends Command
{
    protected static $defaultName = 'blog:cache:clear';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $commands = [
            ['cache:clear', ['--quiet' => true]],
            ['doctrine:cache:clear-result', ['--quiet' => true]],
            ['doctrine:cache:clear-metadata', ['--quiet' => true]],
            ['doctrine:cache:clear-query', ['--quiet' => true]],
        ];
        foreach ($commands as [$command, $arguments]) {
            $io->writeln("Executing <info>{$command}</info>");
            $exitCode = $this->getApplication()->find($command)->run(
                new ArrayInput($arguments),
                $output
            );
            if (Command::SUCCESS !== $exitCode) {
                break;
            }
        }

        return Command::SUCCESS;
    }
}
