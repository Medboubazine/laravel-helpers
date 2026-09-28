<?php

namespace Medboubazine\LaravelHelpers\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string exchange(string $from, string $to, mixed $amount, int $decimals = 2)
 * @method static \Illuminate\Database\Eloquent\Collection getAllRatesFromDatabase()
 * @method static \Illuminate\Support\Collection getAllRates()
 * @method static void createDatabaseRecords()
 * @method static void createDatabaseRecord(string $target_currency)
 * @method static bool updateDatabaseRecord(string $from_currency, string $to_currency, string $rate)
 * @method static bool deleteDatabaseRecord(string $from_currency, string $to_currency)
 * @method static bool truncateDatabaseRecords()
 * @method static bool clearCache()
 * 
 * @see Medboubazine\LaravelHelpers\Services\ExchangeRateService
 */
class ExchangeRateFacade extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'medboubazine-exchange-rate-service';
    }
}
