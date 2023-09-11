<?php

namespace Auto_Clear_Cache\Includes;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * The Admin Bar Menu handler class
 */
class Menu_Bar {

    public function __construct() {
        add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 85 );
    }

    /**
     * Admin Bar Menu Funtion
     *
     * @param  $wp_admin_bar
     * @return void
     */
    public function admin_bar_menu( $wp_admin_bar ) {

        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }

        $admin_menu = array(
            // 'id'     => 'elementor_elear_eache_menu',
            'id'     => 'auto-clear-cache-menu-bar',
            'parent' => '',
            'title'  => __( 'Auto Clear Cache', 'auto-clear-cache' ),
            'href'   => get_site_url() . '/?auto-clear-cache',
            'meta'   => array(
                'title' => __( 'Auto Clear Cache', 'auto-clear-cache' ),
            ),
        );

        $wp_admin_bar->add_node( $admin_menu );
    }
}