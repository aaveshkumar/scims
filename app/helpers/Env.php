<?php

class Env
{
    private static $variables = [];
    private static $loaded = false;

    public static function load($path)
    {
        if (self::$loaded) {
            return;
        }

        if (!file_exists($path)) {
            throw new Exception(".env file not found at: {$path}");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }

            if (strpos($line, '=') === false) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            $value = trim($value, '"\'');

            self::$variables[$name] = $value;
            
            if (!getenv($name)) {
                putenv("{$name}={$value}");
            }
        }

        self::$loaded = true;
    }

    public static function get($key, $default = null)
    {
        $value = getenv($key);
        if ($value !== false) {
            return trim($value);
        }

        if (isset(self::$variables[$key])) {
            return trim(self::$variables[$key]);
        }

        return $default;
    }

    public static function has($key)
    {
        return isset(self::$variables[$key]) || getenv($key) !== false;
    }

    public static function all()
    {
        return self::$variables;
    }
}
