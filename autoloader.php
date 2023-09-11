<?php

namespace Auto_Clear_Cache;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// require_once __DIR__ . '/autoloader.php';

/**
 * Main Autoloader plugin class
 * 
 * @author Md Forid Uddin
 *
 * @link https://profiles.wordpress.org/mdforiduddin/
 * @since 1.0.0
 */
class Autoloader {

    /**
     * Run autoloader.
     * Register a function as `__autoload()` implementation.
     *
     * @access public
     * @since 1.0.0
     */
    public static function run() {
        spl_autoload_register( [__CLASS__, '__autoload'] );
    }

    /**
     * Autoload.
     * For a given class, check if it exist and load it.
     *
     * @access private
     * @since 1.0.0
     * @param string $class Class name.
     */
    private static function __autoload( $class_name ) {

        /*
         * If the class being requested does not start with our prefix
         * we know it's not one in our project.
         */
        if ( 0 !== strpos( $class_name, __NAMESPACE__ ) ) {
            return;
        }

        $file_name = strtolower(
            preg_replace(
                ['/\b' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/'],
                ['', '$1-$2', '-', DIRECTORY_SEPARATOR],
                $class_name
            )
        );

        /*
         * Compile our path from the corosponding location.
         */
        $file = plugin_dir_path( __FILE__ ) . $file_name . '.php';

        /*
         * check if it exist and load it.
         */
        if ( file_exists( $file ) ) {
            require_once $file;
        }
    }
}

/*
 * kick-off the Autoloader
 */
Autoloader::run();