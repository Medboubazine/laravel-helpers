<?php

namespace Medboubazine\LaravelHelpers\Commands\Seo;

use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\SitemapGenerator;
use Illuminate\Console\Command;

final class GenerateSitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medboubazine:seo:sitemaps {--C|class=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create sitemaps';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Check generator class
        $class_name = $this->option('class');
        //
        if ($class_name && is_string($class_name) && \class_exists($class_name) && is_subclass_of($class_name, SitemapGenerator::class)) {

            $generator = new $class_name;

            if ($generator) {
                $this->components->success("Sitemaps file is created successfully");
            } else {
                $this->components->error("Failed to create sitemaps file");
            }
        } else {
            $this->components->error("The --class option must be present and must be an instance of class " . SitemapGenerator::class);
        }
        return 0;
    }
}
