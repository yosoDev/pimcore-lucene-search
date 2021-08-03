<?php

namespace LuceneSearchBundle\Twig\Extension;

use LuceneSearchBundle\Tool\CrawlerState;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CrawlerExtension extends AbstractExtension
{
    /**
     * @var CrawlerState
     */
    protected $crawlerState;

    public function __construct(CrawlerState $crawlerState)
    {
        $this->crawlerState = $crawlerState;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('lucene_search_crawler_active', [$this, 'checkCrawlerState'])
        ];
    }

    public function checkCrawlerState()
    {
        return $this->crawlerState->isLuceneSearchCrawler();
    }
}
