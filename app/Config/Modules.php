<?php

namespace Config;

/**
 * --------------------------------------------------------------------
 * Modules Configuration
 * --------------------------------------------------------------------
 *
 * This file defines the namespaces and locations of the modules
 * that are used by the application.
 */
class Modules
{
    /**
     * -------------------------------------------------------------------
     * Auto-Discover
     * -------------------------------------------------------------------
     *
     * If true, the system will automatically discover and load
     * all modules in the specified directories.
     */
    public $autoDiscover = false; // Deshabilitado temporalmente

    /**
     * -------------------------------------------------------------------
     * Discover in Composer
     * -------------------------------------------------------------------
     *
     * If true, the system will discover services in Composer packages.
     */
    public $discoverInComposer = false; // Deshabilitado temporalmente

    /**
     * -------------------------------------------------------------------
     * Composer Packages
     * -------------------------------------------------------------------
     *
     * Composer packages to auto-discover from.
     */
    public $composerPackages = [];

    /**
     * -------------------------------------------------------------------
     * Auto-Discover Paths
     * -------------------------------------------------------------------
     *
     * The paths to search for modules when auto-discovering.
     */
    public $autoDiscoverPaths = [
        APPPATH . 'Modules',
        ROOTPATH . 'Modules',
    ];

    /**
     * -------------------------------------------------------------------
     * Modules
     * -------------------------------------------------------------------
     *
     * The modules that are loaded by the application.
     * The key is the module name and the value is the path to the module.
     */
    public $modules = [];

    /**
     * -------------------------------------------------------------------
     * Should Discover
     * -------------------------------------------------------------------
     *
     * Returns whether the system should auto-discover modules.
     *
     * @param string $type The type to check (e.g., 'services', 'commands')
     * @return bool
     */
    public function shouldDiscover(string $type = ''): bool
    {
        return $this->autoDiscover;
    }
}
