<?php

namespace Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Elements;

use Medboubazine\LaravelHelpers\Classes\Abstracts\ElementsAbstract;
use Medboubazine\LaravelHelpers\Classes\Interfaces\ElementsInterface;
use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Enums\SitemapGeneratorChangeFrequencyEnum;

/**
 * @method string getPath()
 * @method string getFileName()
 * @method array getRoutes()
 * @method SitemapGeneratorChangeFrequencyEnum getChangeFrequency()
 */
class SitemapGeneratorElement extends ElementsAbstract implements ElementsInterface
{
    /**
     * Set robots.txt file parameters
     *
     * @param string $path
     * @param array $routes
     */
    public function __construct(string $file_name, string $path,  array $routes = [], ?SitemapGeneratorChangeFrequencyEnum $change_frequency = null)
    {
        $this->setFileName($file_name);
        $this->setPath($path);
        $this->setRoutes($routes);
        $this->setChangeFrequency($change_frequency ? $change_frequency : SitemapGeneratorChangeFrequencyEnum::WEEKLY);
    }
}
