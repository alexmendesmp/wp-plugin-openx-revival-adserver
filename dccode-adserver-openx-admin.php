<?php
/**
 * Define Constants
 * 
 * @since 1.0
 */
define( 
        'VERSION_HOWTO_TXT', 
         'Where to find it? <br />'
        .'1. Log in your Openx/Revive account. <br />'
        .'2. Switch to Administrator Account.<br />'
        .'3. Go to Configuration -> Product Updates'
);
define( 
        'AFFILIATEID_HOWTO_TXT', 
        'Where to find it? <br />'
        .'1. Log in your Openx/Revive account.<br />'
        .'2. Go to Inventory -> Websites -> and click on the name of the website you are working with.<br />'
        .'3. Search for (affiliateid=) in your Browser Address Bar.'
);
/** 
 * Settings
 * 
 * @since 1.0
 */
function dccode_openx_settings() {
    /**
     * Saving form
     */
    if( ! empty( $_POST ) ) {
        if( dccode_openx_save_settings( $_POST ) ) : ?>
            <div id="message" class="message updated notice notice-success below-h1">
                <p><?php echo __( 'Settings updated', 'txt-dc-openx' ); ?></p>
            </div>
        <?php else: ?>
            <div id="message" class="message notice notice-error below-h1">
                <p><?php echo __( 'Error! Please check your informations', 'txt-dc-openx' ); ?></p>
            </div>
        <?php endif;
    }
    // Get settings from option table 
    $options_ox = false;
    $options_ox = (object) get_option( 'dccode-openx-settings', false );
    
    ?>
<div class="wrap">
    <h1><?php echo __( 'OPENX/REVIVE Settings', 'txt-dc-openx' ); ?></h1>
    <form name="dccode-openx-settings" id="dccode-openx-settings" action="options-general.php?page=openx-settings" method="post">
        <table class="form-table">
            <tr><!-- VERSION -->
                <th><label for="openx_version"><?php echo __( 'Openx/Revive Version:', 'txt-dc-openx' ); ?></label></th>
                <td>
                    <select name="openx_version" id="openx_version">
                        <?php $versions = dccode_openx_versions(); ?>
                        <?php foreach( $versions as $k => $version ) : ?>
                            <?php
                                $selected = '';
                                if( (int) $options_ox->openx_version == (int) $k ) {
                                    $selected = 'SELECTED'; 
                                }
                            ?>
                            <option value="<?php echo $k; ?>" <?php echo $selected; ?>><?php echo $version; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p class="howto"><?php echo __( '(eg.: 1.0)', 'txt-dc-openx' ); ?></p>
                    <p class="howto">
                        <?php echo __( VERSION_HOWTO_TXT, 'txt-dc-openx' ); ?>
                    </p>
                </td>
            </tr>
            <tr><!-- AFFILIATE ID -->
                <th><label for="openx_affiliate_id"><?php echo __( 'Affiliate (Sites) ID:', 'txt-dc-openx' ); ?></label></th>
                <td>
                    <input type="text" name="openx_affiliate_id" id="openx_affiliate_id" value="<?php echo $options_ox->openx_affiliate_id; ?>" class="regular-text">
                    <p class="howto">
                        <?php echo __( AFFILIATEID_HOWTO_TXT, 'txt-dc-openx' ); ?>
                    </p>
                </td>
            </tr>
            <tr><!-- URL -->
                <th><label for="openx_url"><?php echo __( 'Openx (Revive) URL:', 'txt-dc-openx' ); ?></label></th>
                <td>
                    <input type="text" name="openx_url" id="openx_url" value="<?php echo $options_ox->openx_url; ?>" class="regular-text">
                    <p class="howto"><?php echo __( '(eg.: http://youradserver.com.br)', 'txt-dc-openx' ); ?></p>
                </td>
            </tr>
        </table>
        <p><input type="submit" name="submit" id="submit" value="<?php echo __( 'Save settings', 'txt-dc-openx' ); ?>" class="button button-primary"></p>
    </form>
</div>

<?php
}
/**
 * Save Openx Settings
 * 
 * @since 1.0
 * 
 * @param array $options_ox $_Post var
 * @return boolean True or false in case of error
 */
function dccode_openx_save_settings( $options_ox = false ) {
    if( ! is_array( $options_ox ) || is_null( $options_ox ) )
        return false;
    
    $data = array();
    $data['openx_version'] = wp_strip_all_tags( $options_ox['openx_version'] );
    $data['openx_affiliate_id'] = wp_strip_all_tags( $options_ox['openx_affiliate_id'] );
    $data['openx_url'] = wp_strip_all_tags( $options_ox['openx_url'] );

    if( ! update_option( 'dccode-openx-settings', $data ) ) {
        return false;
    }
    return true;
}

/**
 * Return a list of Versions
 * 
 * @since 1.0 
 * 
 * @return array List of Versions.
 */
function dccode_openx_versions( $version = null ) {
    $list = array();
    $list[''] = '- version -';
    $list['322'] = '3.2.2';
    $list['321'] = '3.2.1';
    $list['320'] = '3.2.0';
    $list['310'] = '3.1.0';
    $list['306'] = '3.0.6';
    $list['305'] = '3.0.5';
    $list['304'] = '3.0.4';
    $list['303'] = '3.0.3';
    $list['302'] = '3.0.2';
    $list['301'] = '3.0.1';
    $list['300'] = '3.0.0';
    
    /**
     * Return version string.
     */
    if( ! is_null( $version ) && is_numeric( $version ) ) {
        $ver = absint( $version );
        return $list["{$ver}"];
    }
    /**
     * Return list of versions.
     */
    return $list;
}