<?php

/**
 * Enqueue required OpenX scripts.
 */
function dccode_ads_enqueue_script() {
    wp_register_script( 'spcjs', DCCODE_OPENX_URL . '/www/delivery/spcjs.php?id=' . DCCODE_OPENX_AFFILIATE_ID, false, DCCODE_OPENX_VERSION, false );
    wp_register_style( 'dc-openx-style', DCCODE_OPENX_PLUGIN_URL . '/css/style.css', array(), DCCODE_OPENX_VERSION );
    wp_enqueue_script( 'spcjs' );
    wp_enqueue_style( 'dc-openx-style' );
}
add_action( 'wp_enqueue_scripts', 'dccode_ads_enqueue_script', 1 );
// Register in admin enqueue
add_action( 'admin_enqueue_scripts', 'dccode_ads_enqueue_script' );