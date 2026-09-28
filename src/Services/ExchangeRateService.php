<?php

namespace Medboubazine\LaravelHelpers\Services;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Medboubazine\LaravelHelpers\Classes\Number\Number;

final class ExchangeRateService
{
    /**
     * Model class
     *
     * @var string
     */
    protected string $model_class;
    /**
     * Model object
     *
     * @var Model
     */
    protected Model $model;
    /**
     * Cache store key
     *
     * @var string
     */
    protected string $cache_key;
    /**
     * Constructor
     */
    public function __construct()
    {
        $configs = Config::get("medboubazine.plugins.exchange-rates");

        if (!isset($configs['model']) && !is_subclass_of($configs['model'], Model::class)) {
            throw new \Exception('ExchangeRateService: Configuration medboubazine.plugins.exchange-rates.model must be present and must be instance of ' . Model::class);
        }

        $this->model_class = $configs['model'];
        $this->model = new $this->model_class;

        $this->cache_key = $configs['cache_key'];
    }
    /**
     * Exchange currency 
     *
     * @param string $from
     * @param string $to
     * @param numeric $amount
     * @param integer $decimals
     * @return string
     */
    public function exchange(string $from, string $to, $amount, $decimals = 2): string
    {
        if ($from === $to) {
            return Number::format($amount, $decimals);
        }

        $rates = $this->getAllRates();

        $rate = $rates->where('from_currency', $from)
            ->where('to_currency', $to)
            ->first();

        if (!$rate) {
            throw new Exception("Exchange rate {$from}:{$to} is not exists.");
        }

        return Number::format($amount * $rate['rate'], $decimals);
    }
    /**
     * Get all rates from database
     *
     * @return Collection
     */
    public function getAllRatesFromDatabase(): Collection
    {
        return $this->model_class::all();
    }
    /**
     * Get Cached rates
     *
     * @return SupportCollection
     */
    public function getAllRates(): SupportCollection
    {
        $ttl = Carbon::now()->addHours(24);

        $rates = Cache::remember($this->cache_key, $ttl, function () {
            return $this->getAllRatesFromDatabase()->toArray();
        });

        return new SupportCollection($rates);
    }
    /**
     * Create all rates for availlable currencies
     *
     * @return void
     */
    public function createDatabaseRecords(): void
    {
        $currencies = $this->model->currencies();

        foreach ($currencies as $currency) {

            $this->createDatabaseRecord($currency);
        }
    }
    /**
     * Create database recort for specific currency
     *
     * @param string $target_currency
     * @return void
     */
    public function createDatabaseRecord(string $target_currency): void
    {
        //clear cache first
        $this->clearCache();
        //
        $currencies = $this->model->currencies();

        foreach ($currencies as $currency) {
            if ($currency !== $target_currency) {
                //create record
                //prevent dublicate record
                if (!$this->model_class::where(["from_currency" => $target_currency, "to_currency" => $currency])->exists()) {
                    $this->model_class::create([
                        "from_amount" => "1.00",
                        "from_currency" => $target_currency,
                        "to_amount" => "1.00",
                        "to_currency" => $currency,
                    ]);
                }
                //create inverse record
                //prevent dublicate records
                if (!$this->model_class::where(["from_currency" => $currency, "to_currency" => $target_currency])->exists()) {
                    $this->model_class::create([
                        "from_amount" => "1.00",
                        "from_currency" => $currency,
                        "to_amount" => "1.00",
                        "to_currency" => $target_currency,
                    ]);
                }
            }
        }
    }
    /**
     * Update database record
     *
     * @param string $from_currency
     * @param string $to_currency
     * @param string $rate
     * @return boolean
     */
    public function updateDatabaseRecord(string $from_currency, string $to_currency, string $rate): bool
    {
        //clear cache first
        $this->clearCache();
        //
        $item = $this->model_class::where(["from_currency" => $from_currency, "to_currency" => $to_currency])->first();
        $inverse_item = $this->model_class::where(["from_currency" => $to_currency, "to_currency" => $from_currency])->first();

        if (!$item || !$inverse_item) {
            throw new Exception("Exchange rate {$from_currency}:{$to_currency} or the inverse, is not exists.");
        }
        //
        $item->from_amount = Number::format(1, 10);
        $item->to_amount = Number::format($rate, 10);

        //inverse
        $inverse_item->from_amount = Number::format(1, 10);
        $inverse_item->to_amount = Number::format(1 / $rate, 10);

        return $item->update() && $inverse_item->update();
    }
    /**
     * Delete database record
     *
     * @param string $from_currency
     * @param string $to_currency
     * @return boolean
     */
    public function deleteDatabaseRecord(string $from_currency, string $to_currency): bool
    {
        //clear cache first
        $this->clearCache();
        //
        $item = $this->model_class::where(["from_currency" => $from_currency, "to_currency" => $to_currency])->first();
        $inverse_item = $this->model_class::where(["from_currency" => $to_currency, "to_currency" => $from_currency])->first();

        if (!$item || !$inverse_item) {
            throw new Exception("Exchange rate {$from_currency}:{$to_currency} or the inverse, is not exists.");
        }

        return $item->delete() && $inverse_item->delete();
    }
    /**
     * Delete all rates records
     *
     * @return boolean
     */
    public function truncateDatabaseRecords(): bool
    {
        //clear cache first
        $this->clearCache();
        //
        return $this->model_class::truncate();
    }
    /**
     * Clear cached rates
     *
     * @return boolean
     */
    public function clearCache(): bool
    {
        return Cache::forget($this->cache_key);
    }
}
