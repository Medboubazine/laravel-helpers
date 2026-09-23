<?php

namespace Medboubazine\LaravelHelpers;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Medboubazine\LaravelHelpers\Commands\AnalyzeCommand;
use Medboubazine\LaravelHelpers\Commands\Seo\GenerateRobotsDotTextCommand;
use Medboubazine\LaravelHelpers\Commands\Seo\GenerateSitemapCommand;
use Medboubazine\LaravelHelpers\Http\Middleware\AuthorizedHostsMiddleware;

final class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge configurations
        $this->mergeConfigFrom(
            __DIR__ . '/config/medboubazine.php',
            'medboubazine'
        );
    }
    /**
     * Boot
     *
     * @return void
     */
    public function boot(): void
    {
        /// =========================
        /// App running in console ==
        /// =========================
        if ($this->app->runningInConsole()) {
            //Configs
            $this->publishes([
                __DIR__ . '/config/medboubazine.php' => config_path('medboubazine.php'),
            ], 'medboubazine-config');
            //Commands
            $this->commands(
                commands: [
                    AnalyzeCommand::class,
                    GenerateRobotsDotTextCommand::class,
                    GenerateSitemapCommand::class,
                ],
            );
        }
        /// ==========================
        /// Middleware              ==
        /// ==========================
        $this->middleware();
    }
    /**
     * Middleware
     *
     * @return void
     */
    protected function middleware()
    {
        $kernel = $this->app->make(Kernel::class);
        if (method_exists($kernel, 'appendGlobalMiddleware')) {
            $kernel->appendGlobalMiddleware(AuthorizedHostsMiddleware::class);
        } else {
            $kernel->{'pushMiddleware'}(AuthorizedHostsMiddleware::class);
        }
    }
}
