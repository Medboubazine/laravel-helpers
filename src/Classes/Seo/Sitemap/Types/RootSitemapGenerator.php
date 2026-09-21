<?php

namespace Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Types;

use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Elements\SitemapGeneratorElement;
use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Interfaces\SitemapTypeInterface;
use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Abstracts\SitemapTypeAbstract;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Sitemap as TagsSitemap;

class RootSitemapGenerator extends SitemapTypeAbstract implements SitemapTypeInterface
{
    /**
     * Generate
     *
     * @return Sitemap|SitemapIndex
     */
    public function generate(SitemapGeneratorElement $element): Sitemap|SitemapIndex
    {
        $path = $element->getPath();
        //
        $sitemap = SitemapIndex::create();

        $public_path = public_path();

        $list_of_sitemaps = File::allFiles($path);

        foreach ($list_of_sitemaps as $file) {
            //
            if ($file->getFilename() !== $element->getFileName()) {
                $uri = ltrim(Str::replace([$public_path, "\\"], ["", "/"], $file->getPathname()), "/");

                $url = URL::secure($uri);

                $sitemap->add(TagsSitemap::create($url));
            }
        }

        return $sitemap;
    }
}
