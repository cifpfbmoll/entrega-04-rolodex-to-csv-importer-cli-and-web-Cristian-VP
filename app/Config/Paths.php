<?php

namespace Config;

/**
 * Paths
 *
 * Provides a location-aware configuration of the
 * directories used by the application.
 */
class Paths
{
    /**
     * ---------------------------------------------------------------
     * SYSTEM DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of your "system" directory.
     * By default the system directory is located in your project root.
     */
    public $systemDirectory = __DIR__ . '/../../vendor/codeigniter4/framework/system';

    /**
     * ---------------------------------------------------------------
     * APPLICATION DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * If you want this front controller to use a different "app"
     * folder than the default one you can set its name here. The folder
     * can also be renamed or relocated anywhere on your server.
     * For more info please see the user guide:
     * https://codeigniter.com/user_guide/general/managing_apps.html
     */
    public $appDirectory = __DIR__ . '/../../app';

    /**
     * ---------------------------------------------------------------
     * WRITABLE DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of your "writable" directory.
     * By default the "writable" directory is located inside your
     * application directory.
     */
    public $writableDirectory = __DIR__ . '/../../writable';

    /**
     * ---------------------------------------------------------------
     * TESTS DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of your "tests" directory.
     * By default the "tests" directory is located inside your
     * application directory.
     */
    public $testsDirectory = __DIR__ . '/../../tests';

    /**
     * ---------------------------------------------------------------
     * VIEW DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of the directory that
     * contains the view files used by your application. By default
     * this is in "app/Views". This value is used by the core View
     * class when locating view files.
     */
    public $viewDirectory = __DIR__ . '/../../app/Views';

    /**
     * ---------------------------------------------------------------
     * HAMMER DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of the directory that
     * contains the "hammer" command line utility.
     */
    public $hammerDirectory = __DIR__ . '/../../vendor/codeigniter4/framework';

    /**
     * ---------------------------------------------------------------
     * NAMESPACE ROOT DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of the directory that
     * contains the "namespace root directory". By default this is
     * the "src" directory.
     */
    public $namespaceRootDirectory = __DIR__ . '/../../src';
}
