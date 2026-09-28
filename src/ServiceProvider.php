<?php

namespace Medboubazine\LaravelHelpers;

use Carbon\Carbon;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Medboubazine\LaravelHelpers\Console\Commands\AnalyzeCommand;
use Medboubazine\LaravelHelpers\Console\Commands\Seo\GenerateRobotsDotTextCommand;
use Medboubazine\LaravelHelpers\Console\Commands\Seo\GenerateSitemapCommand;
use Medboubazine\LaravelHelpers\Http\Middleware\AuthorizedHostsMiddleware;
use Medboubazine\LaravelHelpers\Services\ExchangeRateService;

final class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (boolval(Config::get("medboubazine.plugins.exchange-rates.enabled"))) {
            //
            $this->app->singleton('medboubazine-exchange-rate-service', function ($app) {
                return new ExchangeRateService();
            });
        }

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
            //Migrations
            if (boolval(Config::get("medboubazine.plugins.exchange-rates.enabled"))) {
                //
                $time = Carbon::now()->format("Y_m_d_His");
                $this->publishes([
                    __DIR__ . '/database/migrations/create_exchange_rates_table.php' => database_path("migrations/{$time}_create_exchange_rates_table.php"),
                ], 'medboubazine-exchange-rates');
            }
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

        $kernel->pushMiddleware(AuthorizedHostsMiddleware::class);
    }
}
