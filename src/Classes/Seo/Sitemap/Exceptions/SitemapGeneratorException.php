<?php

namespace Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Exceptions;

use Exception;

final class SitemapGeneratorException extends Exception
{

    /**
     * Message
     *
     * @param string $message
     * @param integer $code
     * @return void
     */
    public static function message(string $message, int $code = 1)
    {
        return throw new self($message, $code);
    }
}
