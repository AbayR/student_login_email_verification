<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit178c4862a9ef72d1bd7504d0c8ec8f84
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit178c4862a9ef72d1bd7504d0c8ec8f84', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit178c4862a9ef72d1bd7504d0c8ec8f84', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        \Composer\Autoload\ComposerStaticInit178c4862a9ef72d1bd7504d0c8ec8f84::getInitializer($loader)();

        $loader->register(true);

        return $loader;
    }
}
