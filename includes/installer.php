<?php

namespace Auto_Clear_Cache\Includes;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
/**
 * Installer Class
 */
class Installer {

    /**
     * Class construcotr
     */
    public function __construct() {
        $this->run();
    }

    /**
     * Run the installer
     *
     * @return void
     */
    public function run() {
        $this->add_version();
    }

    public function add_version() {
        if ( !get_option( 'auto_clear_cache_installed' ) ) {
            update_option( 'auto_clear_cache_installed', current_time( 'mysql' ) );
        }

        update_option( 'auto_clear_cache_version', Auto_Clear_Cache_Version );
    }
}