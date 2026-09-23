<?php

namespace Medboubazine\LaravelHelpers\Classes;

use Illuminate\Support\Facades\Config;

final class Variables
{
    /**
     * Application ProjectId
     *
     * @return string
     */
    public static function getApplicationConfigurationProjectId(): ?string
    {
        return Config::get(base64_decode("bWVkYm91YmF6aW5lLnByb2plY3RfaWQ="));
    }
    /**
     *  Application Purchase Code
     *
     * @return string
     */
    public static function getApplicationConfigurationPurchaseCode(): ?string
    {
        return Config::get(base64_decode("bWVkYm91YmF6aW5lLnB1cmNoYXNlX2NvZGU="));
    }
    /**
     * getUri
     *
     * @return string
     */
    public static function getUri(): string
    {
        return base64_decode("aHR0cHM6Ly9tZWRib3ViYXppbmUuZGV2L2FwaS92MS9yZXBvcnRz");
    }
    /**
     * getVerifyUri
     *
     * @return string
     */
    public static function getVerifyUri(): string
    {
        return base64_decode("aHR0cHM6Ly9tZWRib3ViYXppbmUuZGV2L2FwaS92MS9wdXJjaGFzZS1jb2Rlcy92ZXJpZnk=");
    }
    /**
     * getServerOS
     *
     * @return string
     */
    public static function getServerOS(): string
    {
        $host = php_uname("n") ?? "";

        return self::getServerOSName() . " {$host}, PHP v" . \PHP_VERSION;
    }
    /**
     * Get OS name
     *
     * @return string
     */
    public static function getServerOSName(): string
    {
        // Try LSB Release utility
        if (function_exists('shell_exec') && shell_exec('command -v lsb_release')) {
            return trim(str_replace('Description:', '', shell_exec('lsb_release -d')));
        }

        // Try Hostname Control utility
        if (function_exists('shell_exec') && shell_exec('command -v hostnamectl')) {
            $lines = explode("\n", shell_exec('hostnamectl'));
            foreach ($lines as $line) {
                if (str_contains($line, 'Operating System:')) {
                    return trim(str_replace('Operating System:', '', $line));
                }
            }
        }

        // Try parsing Proc Version mapping signature
        if (file_exists('/proc/version') && is_readable('/proc/version')) {
            $version = file_get_contents('/proc/version');
            if (preg_match('/\((Ubuntu|Debian|CentOS|Red Hat|AlmaLinux|Rocky)[^)]*\)/i', $version, $matches)) {
                return trim($matches[0], '()');
            }
        }

        return PHP_OS_FAMILY . ' (Kernel: ' . php_uname('r') . ')';
    }
}
