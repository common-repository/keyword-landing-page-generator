<?php
/**
 * Main class for the Keyword Landing Page Generator plugin
 * @package wpsos-klpg
 * @version 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WPSOS_KLPG {
	
	public $tabs;
	public $settings;
	
	function __construct(){
		add_shortcode( 'wpsos', array( $this, 'add_keyword_shortcodes') );
		$this->settings = $this->get_general_settings();
		if( !is_admin() && $this->settings['tpl-system'] == 'custom' ){
			$this->add_page_content_filter();
		}
		if( is_admin() ){
			
		}
		$this->tabs = array(
				"general"	=> "General Settings",
				"keywords"	=> "Keywords",
				"instructions"	=> "Instructions",
				"developers"	=> "For Developers",
				"support"	=> "Support"
		);
	}
	
	function landing_page_warning(){
		if( !$this->settings['template'] || !get_post( $this->settings['template'] ) ){
			echo '<div class="lp warning"><h4>Important!</h4>You need to choose a Landing Page for the plugin to work.
				Please configure the "Landing Page Template page" option under the <a href="admin.php?page=wpsos-landing-page-generator&tab=general">General Settings</a> tab or follow the instructions under the <a href="admin.php?page=wpsos-landing-page-generator&tab=instructions">Instructions tab</a>.</div>';
		}	
	}
	
	/**
	 * Add a filter to display custom HTML instead of the page content
	 */
	function add_page_content_filter(){
		add_filter( 'template_redirect', function(){
			global $post;
			if( $post->ID == $this->settings['template'] ){
				$custom_content = html_entity_decode( stripslashes( get_option( 'wpsos_klpg_custom_HTML' ) ), ENT_QUOTES );
				$custom_content = do_shortcode( $custom_content );
				
				do_action( 'wpsos_klpg_before_custom_content' );
				
				echo apply_filters( 'wpsos_klpg_custom_content', $custom_content );
				
				do_action( 'wpsos_klpg_after_custom_content' );
				die();
			}
		});}
	
	/**
	 * Add a new keyword
	 * @return boolean If success
	 */
	function add_keyword(){
		$_SESSION['wpsos_msg']=__( 'Adding keyword is a premium plugin feature.', 'wpsos-klpg' );
		return false;
	}
	
	/**
	 * Change an existing keyword
	 * @return boolean Return true if success
	 */
	function modify_keyword(){
		$keywords = $this->get_keywords();
		$shortcode_keys = $this->get_shortcode_keys();
		//If user has admin permissions
		if( current_user_can( 'manage_options' ) ){
			$values = array();
			foreach( $shortcode_keys as $v ){
				if( isset( $_POST['kw_content_'.$v] ) ){
					$values[$v]=wp_kses_post( ( $_POST['kw_content_'.$v] ));
				}
			}
			$name = sanitize_text_field( $_POST['kw_name'] );
			$kw = sanitize_text_field( $_POST['keyword'] );
			if( $name != $kw ){
				unset( $keywords[$kw] );				
			}
			$keywords[$name] = $values;
			update_option( 'wpsos_klpg_keywords', serialize( $keywords) );
			$_SESSION['wpsos_msg']=__( 'Keywords changed.', 'wpsos-klpg' );
			return true;
		}
		$_SESSION['wpsos_msg']=__( 'Something went wrong. Please try again.', 'wpsos-klpg' );
	}
	
	/**
	 * Remove an existing keyword
	 * @return boolean If success
	 */
	function remove_keyword(){
		$_SESSION['wpsos_msg']=__( 'Removing keyword is a premium plugin feature.', 'wpsos-klpg' );
		return false;
	}
	
	/**
	 * Save general settings: which page to use, which template system to use,
	 * custom HTML content
	 */
	function save_general_settings(){
		// wpsos_klpg_settings
		// wpsos_klpg_custom_HTML
		$flush = false;
		if( isset( $_POST['template'] ) ){
			if( $this->settings['template'] != $_POST['template'] ){
				$this->settings['template'] = sanitize_text_field( $_POST['template'] );
				$flush = true;
			}
		}
		if( isset( $_POST['tpl-system'] ) ){
			$this->settings['tpl-system'] = sanitize_text_field( $_POST['tpl-system'] );
		}
		
		update_option( 'wpsos_klpg_settings', serialize( $this->settings ) );
		
		if( isset( $_POST['wpsos_klpg_custom_HTML'] ) ){
			$content=esc_attr( $_POST['wpsos_klpg_custom_HTML'] );
			update_option( 'wpsos_klpg_custom_HTML', $content);
		}
		// If the rewrite rules need flushing
		if( $flush ){
			wpsos_klpg_rewrite_rules();
			flush_rewrite_rules();
		}
		$_SESSION['wpsos_msg']=__( 'Settings saved.', 'wpsos-klpg' );
	}
	
	/**
	 * Get the general settings as array
	 * @return mixed
	 */
	function get_general_settings(){
		$settings = get_option( 'wpsos_klpg_settings' );
		return unserialize( $settings );
	}
	
	/**
	 * Add a shortcode key
	 */
	function add_shortcode_key(){
	}
	
	/**
	 * Remove shortcode key, and the value that are related to that key
	 * @return boolean
	 */
	function remove_shortcode_key(){
		return false;
	}
	
	/**
	 * Register scripts used in the plugin
	 */
	function register_plugin_scripts(){
		wp_enqueue_style( 'wpsos-klpg-style', plugin_dir_url( WPSOS_KLPG_FILE ) . 'css/style.css' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'wpsos-klpg-script', plugin_dir_url( WPSOS_KLPG_FILE ) . 'js/script.js', array( 'jquery' ) );
	}
	
	/**
	 * Get all existing keywords
	 * @return mixed
	 */
	function get_keywords(){
		// wpsos_klpg_keywords
		$keywords = unserialize( get_option( 'wpsos_klpg_keywords' ) );
		if( !$keywords )
			$keywords = array();
		
		return apply_filters( 'wpsos_klpg_all_keywords', $keywords );
	}
	
	/**
	 * Get values of one keyword
	 * @param string $keyword
	 * @return array Array of the values of the keyword
	 */
	function get_keyword_values( $keyword ){
		$kws = $this->get_keywords();
		$kw_values = $kws[$keyword];
		if(empty($kw_values)){
			$kw_values = $kws['default'];
		}
		return apply_filters( 'wpsos_klpg_keyword_values', $kw_values );
	}
	
	function get_shortcode_keys( $format='string' ){
		if( !is_array( $this->settings['shortcodes'] ) ){
			return array();
		}
		return $this->settings['shortcodes'];
	}
	
	/**
	 * Add the wpsos shortcode with key attribute
	 * @param array $atts
	 * @return mixed
	 */
	function add_keyword_shortcodes( $atts ){
		$keywords = $this->get_keywords();
		$a = shortcode_atts( array(
				'key' => 'default',
		), $atts );
		
		if( isset( $keywords[get_query_var( 'wpsos_mkey' )] ) && isset( $keywords[get_query_var( 'wpsos_mkey' )][$a['key']] ) )
			$text = html_entity_decode($keywords[get_query_var( 'wpsos_mkey' )][$a['key']]);
		else if( isset( $keywords['default'][$a['key']] ) ){
			$text = $keywords['default'][$a['key']];
		}
		else {
			$text = '';
		}

		return apply_filters( 'wpsos_klpg_shortcode_text', $text );
	}
	
	/**
	 * Generates a default landing page with already predefined content and keywords
	 */
	function generate_landing_page(){
		global $current_user;
		
		$page['post_type']    = 'page';
		$page['post_content'] = '<p>Welcome to the Keyword Landing Page Generator plugin!</p><h2>[wpsos key="main-heading"]</h2><br/>[wpsos key="content"]<p>Thank you for visiting our page. Please contact us with any questions.</p>';
		$page['post_parent']  = 0;
		$page['post_author']  = $current_user->ID;
		$page['post_status']  = 'publish';
		$page['post_title']   = 'KLPG Landing Page';
		$page = apply_filters( 'wpsos_klpg_quickstart_landing_page', $page );
		$pageid = wp_insert_post ($page);
		if ($pageid == 0) {
			$_SESSION['wpsos_msg']=__( 'Something went wrong. Please try again.', 'wpsos-klpg' );
			return false;
		}
		else {
			$this->settings['template'] = $pageid;
			$this->settings['show_quickstart'] = 0;
			$this->settings['tpl-system'] = 'default';
			update_option( 'wpsos_klpg_settings', serialize( $this->settings ) );
			wpsos_klpg_rewrite_rules();
			flush_rewrite_rules();
			$this->settings['show_quickstart_info'] = 1;
			update_option( 'wpsos_klpg_settings', serialize( $this->settings ) );
		}
	}
	
	/**
	 * Get the message to display after generating a quick start landing page
	 * @return string
	 */
	function get_quickstart_info(){
		$msg = 'A landing page has been created — congrats!<br/><br/>';
		$msg.= 'You can edit this page via the standard WordPress page screen, here: <a href="'.get_edit_post_link( $this->settings['template'] ).'">'.get_edit_post_link( $this->settings['template'] ).'</a><br/><br/>';
		$msg.= 'To see some variations of the page automatically created, just look at these pages:';
		$keywords = $this->get_keywords();
		foreach( $keywords as $k=>$v ){
			if( $k == 'default' ) continue;
			$msg.= '<br/><a target="_blank" href="'.get_permalink( $this->settings['template'] ) . $k . '">'. get_permalink( $this->settings['template'] ) . $k .'</a>';
		}
		$msg.= '<br/><br/>To edit the content that changes on each version of the landing page, just click on the <a href="?page=wpsos-landing-page-generator&tab=keywords">‘Keywords’</a> menu and edit the Triggering Keywords there. Or to add in other, new pages, just add new Triggering Keywords from the same page. (Adding Triggering Keywords is a premium option. <a target="_blank" href="http://www.wpsos.io/wordpress-plugin-keyword-landing-page-generator/">Get the plugin.</a>)';
		return $msg;
	}
	
	/**
	 * Dismiss the information generated by the quick start langing page
	 */
	function dismiss_quickstart_info(){
		$this->settings['show_quickstart_info'] = 0;
		update_option( 'wpsos_klpg_settings', serialize( $this->settings ) );
	}
	
	/**
	 * Disable showing quick start
	 */
	function disable_quickstart(){
		$this->settings['show_quickstart'] = 0;
		update_option( 'wpsos_klpg_settings', serialize( $this->settings ) );
	}
	
	/**
	 * On plugin activation
	 */
	function activate(){
		//Pre populate everything
		$this->settings = array( 'show_quickstart_info' => 0, 'show_quickstart' => 1, 'template' => '', 'tpl-system' => 'default', 'shortcodes' => array( 'main-heading', 'content' ) );
		add_option( 'wpsos_klpg_settings', serialize( $this->settings ) );
		
		$content='<!DOCTYPE html><html><body><h1>[wpsos key="main-heading"]</h1><p>[wpsos key="content"]</p></body></html>';
		add_option( 'wpsos_klpg_custom_HTML', $content);
		
		$keywords = array(
				'default' => array(
						'main-heading' => '',
						'content' => ''
				),
				'fast' => array( 
						'main-heading' => 'The fastest marketing plugin.',
						'content' => 'Get our fastest landing page generator to boost your ads conversion'
				),
				'high-quality' => array(
						'main-heading' => 'The highest quality marketing plugin.',
						'content' => 'Get our highest quality landing page generator to boost your ads conversion'
				),
		);
		add_option( 'wpsos_klpg_keywords', serialize( $keywords ) );
		
	}
	
	/**
	 * On plugin deactivation
	 */
	function deactivate(){
		//Flush the rewrite rules on deactivation
		flush_rewrite_rules();
	}
}
?>
