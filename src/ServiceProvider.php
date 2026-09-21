<?php

namespace Medboubazine\LaravelHelpers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Medboubazine\LaravelHelpers\Commands\AnalyzeCommand;
use Medboubazine\LaravelHelpers\Commands\Seo\GenerateRobotsDotTextCommand;
use Medboubazine\LaravelHelpers\Commands\Seo\GenerateSitemapCommand;

final class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    /**
     * Boot
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands(
                commands: [
                    AnalyzeCommand::class,
                    GenerateRobotsDotTextCommand::class,
                    GenerateSitemapCommand::class,
                ],
            );
        }
    }
}
