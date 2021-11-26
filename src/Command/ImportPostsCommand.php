<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportPostsCommand extends Command
{
    protected static $defaultName = 'app:import-posts';
    protected static $defaultDescription = 'Import or update Post and Tags';
    private String $appDir;

    public function __construct($appDir)
    {
        $this->appDir = $appDir;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument(
                'filePath',
                InputArgument::REQUIRED,
                'File path relative to application directory'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->success($this->appDir);

        return Command::SUCCESS;
    }
}
