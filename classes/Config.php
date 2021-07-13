<?php
class Config {
    public static function get($path = NULL) {
        if ($path) {

            $config = $GLOBALS['config'];
            $path = explode('/', $path);

            foreach ($path as $key) {
                if (is_array($config) && array_key_exists($key, $config)) {
                    $config = $config[$key];                    
                } else {
                    return false;                    
                }
            }
            return $config;
        }
        return false;
    }
}