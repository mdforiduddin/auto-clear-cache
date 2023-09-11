<?php

namespace Auto_Clear_Cache\Includes;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * The Clear Cache handler class
 */
class Cache {

    /**
     * Class constructor
     */
    public function __construct() {

        new Cache\Elementor_Cache();

        new Cache\Site_Ground_cache();
    }
}