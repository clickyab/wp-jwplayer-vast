<?php
/**
 * Plugin Name: JW Player 7 Vast for Wordpress (Clickyab)
 * Description:  JW Player 7 VAST/VPaid for Wordpress width clickyab ADs.
 * Do you want more? Please check out the premium version.
 * Author: Clickyab
 * Version: 1.0.0
 * Author URI: http://clickyab.com
 */


//HEY, WHAT ARE UOU DOING?
if ( !defined( 'ABSPATH' ) ) exit;

add_action( 'plugins_loaded', 'jwppp_load', 100 );	

function jwppp_load() {

	//DATABASE UPDATE
	if(get_option('jwppp-database-version') < '1.1.1') {
		global $wpdb;
		$wpdb->query(
			"
			UPDATE $wpdb->postmeta
			SET meta_key = CASE meta_key
			WHEN '_jwppp-video-url' THEN '_jwppp-video-url-1'
			WHEN '_jwppp-clickyab-plugin-url' THEN '_jwppp-clickyab-plugin-url-1'
			WHEN '_jwppp-clickyab-vast-url-js' THEN '_jwppp-clickyab-vast-url-js-1'
			WHEN '_jwppp-video-image' THEN '_jwppp-video-image-1'
			WHEN '_jwppp-video-title' THEN '_jwppp-video-title-1'
			WHEN '_jwppp-video-description' THEN '_jwppp-video-description-1'
			WHEN '_jwppp-single-embed' THEN '_jwppp-single-embed-1'
			WHEN '_jwppp-add-chapters' THEN '_jwppp-add-chapters-1'
			WHEN '_jwppp-chapters-number' THEN '_jwppp-chapters-number-1'
			ELSE meta_key
			END
			"
		);

		$wpdb->query(
			"
			UPDATE $wpdb->postmeta SET
			meta_key = REPLACE(meta_key, '_jwppp-chapter-', '_jwppp-1-chapter-')
			"
		);

		//UPDATE DATABASE VERSION
		update_option('jwppp-database-version', '1.1.2');
	}
	
	//INTERNATIONALIZATION


function plugin_name_load_plugin_textdomain() {
    $domain = 'jwppp';
    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
    // wp-content/languages/plugin-name/plugin-name-de_DE.mo
    load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
    // wp-content/plugins/plugin-name/languages/plugin-name-de_DE.mo
    load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'plugin_name_load_plugin_textdomain' );

	//FILES REQUIRED
	include( plugin_dir_path( __FILE__ ) . 'includes/jwppp-admin.php');
	include( plugin_dir_path( __FILE__ ) . 'includes/jwppp-functions.php');
}