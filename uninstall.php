<?php
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_option( 'wpsos_klpg_settings' );
delete_option( 'wpsos_klpg_custom_HTML' );
delete_option( 'wpsos_klpg_keywords' );
?>