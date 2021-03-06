<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8ecdeb254e2b73264c1728becbf54412
{
    public static $files = array (
        'bd9634f2d41831496de0d3dfe4c94881' => __DIR__ . '/..' . '/symfony/polyfill-php56/bootstrap.php',
        '9b552a3cc426e3287cc811caefa3cf53' => __DIR__ . '/..' . '/topthink/think-helper/src/helper.php',
        'cc56288302d9df745d97c934d6a6e5f0' => __DIR__ . '/..' . '/topthink/think-queue/src/common.php',
        'de5a05d860a3458e33da1cc737ac32ea' => __DIR__ . '/..' . '/qsnh/think-log-viewer/autoload.php',
        '1cfd2761b63b0a29ed23657ea394cb2d' => __DIR__ . '/..' . '/topthink/think-captcha/src/helper.php',
        'ea51e7f80936725691663347d5b38bd9' => __DIR__ . '/..' . '/topthink/think-swoole/src/command.php',
    );

    public static $prefixLengthsPsr4 = array (
        't' => 
        array (
            'think\\swoole\\' => 13,
            'think\\composer\\' => 15,
            'think\\captcha\\' => 14,
            'think\\' => 6,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
        'X' => 
        array (
            'XCron\\' => 6,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Util\\' => 22,
            'Symfony\\Polyfill\\Php56\\' => 23,
            'SuperClosure\\' => 13,
        ),
        'Q' => 
        array (
            'Qsnh\\Think\\Log\\' => 15,
        ),
        'P' => 
        array (
            'PhpParser\\' => 10,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'think\\swoole\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-swoole/src',
        ),
        'think\\composer\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-installer/src',
        ),
        'think\\captcha\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-captcha/src',
        ),
        'think\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-helper/src',
            1 => __DIR__ . '/..' . '/topthink/think-queue/src',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/application',
        ),
        'XCron\\' => 
        array (
            0 => __DIR__ . '/..' . '/xavier/xcron-expression/src/Cron',
        ),
        'Symfony\\Polyfill\\Util\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-util',
        ),
        'Symfony\\Polyfill\\Php56\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php56',
        ),
        'SuperClosure\\' => 
        array (
            0 => __DIR__ . '/..' . '/jeremeamia/superclosure/src',
        ),
        'Qsnh\\Think\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/qsnh/think-log-viewer/src',
        ),
        'PhpParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/php-parser/lib/PhpParser',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Ip2Region' => __DIR__ . '/..' . '/zoujingli/ip2region/Ip2Region.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8ecdeb254e2b73264c1728becbf54412::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8ecdeb254e2b73264c1728becbf54412::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8ecdeb254e2b73264c1728becbf54412::$classMap;

        }, null, ClassLoader::class);
    }
}
