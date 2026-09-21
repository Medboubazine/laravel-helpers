<?php

namespace Medboubazine\LaravelHelpers\Classes\Abstracts;

use Illuminate\Support\Str;

abstract class ElementsAbstract
{
    /**
     * Attributes
     *
     * @var array
     */
    public array $attributes = [];
    /**
     * Magic Call
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (Str::startsWith($name, "set")) {
            $attribute_name = Str::snake(Str::substr($name, 3, 200));
            $this->attributes[$attribute_name] = ($arguments[0] ?? null);
            return $this;
        }
        if (Str::startsWith($name, "get")) {
            $attribute_name = Str::snake(Str::substr($name, 3, 200));
            return $this->attributes[$attribute_name] ?? null;
        }
        return null;
    }
}
