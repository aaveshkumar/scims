<?php

class Config
{
    private static $configs = [];

    public static function load($name)
    {
        if (isset(self::$configs[$name])) {
            return self::$configs[$name];
        }

        $path = CONFIG_PATH . '/' . $name . '.php';
        
        if (!file_exists($path)) {
            throw new Exception("Config file not found: {$name}");
        }

        self::$configs[$name] = require $path;
        return self::$configs[$name];
    }

    public static function get($key, $default = null)
    {
        $keys = explode('.', $key);
        $configName = array_shift($keys);

        $config = self::load($configName);

        foreach ($keys as $segment) {
            if (!is_array($config) || !isset($config[$segment])) {
                return $default;
            }
            $config = $config[$segment];
        }

        return $config;
    }

    public static function all($name)
    {
        return self::load($name);
    }
}
