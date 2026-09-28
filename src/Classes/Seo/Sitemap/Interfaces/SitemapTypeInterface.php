<?php

namespace Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Interfaces;

use Carbon\Carbon;
use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Elements\SitemapGeneratorElement;
use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Enums\SitemapGeneratorChangeFrequencyEnum;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

interface SitemapTypeInterface
{
    public function generate(SitemapGeneratorElement $element): Sitemap|SitemapIndex;
    public function createUrlTag(string $url, Carbon $updated_at, SitemapGeneratorChangeFrequencyEnum $change, $priority = 0.1): Url;
}
