<?php

/*
 * Magic PHP
 */

namespace Trismegiste\Magic\Pattern\Singleton;

/**
 * This is no "official" pattern nor a valid practice but let me present you
 * this strange thing : The First Official Singleton That Can Be Subclassed !
 *
 * Thanx PHP, you did it :) It is funny because the Singleton pattern is sometimes
 * not considered like a true pattern since you can't extend it and then it brakes
 * the Open Close Principle. Furthermore, it is static, therefore global, therefore
 * evil.
 *
 * If you want to follow DIP, don't use this pattern.
 *
 */
class Singleton
{

    private static $instancePool = array();

    public static function getInstance()
    {
        $key = get_called_class();
        if (!array_key_exists($key, self::$instancePool)) {
            self::$instancePool[$key] = new $key();
        }

        return self::$instancePool[$key];
    }

    // Preventing any construction
    private function __construct()
    {

    }

    private function __clone()
    {

    }

    public function __wakeup()
    {
        throw new \LogicException('You cannot unserialize this Singleton');
    }

}