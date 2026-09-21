<?php

namespace Medboubazine\LaravelHelpers\Classes\Seo\Robots\Abstracts;

use Illuminate\Support\Facades\File;
use Medboubazine\LaravelHelpers\Classes\Seo\Robots\Elements\RobotsDotTextUserAgentElement;
use Medboubazine\LaravelHelpers\Classes\Seo\Robots\Exceptions\RobotsDotTextGeneratorException;

abstract class RobotsDotTextGeneratorAbstract
{
    /**
     * File
     *
     * @var string
     */
    public string $file_name;
    /**
     * Path
     *
     * @var string
     */
    public string $path;
    /**
     * Content of robots file
     *
     * @var string
     */
    public string $content = '';
    /**
     * Constructor
     */
    public function __construct(RobotsDotTextUserAgentElement $element, ?string $path = null, ?string $file_name = null)
    {
        $this->init($element, $path, $file_name);
    }
    /**
     * Constructor
     */
    public function init(RobotsDotTextUserAgentElement $element, ?string $path = null, ?string $file_name = null)
    {
        $this->path = ($path) ? $path : public_path();
        $this->file_name = ($file_name) ? $file_name : "robots.txt";
        // File Contents
        $user_agent = $element->getUserAgent();
        if ($user_agent && is_string($user_agent) && strlen($user_agent) > 0) {
            $routes = $element->getRoutes();

            if ($routes && is_array($routes) && count($routes) > 0) {
                //
                //content
                $content = "";
                //START User Agent
                $content .= "User-agent: {$user_agent}\n";

                foreach ($routes as $uri) {
                    $uri =  trim($uri, " .\n\r\t\v\x00\\\/");

                    if (!empty($uri) and $uri !== "*") {
                        $content .= "Disallow: /{$uri}\n";
                        $content .= "Disallow: /{$uri}/*\n";
                    }
                }
                $content .= "\n";
                //END User Agent
                //START Site Map
                $sitemaps = $element->getSitemaps();
                if ($sitemaps && is_array($sitemaps) && count($sitemaps) > 0) {
                    foreach ($sitemaps as $sitemap) {
                        $content .= "Sitemap: {$sitemap}\n";
                    }
                }
                //END SITEMAP
                //ALL IS OK
                $this->content .= $content;
            } else {
                RobotsDotTextGeneratorException::message("RobotsDotTextGenerator: Routes must be present");
            }
        } else {
            RobotsDotTextGeneratorException::message("RobotsDotTextGenerator: User Agent must be present");
        }
        //

        return $this;
    }
    /**
     * Create robots file
     *
     * @return boolean
     */
    public function generate(): bool
    {
        $path = "{$this->path}/{$this->file_name}";
        $directory = dirname($path);

        if (File::isWritable($directory)) {
            $deleted = true;
            if (File::exists($path)) {
                $deleted = File::delete($path);
            }
            if ($deleted) {
                return boolval(File::put($path, $this->content));
            } else {
                RobotsDotTextGeneratorException::message("RobotsDotTextGenerator: Cannot delete the old file {$path}");
            }
        } else {
            RobotsDotTextGeneratorException::message("RobotsDotTextGenerator: Cannot write to path ($path)");
        }
        return false;
    }
}
