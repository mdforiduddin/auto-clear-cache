<?php

namespace Auto_Clear_Cache\Includes\Frontend;

use Auto_Clear_Cache\Includes\Cache;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * The Frontend Manually Clear Cache handler class
 */
class Automatic_Clear_Cache {

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

        if ( $this->query_check() ) {
            return $page_template;
        }

        if ( !is_admin() && is_user_logged_in() ) {
            return $page_template;
        }

        if ( !get_option( 'auto_clear_cache_run_time' ) ) {
            update_option( 'auto_clear_cache_run_time', current_time( 'mysql' ) );
        }

        $auto_clear_cache_run_time = get_option( 'auto_clear_cache_run_time' );

        if ( $auto_clear_cache_run_time ) {
            $auto_clear_cache_diff_time = current_time( 'timestamp' ) - strtotime( $auto_clear_cache_run_time );

            // $twenty_four_hours = 24 * 60 * 60;
            $twenty_four_hours = 20;

            echo $auto_clear_cache_diff_time;

            if ( $auto_clear_cache_diff_time >= $twenty_four_hours ) {
                update_option( 'auto_clear_cache_run_time', current_time( 'mysql' ) );

                new Cache();

                $this->automatic_run_count();

                wp_cache_flush();

                // echo nl2br( "Automatic Cache Done ->" ) .  get_option( 'auto_clear_cache_run_count', 0 ) . "<br>" ;
            }
        }

        return $page_template;
    }

    /**
     * Manually Query Check Funtion
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

    /**
     * Function to increment automatic run count
     *
     * @return void
     */
    private function automatic_run_count() {

        /* Get the current count from the database */
        $load_count = get_option( 'auto_clear_cache_run_count', 0 );

        /* Increment the count */
        $load_count++;

        /* Update the count in the database */
        update_option( 'auto_clear_cache_run_count', $load_count );
    }
}