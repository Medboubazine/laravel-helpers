<?php

use Medboubazine\LaravelHelpers\Models\ExchangeRate;

return [
    /**
     * -----------------------------
     *  Project identifier      ----
     * -----------------------------
     * Please Don't change this
     */
    "project_id" => null,
    /**
     * --------------------------------
     *  Project purchase code      ----
     * --------------------------------
     * You need to purchase one from us medboubazine.dev
     */
    "purchase_code" => env("APP_PURCHASE_KEY"),
    /**
     * ---------------------------------
     *  Plugins configurations      ----
     * ---------------------------------
     * Enabled plugins used to project
     */
    "plugins" => [
        /**
         * ---------------------------------
         *  Exchange rate plugin        ----
         * ---------------------------------
         * exchange rates configurations
         */
        "exchange-rates" => [
            // --------------------
            // Plugin status    ---
            // --------------------
            "enabled" => false,
            // --------------------
            // Model class      ---
            // --------------------
            "model" => ExchangeRate::class,
            // --------------------
            // Cache key        ---
            // --------------------
            "cache_key" => "medboubazine-exchange-rate-service-all-rates",
        ],
    ],
];
