<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        $inputFile = $this->appDir . '/posts-and-tags.csv';

        $parser = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

        $rows = $parser->decode(file_get_contents($inputFile), 'csv');

        dd($rows);

        return Command::SUCCESS;
    }
}
