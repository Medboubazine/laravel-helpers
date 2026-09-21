<?php

namespace Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Abstracts;

use Carbon\Carbon;
use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Enums\SitemapGeneratorChangeFrequencyEnum;
use Spatie\Sitemap\Tags\Url;

abstract class SitemapTypeAbstract
{
    /**
     * create URL tag
     *
     * @param string $url
     * @param Carbon $updated_at
     * @param SitemapGeneratorChangeFrequencyEnum $change
     * @param float $priority
     * @return Url
     */
    public function createUrlTag(string $url, Carbon $updated_at, SitemapGeneratorChangeFrequencyEnum $change, $priority = 0.1): Url
    {
        return Url::create($url)
            ->setLastModificationDate($updated_at)
            ->setChangeFrequency($change->value)
            ->setPriority($priority);
    }
}
