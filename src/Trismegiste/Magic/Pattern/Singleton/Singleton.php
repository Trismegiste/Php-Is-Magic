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
 * If you want to follow DIP, don't use this pattern, use a DiC
 * 
 * Last but not the least this pattern is not SRP
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

    /**
     * @codeCoverageIgnore
     */
    private function __clone()
    {

    }

    public function __wakeup()
    {
        // I prefer to throw an exception here because it's insanely hard to track 
        // a bug with the session wakeup.
        throw new \LogicException('You cannot unserialize this Singleton');
    }

}