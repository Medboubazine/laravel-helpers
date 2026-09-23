<?php

namespace Medboubazine\LaravelHelpers\Classes\Configuration;

use Illuminate\Support\Facades\Config;
use Medboubazine\LaravelHelpers\Classes\Variables;

final class ConfigurationCheck
{
    /**
     * Check purchase code
     *
     * @return boolean
     */
    public static function purchase_code(): bool
    {
        $purchase_code = Variables::getApplicationConfigurationPurchaseCode();
        //
        if ($purchase_code && strlen($purchase_code) == 32) {
            return true;
        }
        return false;
    }
    /**
     * Check prorject id
     *
     * @return boolean
     */
    public static function project_id(): bool
    {
        $project_id = Variables::getApplicationConfigurationProjectId();
        //
        if ($project_id) {
            return true;
        }
        return false;
    }
}
