<?php

namespace LuceneSearchBundle\Command;

use LuceneSearchBundle\Logger\ConsoleLogger;
use LuceneSearchBundle\Task\TaskManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlCommand extends Command
{
    /**
     * @var TaskManager
     */
    protected $taskManager;

    /**
     * CrawlCommand constructor.
     *
     * @param TaskManager $taskManager
     */
    public function __construct(TaskManager $taskManager)
    {
        parent::__construct();
        $this->taskManager = $taskManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('lucenesearch:crawl')
            ->setDescription('LuceneSearch Website Crawler')
            ->addOption('force', 'f',
                InputOption::VALUE_NONE,
                'Force Crawl Start');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $consoleLogger = new ConsoleLogger();
        $consoleLogger->setConsoleOutput($output);
        $this->taskManager->setLogger($consoleLogger);

        try {
            $this->taskManager->processTaskChain(['force' => $input->getOption('force')]);
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>LuceneSearch: Error while crawling: %s.</error>', $e->getMessage()));
        }

        $output->writeln('<info>LuceneSearch: Finished crawl.</info>');

        return self::SUCCESS;
    }

}
