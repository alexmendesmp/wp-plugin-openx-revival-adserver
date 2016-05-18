<?php
/**
 * WIDGET INIT 
 */
add_action( 'widgets_init', 'dccode_adserver_register_widgets' );
function dccode_adserver_register_widgets() {
    register_widget( 'Dccode_Widget_Adserver' );
}
/**
 * AdServer OpenX | Revival Widget.
 * 
 * @since 1.0
 */
class Dccode_Widget_Adserver extends WP_Widget {

	public function __construct() {
                $widget_ops = array( 'classname' => '', 'description' => __( 'Add Banner From AdServer OpenX/Revive', 'txt-dc-openx' ) );
                $control_ops = array( 'width' => 'auto', 'height' => 'auto' );
                $rand = floor( rand( 0, 9 ) * 999999 );
                parent::__construct( 'ads_widget_banner', __( 'DCCode OpenX/Revive Banners', 'txt-dc-openx' ), $widget_ops, $control_ops );
                $this->zoneid_howto_txt();
	}

	public function widget( $args, $instance ) {
                extract( $args );
                $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'] );
                $zoneid = $instance['zoneid'];
                
                echo $before_widget;
                if( ! empty( $title ) ) {
                    echo $before_title . $title . $after_title;
                }
                $n = substr( md5( floor( rand( 0, 9 ) * 9999999 ) ), 0, 7 );
                // THE BANNER.
                do_action( 'do_openx_the_banner', $zoneid, 10, 1 );
                echo $after_widget;
                // Automatically adds paragraph tag
                // if checkbox is selected.
                if( $instance['add_p'] ) echo '<p>&nbsp;</p>';
	}

	public function form( $instance ) {
                $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
                $form['description'] = $instance['description'];
                $form['zoneid'] = $instance['zoneid'];
                $form['add_p'] = $instance['add_p'];
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'txt-dc-openx' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'zoneid' ); ?>"><?php echo __( 'Zone ID:', 'txt-dc-openx' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'zoneid' ); ?>" name="<?php echo $this->get_field_name( 'zoneid' ); ?>" type="text" value="<?php echo esc_attr( $form['zoneid'] ); ?>">
		</p>
                <p class="howto">
                    <?php echo __( ZONEID_HOWTO_TXT, 'txt-dc-openx' ); ?>
                </p>
		<p>
		<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php echo __( 'Description:', 'txt-dc-openx' ); ?></label> 
                <textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" rows="5"><?php echo esc_textarea( wp_strip_all_tags( $form['description'] ) ); ?></textarea>
		</p>
                <p>
                    <input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'add_p' ); ?>" name="<?php echo $this->get_field_name( 'add_p' ); ?>" value="1" <?php echo ($form['add_p'])?'checked':'' ?>> 
                    <label for="<?php $this->get_field_id( 'add_p' ); ?>"><?php echo __( 'Automatically adds paragraph.', 'txt-dc-openx' ); ?></label>
                </p>
                <p>
                <h3><?php echo __( 'Banner preview', 'txt-dc-openx' ); ?></h3>
                <div class="banner-placeholder-preview">
                    <?php if( isset( $form['zoneid'] ) || ! empty( $form['zoneid'] ) || (int) $form['zoneid'] > 0 ) : ?>
                            <?php $this->call_banner_directly_dhtml( $form['zoneid'] ); ?>
                            <!--<input type="button" class="button button-primary" onclick="javascript:OX_Show_Banner()" />-->
                    <?php endif; ?>    
                </div>
                </p>
		<?php             
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
                $zoneid = strip_tags( $new_instance['zoneid'] );
                $instance['title'] = strip_tags( $new_instance['title'] );
                $instance['zoneid'] = ( is_numeric( $zoneid ) ) ? $zoneid : '0';
                $instance['description'] = strip_tags( $new_instance['description'] );
                $instance['add_p'] = $new_instance['add_p'];
                return $instance;
	}
        
        /**
         * This function registers a sidebar for tests.
         * 
         * @since 1.0
         */
        public function register_widget_area() {
            register_sidebar(array(
                'name'          => __( 'OpenX - Test Area', 'txt-dc-openx' ),
                'id'            => 'openx-test-area-id',
                'description'   => __( 'Use this area to test your ads before drag and drop to target/production sidebar.', 'txt-dc-openx' ),
                'before_widget' => '<li id="%1$s" class="widget %2$s">',
                'after_widget'  => '</li>',
                'before_title'  => '<h2 class="widgettitle">',
                'after_title'   => '</h2>'
            ));
        }
        
        public function call_banner_directly_dhtml( $zoneid = '0' ) {
            ?>
            <iframe id='aaf2a764' name='aaf2a764' src='<?php echo DCCODE_OPENX_URL; ?>/www/delivery/afr.php?zoneid=<?php echo $zoneid; ?>&amp;target=_blank' frameborder='0' scrolling='yes' width="100%" height="100%">
            <a href='<?php echo DCCODE_OPENX_URL; ?>/www/delivery/ck.php?n=a9e8c948' target='_blank'>
                <img src='<?php echo DCCODE_OPENX_URL; ?>/www/delivery/avw.php?zoneid=<?php echo $zoneid; ?>&amp;log=no&amp;n=a9e8c948' border='0' alt='' />
            </a>
            </iframe>
            <?php
        }
        /**
         * How to find ZONE ID.
         * 
         * @since 1.0
         */
        public function zoneid_howto_txt() {
            define( 
                    'ZONEID_HOWTO_TXT', 
                     'Where to find Zone ID? <br />'
                    .'1. Log in your Openx/Revive account. <br />'
                    .'2. Go to Inventory -> Websites -> Zones -> and click on the name of the zone.<br />'
                    .'3. Search for (zoneid=) in your Browser Address Bar.'
            );            
        }
}