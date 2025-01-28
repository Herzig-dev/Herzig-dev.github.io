<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit11ae801ba0b1635715f26b5875557c06
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WhiteSoft\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WhiteSoft\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit11ae801ba0b1635715f26b5875557c06::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit11ae801ba0b1635715f26b5875557c06::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit11ae801ba0b1635715f26b5875557c06::$classMap;

        }, null, ClassLoader::class);
    }
}
