<?php

namespace LuceneSearchBundle\Task\Crawler\Listener;

use LuceneSearchBundle\Configuration\Configuration;
use LuceneSearchBundle\LuceneSearchEvents;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\GenericEvent;

class Abort
{
    /**
     * @var null
     */
    var $spider = null;

    /**
     * Abort constructor.
     *
     * @param $spider
     */
    public function __construct($spider)
    {
        $this->spider = $spider;
    }

    /**
     * @param Event $event
     */
    public function checkCrawlerState(GenericEvent $event)
    {
        if (!file_exists(Configuration::CRAWLER_PROCESS_FILE_PATH)) {
            $this->spider->getDispatcher()->dispatch(LuceneSearchEvents::LUCENE_SEARCH_CRAWLER_INTERRUPTED,
                new GenericEvent($this, [
                    'uri'          => $event->getArgument('uri'),
                    'errorMessage' => 'crawling aborted by user (tmp file while crawling has suddenly gone.)'
                ]));
        }
    }

    /**
     * @param Event $event
     */
    public function stopCrawler(GenericEvent $event)
    {
        exit;
    }
}
