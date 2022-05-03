<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3c40586674ff143c9741a5cf972af452
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tears\\ProgressBar\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tears\\ProgressBar\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3c40586674ff143c9741a5cf972af452::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3c40586674ff143c9741a5cf972af452::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3c40586674ff143c9741a5cf972af452::$classMap;

        }, null, ClassLoader::class);
    }
}