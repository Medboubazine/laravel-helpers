<?php

namespace Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Abstracts;

use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Elements\SitemapGeneratorElement;
use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Exceptions\SitemapGeneratorException;
use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Interfaces\SitemapGeneratorInterface;
use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Interfaces\SitemapTypeInterface;
use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Types\RootSitemapGenerator;
use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Types\SubSitemapGenerator;
use Illuminate\Support\Facades\File;

abstract class SitemapGeneratorAbstract
{
    /**
     * Create Sitemap
     *
     * @param SitemapGeneratorElement $element
     * @return boolean
     */
    public function create_sub(SitemapGeneratorElement $element): bool
    {
        $class = new SubSitemapGenerator($element);

        /**
         * @var SitemapTypeInterface
         */
        $generator = new $class;
        //
        if ($generator instanceof SitemapTypeInterface) {
            /**
             * @var \Spatie\Sitemap\Sitemap
             */
            $generated =  $generator->generate($element);
            $content =   $generated->render();
            //
            $file_name = $element->getFileName();
            $full_path = "{$element->getPath()}/{$file_name}";

            return $this->writeFile($full_path, $content);
        } else {
            SitemapGeneratorException::message("Sitemap Generator: {$class} must be instance of " . SitemapGeneratorInterface::class);
        }

        return false;
    }
    /**
     * Create file
     *
     * @param SitemapGeneratorElement $element
     * @return boolean
     */
    public function create_root(SitemapGeneratorElement $element): bool
    {
        $class = new RootSitemapGenerator($element);

        /**
         * @var SitemapTypeInterface
         */
        $generator = new $class;
        //
        if ($generator instanceof SitemapTypeInterface) {
            /**
             * @var \Spatie\Sitemap\Sitemap
             */
            $generated =  $generator->generate($element);
            $content =   $generated->render();
            //
            $file_name = $element->getFileName();
            $full_path = "{$element->getPath()}/{$file_name}";

            return $this->writeFile($full_path, $content);
        } else {
            SitemapGeneratorException::message("Sitemap Generator: {$class} must be instance of " . SitemapGeneratorInterface::class);
        }

        return false;
    }
    /**
     * Create file
     *
     * @param string $path
     * @param string $content
     * @return boolean
     */
    public function writeFile(string $path, string $content): bool
    {
        $directory = dirname($path);

        if (File::isWritable($directory)) {
            $deleted = true;
            if (File::exists($path)) {
                $deleted = File::delete($path);
            }
            if ($deleted) {
                return boolval(File::put($path, $content));
            } else {
                SitemapGeneratorException::message("SitemapGenerator: Cannot delete the old file {$path}");
            }
        } else {
            SitemapGeneratorException::message("SitemapGenerator: Cannot write to path ($path)");
        }
        return false;
    }
}
