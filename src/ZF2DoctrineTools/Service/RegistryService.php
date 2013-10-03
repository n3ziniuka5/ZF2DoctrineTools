<?php
namespace ZF2DoctrineTools\Service;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property array    $registry
 */
class RegistryService
{

    protected static $registry = [];

    public static function set($key, $var)
    {
        $key = (string)$key;
        if (!strlen($key)) {
            throw new \Exception('Invalid registry key');
        }
        self::$registry[$key] = $var;
    }

    public static function get($key)
    {
        if (!self::exists($key)) {
            throw new \Exception('Specified key does not exist in the registry');
        }
        return self::$registry[$key];
    }

    public static function exists($key)
    {
        return array_key_exists($key, self::$registry);
    }
}