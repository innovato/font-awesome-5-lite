<?php
/**
 * Font Awesome 5 Lite Autoloader file
 */

class Font_Awesome_5_Lite_Autoloader
{
    /**
     * @param string $className
     */
    public static function autoload($className)
    {
        if (strpos($className, "FaLite")) {
            $file = explode('\\', $className);
            $file = realpath(dirname(__FILE__) . '/src/'.$file[1].'.php');

            if ($file !== false) {
                require $file;
            }
        }
    }

    /**
     * @return bool
     */
    public static function register()
    {
        return spl_autoload_register(array(__CLASS__, "autoload"));
    }

    /**
     * @return bool
     */
    public static function unregister()
    {
        return spl_autoload_unregister(array(__CLASS__, "autoload"));
    }
}

Font_Awesome_5_Lite_Autoloader::register();