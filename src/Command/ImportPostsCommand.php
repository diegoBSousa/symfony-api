<?php

namespace App\Command;

use App\Entity\Post;
use App\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
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

        /** @var PostItemRepository $postItemRepository */
        $postItemRepository = $this->entityManager->getRepository(Post::class);

        foreach (array_keys($rows) as $index) {

            /** @var Post $postItem */
            $postItem = $postItemRepository->findOneBy([
                'title' => $rows[$index]['TITLE']
            ]);

            if ($postItem) {
                $postItem->setContent($rows[$index]['CONTENT']);
                $postItem->setImage($rows[$index]['IMAGE']);

                $this->handleTags($postItem, $rows[$index]['TAGS']);

                $this->entityManager->persist($postItem);
                $this->entityManager->flush();
                continue;
            }

            $newPostItem = new Post();

            $newPostItem->setTitle($rows[$index]['TITLE']);
            $newPostItem->setContent($rows[$index]['CONTENT']);
            $newPostItem->setImage($rows[$index]['IMAGE']);
            $this->handleTags($newPostItem, $rows[$index]['TAGS']);

            $this->entityManager->persist($newPostItem);
            $this->entityManager->flush();
        }

        return Command::SUCCESS;
    }

    private function handleTags(Post &$postEntity, $tagText)
    {
        $oldTags = $postEntity->getTags();

        foreach ($oldTags as $oldTag) {
            $postEntity->removeTag($oldTag);
        }

        $newTags = $this->getTagEntities($tagText);

        foreach ($newTags as $newTag) {
            $postEntity->addTag($newTag);
        }
    }

    private function getTagEntities(String $tagText): Collection
    {
        $textTagArray = array_map(
            function ($tag) {
                return trim($tag);
            },
            explode(';', $tagText)
        );

        $textTagArray = array_filter($textTagArray);

        $tags = new ArrayCollection();

        /** @var TagItemRepository $tagItemRepository */
        $tagItemRepository = $this->entityManager->getRepository(Tag::class);

        foreach ($textTagArray as $textTag) {
            if ($tag = $tagItemRepository->findOneBy(['tag' => $textTag])) {
                $tags[] = $tag;
                continue;
            }

            $tag = new Tag();
            $tag->setTag($textTag);

            $this->entityManager->persist($tag);
            $this->entityManager->flush();

            $tags[] = $tag;
        }


        return $tags;
    }

    private function parseCsv($fileName): array
    {
        $inputFile = "{$this->appDir}/{$fileName}";

        $parser = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

        $rows = $parser->decode(file_get_contents($inputFile), 'csv');

        return $rows;
    }
}
