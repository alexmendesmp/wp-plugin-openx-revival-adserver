<?php
/** 
 * Functions
 * 
 * @since 1.0
 */

/**
 * Return the banner.
 * 
 * @since 1.0
 * 
 * @param int $zoneid Zone ID
 * @param string $class Class Name
 * @param string $target Click Target
 */
function dc_openx_the_banner( $zoneid = '', $class = '', $target = '_blank' ) {
    $class = ( empty( $class ) ) ? "dccode-openx-div-class-zoneid-{$zoneid}" : $class;
    $n = substr( md5( floor( rand( 0, 9 ) * 9999999 ) ), 0, 7 );
    ob_start();
    ?>
    <div class="<?php echo $class; ?>">
    <script type='text/javascript'>
        <!--// <![CDATA[
        /* ADS OPENX REVIVE */
        OA_show(<?php echo $zoneid; ?>);
        // ]]> -->
    </script>
    <noscript>
        <a target='<?php echo $target; ?>' href='<?php echo DCCODE_OPENX_URL; ?>/www/delivery/ck.php?n=<?php echo $n; ?>'>
            <img border='0' alt='' src='<?php echo DCCODE_OPENX_URL; ?>/www/delivery/avw.php?zoneid=<?php echo $zoneid; ?>&amp;n=<?php echo $n; ?>' />
        </a>
    </noscript>
    </div>    
    <?php
    ob_end_flush();
}
// The Action
add_action( 'do_openx_the_banner', 'dc_openx_the_banner', 10, 3 );

/**
 * This function parses the shortcode.
 * 
 * @since 1.0
 */
function dc_openx_the_banner_shortcode( $args, $content = null ) {
    $vars = shortcode_atts( 
            array(
                'zoneid'    => '0',
                'class'     => '',
                '_target'   => '_blank'
            ), $args );

    $zoneid = $vars['zoneid'];
    $class = $vars['class'];
    $target = $vars['_target'];
    $class = ( empty( $class ) ) ? "dccode-openx-div-class-zoneid-{$zoneid}" : $class;
    $n = substr( md5( floor( rand( 0, 9 ) * 9999999 ) ), 0, 7 );
    ob_start();
    ?>
    <div class="<?php echo esc_attr( $class ); ?>">
    <script type='text/javascript'>
        <!--// <![CDATA[
        /* ADS OPENX REVIVE */
        OA_show(<?php echo $zoneid; ?>);
    // ]]> -->
    </script>
    <noscript>
        <a target='<?php echo $target; ?>' href='<?php echo DCCODE_OPENX_URL; ?>/www/delivery/ck.php?n=<?php echo $n; ?>'>
            <img border='0' alt='' src='<?php echo DCCODE_OPENX_URL; ?>/www/delivery/avw.php?zoneid=<?php echo $zoneid; ?>&amp;n=<?php echo $n; ?>' />
        </a>
    </noscript>
    </div>    
    <?php
    return ob_get_clean();
}
// The shortcode
add_shortcode( 'dc_openx_banners', 'dc_openx_the_banner_shortcode' );