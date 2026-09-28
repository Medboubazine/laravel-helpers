<?php

namespace Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Types;

use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Abstracts\SitemapTypeAbstract;
use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Interfaces\SitemapTypeInterface;
use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Elements\SitemapGeneratorElement;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Carbon\Carbon;

class SubSitemapGenerator extends SitemapTypeAbstract implements SitemapTypeInterface
{
    /**
     * Generate
     *
     * @return Sitemap|SitemapIndex
     */
    public function generate(SitemapGeneratorElement $element): Sitemap|SitemapIndex
    {
        $sitemap = Sitemap::create();

        foreach ($element->getRoutes() as $route) {
            $url = $this->createUrlTag($route, Carbon::now(), $element->getChangeFrequency());

            $sitemap->add($url);
        }

        return $sitemap;
    }
}
