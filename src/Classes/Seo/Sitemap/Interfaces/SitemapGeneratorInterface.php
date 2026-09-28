<?php

namespace Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Interfaces;

use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Elements\SitemapGeneratorElement;

interface SitemapGeneratorInterface
{
    public function __construct();
    public function create_sub(SitemapGeneratorElement $element);
    public function create_root(SitemapGeneratorElement $element);
    public function writeFile(string $path, string $content);
}
