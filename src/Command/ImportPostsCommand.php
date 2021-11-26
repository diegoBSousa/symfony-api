<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Cast\Array_;
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

    /** @var String */
    private String $appDir;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct($appDir, EntityManagerInterface $entityManager)
    {
        $this->appDir = $appDir;
        $this->entityManager = $entityManager;

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
        $fileName = $input->getArgument('filePath');

        $rows = $this->parseCsv($fileName);

        foreach (array_keys($rows) as $index) {
            //
        }

        return Command::SUCCESS;
    }

    private function parseCsv($fileName): array
    {
        $inputFile = "{$this->appDir}/{$fileName}";

        $parser = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

        $rows = $parser->decode(file_get_contents($inputFile), 'csv');

        return $rows;
    }
}