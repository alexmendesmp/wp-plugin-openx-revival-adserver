<?php
/*
Plugin Name: DCCODE OpenX Revival Adserver
Description: Easy to show OpenX/Revive ads on your Wordpress Site!
Version: 1.0
Author: Alex Mendes
License: GPLv2 or later
*/

$OPENX_SETTINGS = get_option( 'dccode-openx-settings', array() );

define( 'DCCODE_OPENX_VERSION', $OPENX_SETTINGS['openx_version'] );
define( 'DCCODE_OPENX_AFFILIATE_ID', $OPENX_SETTINGS['openx_affiliate_id'] );
define( 'DCCODE_OPENX_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'DCCODE_OPENX_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'DCCODE_OPENX_URL', $OPENX_SETTINGS['openx_url'] );

/**
 * Allow shortcode in widget text.
 */
add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Register OPENX Test Sidebar.
 */
add_action( 'widgets_init', array( 'Dccode_Widget_Adserver', 'register_widget_area' ), 99 );

/**
 * Include all classes and functions.
 */
include( DCCODE_OPENX_PLUGIN_DIR . 'lib/dccode-adserver-lib-enqueue-scripts.php' );
include( DCCODE_OPENX_PLUGIN_DIR . 'lib/dccode-adserver-openx-functions.php' );
include( DCCODE_OPENX_PLUGIN_DIR . 'class/dccode-adserver-class-widgets.php' );
include( DCCODE_OPENX_PLUGIN_DIR . 'dccode-adserver-openx-admin.php' );
/**
 * Add Submenu Admin Page
 */
function dccode_openx_add_menu_page() {
    add_submenu_page( 'options-general.php', 'DCCode OPENX (REVIVE) settings', 'DCCode OPENX Settings', 'manage_options', 'openx-settings', 'dccode_openx_settings' );
}
add_action( 'admin_menu', 'dccode_openx_add_menu_page' );

/**
 * Load Text Domain
 * 
 * @since 1.0
 */
add_action( 'plugins_loaded', 'dccode_adserver_openx_load_text_domain' );
function dccode_adserver_openx_load_text_domain() {
    load_plugin_textdomain( 'txt-dc-openx', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}