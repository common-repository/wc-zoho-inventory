<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3c89c9c0ddb43211e74b5a96453ef936
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'BitPress\\BIT_WC_ZOHO_INVENTORY\\' => 31,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'BitPress\\BIT_WC_ZOHO_INVENTORY\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit3c89c9c0ddb43211e74b5a96453ef936::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3c89c9c0ddb43211e74b5a96453ef936::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3c89c9c0ddb43211e74b5a96453ef936::$classMap;

        }, null, ClassLoader::class);
    }
}