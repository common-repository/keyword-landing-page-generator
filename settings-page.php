<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Add the settings menu link to the Settings menu in admin interface
 */
function wpsos_klpg_register_submenu_page() {
	add_submenu_page( 'wpsos-landing-page-generator', 'General', 'General', 'manage_options', 'admin.php?page=wpsos-landing-page-generator&tab=general' );
	add_submenu_page( 'wpsos-landing-page-generator', 'Keywords', 'Keywords', 'manage_options', 'admin.php?page=wpsos-landing-page-generator&tab=keywords' );
	add_submenu_page( 'wpsos-landing-page-generator', 'Instructions', 'Instructions', 'manage_options', 'admin.php?page=wpsos-landing-page-generator&tab=instructions' );
	add_submenu_page( 'wpsos-landing-page-generator', 'For Developers', 'For Developers', 'manage_options', 'admin.php?page=wpsos-landing-page-generator&tab=developers' );
	add_submenu_page( 'wpsos-landing-page-generator', 'Support', 'Support', 'manage_options', 'admin.php?page=wpsos-landing-page-generator&tab=support' );
}
add_action( 'admin_menu', 'wpsos_klpg_register_submenu_page' );

/**
 * Add a top level menu for Landing Page Generator
 */
function wpsos_klpg_add_settings_menu(){
	global $WPSOS_KLPG;
	//Create a new link to the settings menu
	//Returns the suffix of the page that can later be used in the actions etc
	$page = add_menu_page(
			'Landing Page Generator Settings', //name of the settings page
			'LP Generator',
			'manage_options',
			'wpsos-landing-page-generator',
			'wpsos_klpg_display_settings_page' //the function that is going to be called if the created page is loaded
	);
	
	//If a form was submitted
	if( isset( $_POST['wpsos-klpg-save']) ){
		//Add action to call save general settings
		add_action( "admin_head-$page", array( $WPSOS_KLPG, 'save_general_settings' ) );
	}
	else if ( isset( $_POST['wpsos_klpg_kw_modify'] ) ){
		add_action( "admin_head-$page", array( $WPSOS_KLPG, 'modify_keyword' ) );
	}
	else if( isset( $_POST['wpsos_klpg_generate_lp'] ) ){
		add_action( "admin_head-$page", array( $WPSOS_KLPG, 'generate_landing_page' ) );
	}
	else if( isset( $_POST['wpsos_klpg_disable_quickstart'] ) ){
		add_action( "admin_head-$page", array( $WPSOS_KLPG, 'disable_quickstart' ) );
	}
	else if (isset( $_POST['wpsos_klpg_dismiss_info'] ) ){
		add_action( "admin_head-$page", array( $WPSOS_KLPG, 'dismiss_quickstart_info' ) );
	}
}
add_action( 'admin_menu', 'wpsos_klpg_add_settings_menu' );

/**
 * Display the settings page in the admin interface
 */
function wpsos_klpg_display_settings_page(){
	global $WPSOS_KLPG;
	$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general';
	$settings = $WPSOS_KLPG->get_general_settings();
	$shortcode_keys = $WPSOS_KLPG->get_shortcode_keys();
	$lp_chosen = true;
	?>
		<div id="wpsos" class="wrap">
			<h1>Keyword Landing Page Generator</h1>
			<h2 class="nav-tab-wrapper">
			<?php foreach( $WPSOS_KLPG->tabs as $tab_key => $tab_caption ): ?>
        		<?php $active = $current_tab == $tab_key ? 'nav-tab-active' : ''; ?>
        		<a class="nav-tab <?php echo $active; ?>" href="?page=wpsos-landing-page-generator&tab=<?php echo $tab_key; ?>"><?php echo $tab_caption; ?></a>
    		<?php endforeach; ?>
    </h2>
   	<?php if( isset( $_SESSION['wpsos_msg'] ) ): ?>
				<div class="updated"><p><strong><?php echo esc_attr( $_SESSION['wpsos_msg'] ); unset( $_SESSION['wpsos_msg'] ); ?></strong></p></div>
			<?php endif; ?>
			<?php if( $settings['show_quickstart_info'] ): ?>
				<div class="updated"><p><?php echo $WPSOS_KLPG->get_quickstart_info(); ?></p>
				<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"><p><input class="submit" type="submit" name="wpsos_klpg_dismiss_info" value="<?php _e( 'Got it! Dismiss.', 'wpsos-klpg' ); ?>" /></p></form>
				</div>
			<?php endif; ?>
				<?php if( $settings['show_quickstart'] ): ?>
					<?php include_once( 'quickstart.tpl.php' ); ?>
				<?php endif; ?>
				<div class="form-wrapper">
					
					<?php $WPSOS_KLPG->landing_page_warning(); ?>
					<?php do_action( 'wpsos_klpg_before_settings_page' ); ?>
					<?php if( $current_tab == 'general' ): ?>
					<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
					<h3><?php _e( 'General Settings', 'wpsos-klpg' ); ?></h3>
					<table id="general" class="form-table">
						<tr>
							<th><?php _e( 'Landing Page Template page', 'wpsos-klpg' ) ?></th>
							<td>
								<select name="template">
									<option value=""><?php echo esc_attr( __( 'Select page', 'wpsos-klpg' ) ); ?></option>
									<?php 
									  $pages = get_pages(); 
									  foreach ( $pages as $page ): ?>
									  	<option value="<?php echo $page->ID; ?>"<?php echo $settings['template']==$page->ID ? ' selected':''; ?>><?php echo $page->post_title; ?>
										</option>
									  <?php endforeach; ?>
								</select>
								<p class="subnote"><?php _e( 'This is the page that displays the varying Landing Page contents according to the keyword.', 'wpsos-klpg' ); ?></p>
								<?php if( !$settings['template'] || !get_post( $settings['template'] ) ): ?>
									<?php $lp_chosen = false; ?>
									<p class="important subnote"><?php _e( 'No landing page has been selected; select one before continuing.' ); ?></a></p>
								<?php else: ?>
									<p class="subnote"><?php _e( 'The current Landing Page URL:', 'wpsos-klpg' ); ?> <a target="_blank" href="<?php echo get_permalink( $settings['template'] ); ?>"><?php echo get_permalink( $settings['template'] ); ?></a></p>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<th><?php _e( 'Templating system', 'wpsos-klpg' ); ?></th>
							<td>
								<label><input name="tpl-system" type="radio" value="default" <?php echo $settings['tpl-system'] == 'default' ? 'checked="checked"' : ''; ?> /><?php _e( 'Use a WordPress template for the landing page', 'wpsos-klpg' ); ?></label>
								<p class="subnote"><?php _e( 'When choosing this, the content of the selected page will be displayed. With the current settings, edit here:', 'wpsos-klpg' ); ?> <a target="_blank" href="<?php echo get_edit_post_link( $settings['template'] ); ?>"><?php echo get_edit_post_link( $settings['template'] ); ?></a>  <?php _e( 'You can use shortcodes in there.', 'wpsos-klpg' ); ?></p>
								
								<label><input name="tpl-system" type="radio" value="custom" <?php echo $settings['tpl-system'] == 'custom' ? 'checked="checked"' : ''; ?>/><?php _e( 'Use custom HTML for the landing page.' , 'wpsos-klpg' ); ?></label>
								<p class="subnote"><?php _e( 'Insert the custom HTML below. This will replace the whole page, including HTML head, etc. Any HTML that is currently used in the selected landing page' , 'wpsos-klpg' ); ?> <?php if( $lp_chosen ): ?>(<?php echo get_permalink( $settings['template'] ); ?>)<?php endif; ?> <?php _e( 'will be ignored, and over-written with this HTML below.', 'wpsos-klpg' ); ?></p>
							</td>				
						</tr>
						<tr>
							<th><?php _e( 'Insert your custom HTML here', 'wpsos-klpg' ); ?></th>
								<td>
									<textarea name="wpsos_klpg_custom_HTML"><?php echo html_entity_decode( stripslashes( esc_html( get_option( 'wpsos_klpg_custom_HTML' ) ) ), ENT_QUOTES );?></textarea>
									<p class="subnote"><?php _e( 'You can use shortcodes here for the keywords.', 'wpsos-klpg' ); ?></p>	
								</td>				
							</tr>
					</table>
					<p>
						<input class="submit" type="submit" value="<?php _e( 'Save', 'wpsos-klpg' ); ?>" name="wpsos-klpg-save">
					</p>
					</form>
				</div><!-- end .form-wrapper -->
				<?php endif; ?>
				<?php if( $current_tab == 'instructions' ): ?>
					<?php include_once( 'instructions.tpl.php' ); ?>
				<?php endif; ?>
				<?php if( $current_tab == 'keywords' ): ?>
				<h3>Shortcode settings</h3>
				<div class="form-wrapper">
					<h4><?php _e( 'Manage landing page shortcodes', 'wpsos-klpg' ); ?></h4>
					
					<p class="subnote"><?php _e( 'This influences all the existing keywords. These Shortcode Keys influence the fields in the second column of the below table named "Change existing Triggering Keywords"', 'wpsos-klpg' ); ?></p>
					<table class="form-table">
						<thead>
							<th><?php _e( 'Shortcode Key', 'wpsos-klpg' ); ?></th>
							<th><?php _e( 'Information', 'wpsos-klpg' ); ?><p class="subnote"><?php _e( 'To insert the corresponding text for this section into the page/template, use this shortcode:', 'wpsos-klpg' ); ?></p></th>
							<th></th>
						</thead>
						<?php foreach( $shortcode_keys as $i=>$key ): ?>
							<tr>
								<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
									<?php wp_nonce_field( "wpsos-hp-$key" ); ?>
									<td><?php echo esc_attr( $key ); ?></td>
									<td>[wpsos key="<?php echo esc_attr( $key ); ?>"]</td>
									<td><input class="remove" type="submit" disabled="disabled" value="Remove" /><p class="subnote">Removing a Shortcode Key is a premium option.<br/> <a target="_blank" href="http://www.wpsos.io/wordpress-plugin-keyword-landing-page-generator/">Get the plugin.</a></p></td>
									<input type="hidden" name="shortcode-key" value="<?php echo esc_attr( $key ); ?>" />
								</form>
							</tr>
						<?php endforeach; ?>
						</table>
						<form>
					</form>
				</div>
				<div class="form-wrapper">
					<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
						<table class="form-table">
							<tr>
								<?php wp_nonce_field( "wpsos-hp-shortcodes" ); ?>
								<th><?php _e( 'Add a new Shortcode Key', 'wpsos-klpg' ); ?></th>
								<td><input type="text" value="" placeholder="New shortcode here" disabled="disabled" /></td>			
							</tr>
						</table>
						<p class="subnote">Adding a new Shortcode Key is a premium option. <a target="_blank" href="http://www.wpsos.io/wordpress-plugin-keyword-landing-page-generator/">Get the plugin.</a></p>
						<p><input class="submit" type="submit" value="<?php _e( 'Save', 'wpsos-klpg' ); ?>" disabled="disabled" /></p>
					</form>
				</div>
				<div class="form-wrapper">
					<h3><?php _e( 'Change existing Triggering Keywords', 'wpsos-klpg' ); ?></h3>
					<p class="subnote"><?php _e( 'The Triggering Keyword is the phrase that is in the URL that will trigger one of the customized landing pages.', 'wpsos-klpg' ); ?></p>
					<table class="form-table" id="keywords">
					<thead>
						<th><?php _e( 'Triggering Keyword', 'wpsos-klpg' ); ?></th>
						<th><?php _e( 'Shortcode Key Configuration', 'wpsos-klpg' ); ?></th>
						<th></th>
					</thead>
					<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
					<?php $keywords=$WPSOS_KLPG->get_keywords(); ?>
					<?php $warning = 0; ?>
					<?php foreach( $shortcode_keys as $i=>$key ): ?>
						<?php if( !trim( $keywords['default'][$key] ) ): ?>
							<?php $warning = 1; break; ?>
						<?php endif; ?>
					<?php endforeach; ?>
						<tr><td><?php _e( 'Default', 'wpsos-klpg'); ?><br/><p class="important"><?php echo $warning ? __( 'One or more default values are not filled in, please fix!', 'wpsos-klpg' ) : ''; ?></p></td><td><a href="#" class="toggle-btn" id="default"><?php _e( 'Expand / Collapse' ); ?></a></td><td></td></tr>
						<tr id="toggle-default" class="toggle even">
							<td>
								<label><?php _e( 'Default', 'wpsos-klpg' ); ?></label>
								<p class="subnote"><?php _e( 'If there is no Triggering Keyword in the URL, or if the Triggering Keyword used was never defined, here is the default information that should be displayed for the shortcodes.', 'wpsos-klpg' ); ?></p>
							</td>
							<td>
								<?php foreach( $shortcode_keys as $i=>$key ): ?>
								<label><?php _e( 'Shortcode Key:', 'wpsos-klpg' ); ?> <strong><?php $key = trim( $key ); echo esc_attr( $key ); ?></strong>
									<textarea name="kw_content_<?php echo esc_attr( $key ); ?>" placeholder="Keyword content"><?php echo array_key_exists( 'default', $keywords ) && array_key_exists( $key, $keywords['default'] ) ? $keywords['default'][$key] : ''; ?></textarea>
								</label>
								<p class="subnote"><?php _e( 'Shortcode for this section:', 'wpsos-klpg' ); ?> [wpsos key="<?php echo esc_attr( $key ); ?>"]</p><br/>
								<?php endforeach; ?>
								<input class="submit" type="submit" value="<?php _e( 'Change keyword', 'wpsos-klpg' ); ?>" name="wpsos_klpg_kw_modify" />
								<input type="hidden" name="keyword" value="default" />
								<input name="kw_name" type="hidden" value="default" />
							</td>
							<td><p class="subnote"><?php _e( 'Default keyword can\'t be removed.', 'wpsos-klpg' ); ?></p></td>
						</tr>
					</form>
					<?php $j=1; ?>
					<?php foreach( $keywords as $k=>$v ): ?>
					<?php if( $k == 'default' ) continue; ?>
					<?php $j++; ?>
						<tr class="<?php echo $j%2 ? 'even' : 'odd'; ?>"><td><?php echo esc_attr( $k ); ?></td><td><a href="#" class="toggle-btn" id="<?php echo esc_attr( $k ); ?>"><?php _e( 'Expand / Collapse' ); ?></a></td><td></td></tr>
						<tr id="toggle-<?php echo esc_attr( $k ); ?>" class="toggle <?php echo $j%2 ? 'even' : 'odd'; ?>">
						<form method="post" class="toggle" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
						<?php wp_nonce_field( "wpsos-hp-$k" ); ?>
							<td>
								<label><?php _e( 'Name', 'wpsos-klpg' ); ?>: <input name="kw_name" type="text" value="<?php echo esc_attr( $k ); ?>" /></label>
								<p class="subnote"><?php _e( 'URL for this Triggering Keyword', 'wpsos-klpg' ); ?>: <a target="_blank" href="<?php echo get_permalink( $settings['template'] ) . esc_attr( $k ); ?>"><?php echo get_permalink( $settings['template'] ) . esc_attr( $k ); ?></a></p>
							</td>
							<td>
								<?php foreach( $shortcode_keys as $i=>$key ): ?>
								<label><?php _e( 'Shortcode Key', 'wpsos-klpg' ); ?>: <strong><?php $key = trim( $key ); echo esc_attr( $key ); ?></strong>
									<textarea name="kw_content_<?php echo esc_attr( $key ); ?>" placeholder="Keyword content"><?php if( isset( $keywords[$k] ) && isset( $keywords[$k][$key] ) ){ echo $keywords[$k][$key]; } ?></textarea>
								</label>
								<p class="subnote"><?php _e( 'Shortcode for this key', 'wpsos-klpg' ); ?>: [wpsos key="<?php echo esc_attr( $key ); ?>"]</p><br/>
								<?php endforeach; ?>
								<input class="submit" type="submit" value="<?php _e( 'Change keyword', 'wpsos-klpg' ); ?>" name="wpsos_klpg_kw_modify" />
							</td>
							<td>
								<input type="hidden" name="keyword" value="<?php echo $k; ?>" />
								<input class="remove" type="submit" value="<?php _e( 'Remove Keyword', 'wpsos-klpg' ); ?>" disabled="disabled" />
								<p class="subnote">Removing a Keyword is a premium option. <a target="_blank" href="http://www.wpsos.io/wordpress-plugin-keyword-landing-page-generator/">Get the plugin.</a></p>
							</td>
							</form>
						</tr>
					
					<?php endforeach; ?>	
					</table>
				</div>
				<div class="form-wrapper">
					<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
					<h3><?php _e( 'Add new Triggering Keyword', 'wpsos-klpg' ); ?></h3>
						<?php wp_nonce_field( 'wpsos-hp-add-keyword' ); ?>
						<table class="form-table">
							<tr>
								<th>
									<?php _e( 'Keyword', 'wpsos-klpg' ); ?>
								</th>
								<td><input disabled="disabled" type="text" /></td>
							</tr>	
						</table>
						<p class="subnote">Adding a new Triggering Keyword is a premium option. <a target="_blank" href="http://www.wpsos.io/wordpress-plugin-keyword-landing-page-generator/">Get the plugin.</a></p>
						<p>
							<input class="submit" type="submit" value="<?php _e( 'Add keyword', 'wpsos-klpg' ); ?>" disabled="disabled">
						</p>
					</form>
				</div>
				
			<?php endif; ?>
			<?php if( $current_tab == 'support' ): ?>
				<?php include_once( 'support.tpl.php' ); ?>
			<?php endif; ?>
			<?php if( $current_tab == 'developers' ): ?>
				<?php include_once( 'developers.tpl.php' ); ?>
			<?php endif; ?>
			<?php do_action( 'wpsos_klpg_after_settings_page' ); ?>
		</div>
	<?php
}
/**
 * Add links to WPSOS
 */
function wpsos_klpg_set_plugin_meta( $links, $file ) {

	if ( strpos( $file, 'keyword-landing-page-generator.php' ) !== false ) {

		$links = array_merge( $links, array( '<a href="' . get_admin_url() . 'options-general.php?page=wpsos-landing-page-generator">' . __( 'Settings', 'wpsos-klpg' ) . '</a>' ) );
		$links = array_merge( $links, array( '<a href="http://www.wpsos.io/">' . __( 'WPSOS - WordPress Security & Hack Repair' ) . '</a>' ) );
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'wpsos_klpg_set_plugin_meta', 10, 2 );
?>