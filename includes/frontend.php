<?php

namespace Auto_Clear_Cache\Includes;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Auto_Clear_Cache\Includes\Frontend\Automatic_Clear_Cache;
use Auto_Clear_Cache\Includes\Frontend\Manually_Clear_Cache;

/**
 * The Frontend handler class
 */
class Frontend {
    public function __construct() {

        new Manually_Clear_Cache();

        new Automatic_Clear_Cache();
    }
}