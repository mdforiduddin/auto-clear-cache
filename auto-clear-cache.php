<?php
/**
 * Plugin Name: Auto Clear Cache
 * Description: The Auto Clear Cache plugin automatically clears the cache for WordPress and Elementor every 24 hours to ensure your website always displays the latest content.
 * Version: 1.0.0
 * Author: Md Forid Uddin
 * Author URI: https://github.com/mdforiduddin
 * Elementor tested up to: 3.14.1
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: auto-clear-cache
 *
 * @package Auto_Clear_Cache
 */

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

require_once __DIR__ . '/autoloader.php';

use Auto_Clear_Cache\Includes\Assets;
use Auto_Clear_Cache\Includes\Frontend;
use Auto_Clear_Cache\Includes\Installer;
use Auto_Clear_Cache\Includes\Menu_Bar;

/*
 * Main plugin class
 *
 * @author   Md Forid Uddin
 */
final class Auto_Clear_Cache {

    /**
     * Auto Clear Cache Version
     *
     * @var string
     */
    private $auto_clear_cache_version = '1.0.0';

    /**
     * The Unique Instance of the Plugin
     */
    protected static $instance = null;

    /**
     * Class construcotr
     */
    private function __construct() {

        $this->define_constants();

        register_activation_hook( __FILE__, [$this, 'activate'] );

        add_action( 'plugins_loaded', [$this, 'init_plugin'] );
    }

    /**
     * Initiatizes a singleton instance
     *
     * @return /Auto_Clear_Cache
     */
    public static function get_instance() {

        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'Auto_Clear_Cache_Version', $this->auto_clear_cache_version );
        define( 'Auto_Clear_Cache_FILE', __FILE__ );
        define( 'Auto_Clear_Cache_PATH', __DIR__ );
        define( 'Auto_Clear_Cache_URL', plugins_url( '', Auto_Clear_Cache_FILE ) );
        define( 'Auto_Clear_Cache_Assets', Auto_Clear_Cache_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        new Assets();

        if ( is_admin() ) {
        } else {
            new Frontend();
        }
        
        if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
            new Menu_Bar();
        }
    }

    public function activate() {
        new Installer();
    }
}
/*
 * Initializes the main plugin
 *
 * @return /Auto_Clear_Cache
 */
function auto_clear_cache_run() {
    return Auto_Clear_Cache::get_instance();
}

// kick-off the plugin
auto_clear_cache_run();
