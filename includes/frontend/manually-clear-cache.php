<?php

namespace Auto_Clear_Cache\Includes\Frontend;

use Auto_Clear_Cache\Includes\Cache;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * The Frontend Manually Clear Cache handler class
 */
class Manually_Clear_Cache {

    /**
     * Class constructor
     */
    public function __construct() {

        add_filter( 'page_template', array( $this, 'run' ) );
    }

    /**
     * @param  $page_template
     * @return mixed
     */
    public function run( $page_template ) {

        $qurey_check = $this->query_check();

        if ( $qurey_check ) {
            new Cache();

            wp_cache_flush();

            // echo nl2br( "Menually Clear Cache Done\n" );

            add_action( 'wp_footer', array( $this, 'manually_clear_cache_message' ) );
        }

        return $page_template;
    }

    /**
     * Manually Clear Cache Check Funtion
     *
     * @return bool
     */
    public function query_check() {

        $User_Request = $_SERVER["REQUEST_URI"];

        $User_Request_Query = parse_url( $User_Request );

        if ( array_key_exists( 'query', $User_Request_Query ) ) {
            parse_str( $User_Request_Query['query'], $User_Query );

            if ( array_key_exists( 'auto-clear-cache', $User_Query ) ) {
                return true;
            }
        }

        return false;
    }

    public function manually_clear_cache_message() {

        wp_enqueue_style('auto-clear-cache-style');

        $Auto_Clear_Cache_Successfully = sprintf( '<div class="auto-clear-cache-modal">
            <p class="auto-clear-cache-message auto-clear-cache-successfully">
            %s
            </p>
        </div>', __( 'Auto Clear Cache Successfully Cleared.', 'auto-clear-cache' ) );

        echo $Auto_Clear_Cache_Successfully;
    }
}