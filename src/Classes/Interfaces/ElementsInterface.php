<?php

namespace Medboubazine\LaravelHelpers\Classes\Interfaces;

interface ElementsInterface
{
    /**
     * Magic Call
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments);
}
