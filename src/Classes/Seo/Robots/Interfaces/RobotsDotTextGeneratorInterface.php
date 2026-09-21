<?php

namespace Medboubazine\LaravelHelpers\Classes\Seo\Robots\Interfaces;

use Medboubazine\LaravelHelpers\Classes\Seo\Robots\Elements\RobotsDotTextUserAgentElement;

interface RobotsDotTextGeneratorInterface
{
    public function init(RobotsDotTextUserAgentElement $element, ?string $path = null, ?string $file_name = null);
    public function generate(): bool;
}
