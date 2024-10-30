<?php
/*
 Plugin Name: Keyword Landing Page Generator (Free)
 Plugin URI: http://www.wpsos.io/wordpress-plugin-keyword-landing-page-generator/
 Description: Keyword Landing Page Generator allows you to have one landing page, with different versions (at different URLs) depending on the keyword -- so you can show each visitor a customized version of the landing page!
 Text-Domain: wpsos-klpg
 Author: WPSOS
 Version: 1.01
 Author URI: http://www.wpsos.io/
 Licence: GPLv2 or later
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
define('WPSOS_KLPG_FILE', __FILE__);
/**
 * Rewrite rules for the Keyword Landing Page Generator
 */
function wpsos_klpg_rewrite_rules(){
	$s = unserialize( get_option( 'wpsos_klpg_settings' ) );
	if( $s['template'] ){
	$page = get_page( $s['template'] )->post_name;
		add_rewrite_rule(
				'^'.$page.'/([^/]+)/?$',
				'index.php?pagename='.$page.'&wpsos_mkey=$matches[1]',
				'top'
		);
	}
}
add_action( 'init', 'wpsos_klpg_rewrite_rules' );

//Require the plugin files
require_once( dirname(__FILE__) . '/class.klpg.php' );
require_once( dirname(__FILE__) . '/settings-page.php' );

//Create global object
global $WPSOS_KLPG;
$WPSOS_KLPG = new WPSOS_KLPG();

//Register activation/deactivation functions
register_activation_hook( __FILE__, array( $WPSOS_KLPG, 'activate' ) );
register_deactivation_hook( __FILE__, array( $WPSOS_KLPG, 'deactivate' ) );

if( is_admin() ){
	//Register plugin scripts
	add_action( 'admin_enqueue_scripts', array( $WPSOS_KLPG, 'register_plugin_scripts' ) );
}

/**
 * Adds custom query variables
 *
 * @param Array $qv Current query variables
 * @return Array Array of the new query variables
 */
function wpsos_klpg_query_vars( $qv ) {
	$qv[] = 'wpsos_mkey';
	return $qv;
}
add_filter( 'query_vars', 'wpsos_klpg_query_vars' );
