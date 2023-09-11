<?php

namespace Auto_Clear_Cache\Includes;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * The Frontend handler class
 */
class Assets {
    public function __construct() {

        add_action( 'wp_enqueue_scripts', [$this, 'auto_clear_cache_load_scripts'] );
    }

    /**
     * WordPress Enqueue Sctipts
     *
     */
    public function auto_clear_cache_load_scripts() {
        wp_register_style( 'auto-clear-cache-style', Auto_Clear_Cache_Assets . '/style.css', array(), Auto_Clear_Cache_Version );
    }
}