<?php

namespace Auto_Clear_Cache\Includes\Cache;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use SiteGround_Optimizer\File_Cacher\File_Cacher;
use SiteGround_Optimizer\Options\Options;
use SiteGround_Optimizer\Supercacher\Supercacher;

/**
 * The SiteGround Optimizer Cache Clear handler class
 */
class Site_Ground_cache {

    /**
     * Class constructor
     */
    public function __construct() {
        $this->run();
    }

    /**
     * Make sure the SiteGround Optimizer plugin is active
     *
     * @return bool
     */
    function check_plugin() {

        if ( !function_exists( 'is_plugin_active' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        if ( is_plugin_active( 'sg-cachepress/sg-cachepress.php' ) ) {
            return true;
        }

        return false;
    }

    /**
     * Run SiteGround Optimizer Cache Clear Function
     *
     * @return void
     */
    function run() {

        $is_active = $this->check_plugin();

        if ( $is_active ) {
            if ( !function_exists( 'sg_cachepress_purge_everything' ) ) {
                require PLUGINDIR . '\sg-cachepress\helpers\helpers.php';
            }

            Supercacher::purge_cache();

            Supercacher::delete_assets();

            /* Flush File-Based cache if enabled. */
            if ( Options::is_enabled( 'siteground_optimizer_file_caching' ) ) {
                File_Cacher::get_instance()->purge_everything();
            }

            sg_cachepress_purge_everything();

            // echo nl2br( "siteGround Optimizer Clear Cache Done\n" );
        }
    }
}