<?php

namespace LuceneSearchBundle\Twig\Extension;

use LuceneSearchBundle\Configuration\Configuration;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CategoriesExtension extends AbstractExtension
{
    /**
     * @var Configuration
     */
    var $configuration;

    /**
     * CategoriesExtension constructor.
     *
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('lucene_search_get_categories', [$this, 'getCategoriesList'])
        ];
    }

    /**
     * @param null $options
     *
     * @return array
     */
    public function getCategoriesList($options = null)
    {
        $categories = $this->configuration->getCategories();
        return $categories;
    }
}
