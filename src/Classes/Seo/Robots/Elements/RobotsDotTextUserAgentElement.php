<?php

namespace Medboubazine\LaravelHelpers\Classes\Seo\Robots\Elements;

use Medboubazine\LaravelHelpers\Classes\Abstracts\ElementsAbstract;
use Medboubazine\LaravelHelpers\Classes\Interfaces\ElementsInterface;

/**
 * @method string getUserAgent()
 * @method array getRoutes()
 * @method array getSitemaps()
 */
class RobotsDotTextUserAgentElement extends ElementsAbstract implements ElementsInterface
{
    /**
     * Set robots.txt file parameters
     *
     * @param string $user_agent
     * @param array $routes
     */
    public function __construct(string $user_agent, array $routes, array $sitemaps = [])
    {
        $this->setUserAgent(trim($user_agent));
        $this->setRoutes($routes);
        $this->setSitemaps($sitemaps);
    }
}
