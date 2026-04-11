<?php

namespace Aternos\Mclogs\Util;

trait Singleton
{
    /**
     * @var static[]
     */
    protected static array $instances = [];

    /**
     * Prohibited for singleton
     */
    protected function __construct()
    {
    }

    public static function getInstance(): static
    {
        $class = get_called_class();

        if (!isset(static::$instances[$class])) {
            static::$instances[$class] = new static;
        }

        return static::$instances[$class];
    }

    /**
     * Prohibited for singleton
     */
    protected function __clone()
    {
    }
}