<?php

namespace Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Enums;

use Spatie\Sitemap\Tags\Url;

enum SitemapGeneratorChangeFrequencyEnum: string
{
    case DAILY = Url::CHANGE_FREQUENCY_DAILY;
    case WEEKLY = Url::CHANGE_FREQUENCY_WEEKLY;
    case MONTHLY = Url::CHANGE_FREQUENCY_MONTHLY;
    case NEVER = Url::CHANGE_FREQUENCY_NEVER;
    case ALWAYS = Url::CHANGE_FREQUENCY_ALWAYS;
}
