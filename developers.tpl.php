<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div id="developers">
	<div class="form-wrapper">
		<h3><?php _e( 'Which filters/actions can be used with the plugin?', 'wpsos-klpg' ); ?></h3>
		<h4><?php _e( 'Filters', 'wpsos-klpg' ); ?></h4>
		<ul>
			<li><strong>'wpsos_klpg_shortcode_text'</strong> - <?php _e( 'filters the shortcode text value right before displaying.', 'wpsos-klpg' ); ?></li>
			<li><strong>'wpsos_klpg_custom_content'</strong> - <?php _e( 'filters the custom HTML text configured from ', 'wpsos-klpg' ); ?><a href="admin.php?page=wpsos-landing-page-generator&tab=general">General Settings</a> <?php _e( 'right before displaying to the user.', 'wpsos-klpg' ); ?></li>
		</ul>
		<h4>Actions</h4>
		<ul>
			<li><strong>'wpsos_klpg_before_custom_content'</strong> - <?php _e( 'before displaying the custom HTML text configured from', 'wpsos-klpg' ); ?> <a href="admin.php?page=wpsos-landing-page-generator&tab=general">General Settings</a> <?php _e( 'for the user.', 'wpsos-klpg' ); ?></li>
			<li><strong>'wpsos_klpg_after_custom_content'</strong> - <?php _e( 'after displaying the custom HTML text configured from ', 'wpsos-klpg' ); ?><a href="admin.php?page=wpsos-landing-page-generator&tab=general">General Settings</a> <?php _e( 'for the user.', 'wpsos-klpg' ); ?></li>
			<li><strong>'wpsos_klpg_before_settings_page'</strong> - <?php _e( 'before displaying the settings page in admin UI.', 'wpsos-klpg' ); ?></li>
			<li><strong>'wpsos_klpg_after_settings_page'</strong> - <?php _e( 'after displaying the settings page in admin UI.', 'wpsos-klpg' ); ?></li>
		</ul>	
	</div>
	<div class="form-wrapper">
		<h3><?php _e( 'Using your custom PHP template.', 'wpsos-klpg' ); ?></h3>
		<p><?php _e( 'If you prefer using a custom WordPress template for using the Triggering Keywords and their values, here is the way to go', 'wpsos-klpg' ); ?>:</p>
		<ol>
			<li><?php _e( 'Create a WordPress template file under your theme.', 'wpsos-klpg' ); ?> </li>
			<li><?php _e( 'Load the existing', 'wpsos-klpg' ); ?> <a href="admin.php?page=wpsos-landing-page-generator&tab=shortcodes">Shortcode Keys</a> <?php _e( 'and their values into a array. For that, you can use the global object $WPSOS_KLPG and it\'s class method \'get_keyword_values\'. The class method takes one parameter, the keyword. The keyword is accessible via the query_var called \'wpsos_mkey\'.', 'wpsos-klpg' ); ?></li>
			<li><?php _e( 'Using the received array, you can display the values of the Triggering Keyword from the URL, with the Shortcode Keys as the array keys, configured under the ', 'wpsos-klpg' ); ?><a href="admin.php?page=wpsos-landing-page-generator&tab=shortcodes">Shortcodes Settings</a>.</li>
			<li><?php _e( 'Create a page and choose the new template for the created page.', 'wpsos-klpg' ); ?></li>
			<li><?php _e( 'Flush the permalinks by going to the', 'wpsos-klpg' ); ?> <a href="options-permalink.php">Permalinks settings</a> <?php _e( 'and clicking ', 'wpsos-klpg' ); ?>'Save'</li>
		</ol>
	</div>	
	<div class="form-wrapper">
		<h3><?php _e( 'Sample code when using your own template.', 'wpsos-klpg' ); ?></h3>
		<p><?php _e( 'Here below is a sample code to show how to use the keys in your own template.', 'wpsos-klpg' ); ?></p>
		<pre>
		...
		/** Template Name: Keyword Landing Page Generator **/
		get_header();
		...
		global $WPSOS_KLPG;
		//Check if the method exists
		if( method_exists( $WPSOS_KLPG, 'get_keyword_values' ) ){
			//Take the set array by the key value from the query vars, load 'default' if not found
			$key_array = $WPSOS_KLPG->get_keyword_values( get_query_var( 'wpsos_mkey', 'default' ) );
		}
		else {
			//Otherwise load an empty array
			$key_array = array();
		}
		...
		//Display the corresponding text of 'main-heading' configured under the Shortcode Settings
		echo $key_array['main-heading'];
		...
		//Display the corresponding text of 'content' configured under the Shortcode Settings
		echo $key_array['content'];
		//Your content
		...
		</pre>
	</div>
</div>