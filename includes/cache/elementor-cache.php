<?php

namespace Auto_Clear_Cache\Includes\Cache;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * The Elementor Cache Clear handler class
 */
class Elementor_Cache {

    /**
     * Class constructor
     */
    public function __construct() {
        $this->run();
    }

    /**
     * Make sure the Elementor plugin is active
     *
     * @return bool
     */
    function check_plugin() {

        if ( did_action( 'elementor/loaded' ) && class_exists( 'Elementor\Plugin' ) ) {
            return true;
        }

        return false;
    }

    /**
     * Run Elementor Cache Clear Function
     *
     * @return void
     */
    function run() {

        $is_active = $this->check_plugin();

        if ( $is_active ) {
            $Elementor_instance = \Elementor\Plugin::$instance;

            /* Check if the files_manager property exists and has the clear_cache() method */
            if ( isset( $Elementor_instance->files_manager ) && method_exists( $Elementor_instance->files_manager, 'clear_cache' ) ) {
                $Elementor_instance->files_manager->clear_cache();
                
                // echo nl2br( "Elementor Clear Cache Done\n" );
            }
        }
    }
}