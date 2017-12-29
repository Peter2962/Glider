<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit993118cb82670a717d6c6acc2965467e
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Glider\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Glider\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit993118cb82670a717d6c6acc2965467e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit993118cb82670a717d6c6acc2965467e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}