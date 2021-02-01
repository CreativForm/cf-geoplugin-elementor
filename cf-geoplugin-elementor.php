<?php
/**
 * @wordpress-plugin
 * Plugin Name:       WordPress Geo Plugin Elementor extension
 * Plugin URI:        http://cfgeoplugin.com/
 * Description:       WordPress Geo Plugin Elementor extension
 * Version:           1.0.0
 * Author:            INFINITUM FORM
 * Author URI:        https://infinitumform.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cf-geoplugin-elementor
 * Domain Path:       /languages
 * Network:           true
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
 
 // If someone try to called this file directly via URL, abort.
if ( ! defined( 'WPINC' ) ) { die( "Don't mess with us." ); }
if ( ! defined( 'ABSPATH' ) ) { exit; }
// Find is localhost or not
if ( ! defined( 'CFGP_LOCAL' ) ) {
	if(isset($_SERVER['REMOTE_ADDR'])) {
		define('CFGP_LOCAL', in_array($_SERVER['REMOTE_ADDR'], array(
			'127.0.0.1',
			'::1'
		)));
	} else {
		define('CFGP_LOCAL', false);
	}
}

/**
 * DEBUG MODE
 *
 * This is need for plugin debugging.
 */
if ( defined( 'WP_DEBUG' ) ){
	if(WP_DEBUG === true || WP_DEBUG === 1)
	{
		if ( ! defined( 'WP_CF_GEO_DEBUG' ) ) define( 'WP_CF_GEO_DEBUG', true );
	}
}
if ( defined( 'WP_CF_GEO_DEBUG' ) ){
	if(WP_CF_GEO_DEBUG === true || WP_CF_GEO_DEBUG === 1)
	{
		error_reporting( E_ALL );
		if(function_exists('ini_set'))
		{
			ini_set('display_startup_errors',1);
			ini_set('display_errors',1);
		}
	}
}

// Find wp-admin file path
if ( strrpos(WP_CONTENT_DIR, '/wp-content/', 1) !== false) {
    $WP_ADMIN_DIR = substr(WP_CONTENT_DIR, 0, -10) . 'wp-admin';
} else {
    $WP_ADMIN_DIR = substr(WP_CONTENT_DIR, 0, -11) . '/wp-admin';
}
if (!defined('WP_ADMIN_DIR')) define('WP_ADMIN_DIR', $WP_ADMIN_DIR);

if(file_exists(WP_PLUGIN_DIR . '/cf-geoplugin'))
{
	// Main Plugin root
	if ( ! defined( 'CFGP_ROOT' ) )		define( 'CFGP_ROOT', WP_PLUGIN_DIR . '/cf-geoplugin' );
	// Main plugin file
	if ( ! defined( 'CFGP_FILE' ) )		define( 'CFGP_FILE', CFGP_ROOT . '/cf-geoplugin.php' );
} else {
	// Main Plugin root
	if ( ! defined( 'CFGP_ROOT' ) )		define( 'CFGP_ROOT', WP_CONTENT_DIR . '/plugins/cf-geoplugin' );
	// Main plugin file
	if ( ! defined( 'CFGP_FILE' ) )		define( 'CFGP_FILE', CFGP_ROOT . '/cf-geoplugin.php' );
}
// Current plugin version ( if change, clear also session cache )
$cfgp_version = NULL;
if(file_exists(CFGP_FILE))
{
	if(function_exists('get_file_data') && $plugin_data = get_file_data( CFGP_FILE, array('Version' => 'Version'), false ))
		$cfgp_version = $plugin_data['Version'];
	if(!$cfgp_version && preg_match('/\*[\s\t]+?version:[\s\t]+?([0-9.]+)/i',file_get_contents( CFGP_FILE ), $v))
		$cfgp_version = $v[1];
}
if ( ! defined( 'CFGP_VERSION' ) )		define( 'CFGP_VERSION', $cfgp_version);
// Main website
if ( ! defined( 'CFGP_STORE' ) )		define( 'CFGP_STORE', 'https://cfgeoplugin.com');

// Includes directory
if ( ! defined( 'CFGP_INCLUDES' ) )		define( 'CFGP_INCLUDES', CFGP_ROOT . '/includes' );
// Main plugin name
if ( ! defined( 'CFGP_NAME' ) )			define( 'CFGP_NAME', 'cf-geoplugin');
// Plugin session prefix (controlled by version)
if ( ! defined( 'CFGP_PREFIX' ) )		define( 'CFGP_PREFIX', 'cf_geo_'.preg_replace("/[^0-9]/Ui",'',CFGP_VERSION).'_');

// Plugin file
if ( ! defined( 'CFGPE_FILE' ) )		define( 'CFGPE_FILE', __FILE__ );
// Plugin root
if ( ! defined( 'CFGPE_ROOT' ) )		define( 'CFGPE_ROOT', rtrim(plugin_dir_path(CFGPE_FILE), '/') );
// Plugin URL root
if ( ! defined( 'CFGPE_URL' ) )			define( 'CFGPE_URL', rtrim(plugin_dir_url( CFGPE_FILE ), '/') );
// Plugin URL root
if ( ! defined( 'CFGPE_ASSETS' ) )		define( 'CFGPE_ASSETS', CFGPE_URL . '/assets' );
// Timestamp
if( ! defined( 'CFGPE_TIME' ) )			define( 'CFGPE_TIME', time() );
// Session
if( ! defined( 'CFGPE_SESSION' ) )		define( 'CFGPE_SESSION', 15 );
// Includes directory
if ( ! defined( 'CFGPE_INC' ) )			define( 'CFGPE_INC', CFGPE_ROOT . '/inc' );
// Plugin name
if ( ! defined( 'CFGPE_NAME' ) )		define( 'CFGPE_NAME', 'cf-geoplugin-elementor');
$cfgp_gps_version = NULL;
if(function_exists('get_file_data') && $plugin_data = get_file_data( CFGPE_FILE, array('Version' => 'Version'), false ))
	$cfgp_gps_version = $plugin_data['Version'];
if(!$cfgp_gps_version && preg_match('/\*[\s\t]+?version:[\s\t]+?([0-9.]+)/i',file_get_contents( CFGPE_FILE ), $v))
	$cfgp_gps_version = $v[1];
if ( ! defined( 'CFGPE_VERSION' ) )		define( 'CFGPE_VERSION', $cfgp_gps_version);

// Check if is multisite installation
if( ! defined( 'CFGP_MULTISITE' ) && defined( 'WP_ALLOW_MULTISITE' ) && WP_ALLOW_MULTISITE && defined( 'MULTISITE' ) && MULTISITE )			
{
	define( 'CFGP_MULTISITE', WP_ALLOW_MULTISITE );
}

if( ! defined( 'CFGP_MULTISITE' ) )			
{
    // New safer approach
    if( !function_exists( 'is_plugin_active_for_network' ) )
		include_once WP_ADMIN_DIR . '/includes/plugin.php';

	if(file_exists(WP_ADMIN_DIR . '/includes/plugin.php'))
		define( 'CFGP_MULTISITE', is_plugin_active_for_network( CFGP_ROOT . '/cf-geoplugin-gps.php' ) );
}

if( ! defined( 'CFGP_MULTISITE' ) ) define( 'CFGP_MULTISITE', false );

include_once CFGPE_INC . '/Requirements.php';

/*
 * Main global classes with active hooks
 * @since     1.0.0
 * @verson    1.0.0
 */
if(!class_exists('CFGPE_Global')) :
class CFGPE_Global{
	
	private static $__instance = NULL;
	
	/*
	 * Decode content
	 * @return        string
	 * @author        Ivijan-Stefan Stipic
	*/
	public function decode($content){
		$content = rawurldecode($content);
		$content = htmlspecialchars_decode($content);
		$content = html_entity_decode($content);
		$content = strtr($content, array_flip(get_html_translation_table(HTML_ENTITIES, ENT_QUOTES)));
		return $content;
	}
	
	/*
	 * Hook for register_uninstall_hook()
	 * @author        Ivijan-Stefan Stipic
	*/
	public static function register_uninstall_hook($function){
		return register_uninstall_hook( RSTR_FILE, $function );
	}
	
	/*
	 * Hook for register_deactivation_hook()
	 * @author        Ivijan-Stefan Stipic
	*/
	public static function register_deactivation_hook($function){
		return register_deactivation_hook( RSTR_FILE, $function );
	}
	
	/*
	 * Hook for register_activation_hook()
	 * @author        Ivijan-Stefan Stipic
	*/
	public static function register_activation_hook($function){
		return register_activation_hook( RSTR_FILE, $function );
	}
	/* 
	 * Hook for add_action()
	 * @author        Ivijan-Stefan Stipic
	*/
	public function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1){
		if(!is_array($function_to_add)) {
			$function_to_add = array(&$this, $function_to_add);
		}
		return add_action( (string)$tag, $function_to_add, (int)$priority, (int)$accepted_args );
	}
	
	/* 
	 * Hook for remove_action()
	 * @author        Ivijan-Stefan Stipic
	*/
	public function remove_action($tag, $function_to_remove, $priority = 10){
		if(!is_array($function_to_remove))
			$function_to_remove = array(&$this, $function_to_remove);
			
		return remove_action( $tag, $function_to_remove, $priority );
	}
	
	/* 
	 * Hook for add_filter()
	 * @author        Ivijan-Stefan Stipic
	*/
	public function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1){
		if(!is_array($function_to_add))
			$function_to_add = array(&$this, $function_to_add);
			
		return add_filter( (string)$tag, $function_to_add, (int)$priority, (int)$accepted_args );
	}
	
	/* 
	 * Hook for remove_filter()
	 * @author        Ivijan-Stefan Stipic
	*/
	public function remove_filter($tag, $function_to_remove, $priority = 10){
		if(!is_array($function_to_remove))
			$function_to_remove = array(&$this, $function_to_remove);
			
		return remove_filter( (string)$tag, $function_to_remove, (int)$priority );
	}
	
	/* 
	 * Hook for add_shortcode()
	 * @author        Ivijan-Stefan Stipic
	*/
	public function add_shortcode($tag, $function_to_add){
		if(!is_array($function_to_add))
			$function_to_add = array(&$this, $function_to_add);
		
		if(!shortcode_exists($tag)) {
			return add_shortcode( $tag, $function_to_add );
		}
		
		return false;
	}
	
	/* 
	 * Hook for add_options_page()
	 * @author        Ivijan-Stefan Stipic
	*/
	public function add_options_page($page_title, $menu_title, $capability, $menu_slug, $function = '', $position = null){
		if(!is_array($function))
			$function = array(&$this, $function);
		
		return add_options_page($page_title, $menu_title, $capability, $menu_slug, $function, $position);
	}
	
	/* 
	 * Hook for add_settings_section()
	 * @author        Ivijan-Stefan Stipic
	*/
	public function add_settings_section($id, $title, $callback, $page){
		if(!is_array($callback))
			$callback = array(&$this, $callback);
		
		return add_settings_section($id, $title, $callback, $page);
	}
	
	/* 
	 * Hook for register_setting()
	 * @author        Ivijan-Stefan Stipic
	*/
	public function register_setting($option_group, $option_name, $args = array()){
		if(!is_array($args) && is_callable($args))
			$args = array(&$this, $args);
		
		return register_setting($option_group, $option_name, $args);
	}
	
	/* 
	 * Hook for add_settings_field()
	 * @author        Ivijan-Stefan Stipic
	*/
	public function add_settings_field($id, $title, $callback, $page, $section = 'default', $args = array()){
		if(!is_array($callback))
			$callback = array(&$this, $callback);
		
		return add_settings_field($id, $title, $callback, $page, $section, $args);
	}
	
	/* 
	 * Generate unique token
	 * @author        Ivijan-Stefan Stipic
	*/
	public static function generate_token($length=16){
		if(function_exists('openssl_random_pseudo_bytes') || function_exists('random_bytes'))
		{
			if (version_compare(PHP_VERSION, '7.0.0', '>='))
				return substr(str_rot13(bin2hex(random_bytes(ceil($length * 2)))), 0, $length);
			else
				return substr(str_rot13(bin2hex(openssl_random_pseudo_bytes(ceil($length * 2)))), 0, $length);
		}
		else
		{
			return substr(str_replace(array('.',' ','_'),mt_rand(1000,9999),uniqid('t'.microtime())), 0, $length);
		}
	}
	
	/*
	 * Return plugin informations
	 * @return        array/object
	 * @author        Ivijan-Stefan Stipic
	*/
	function plugin_info($fields = array()) {
        if ( is_admin() ) {
			if ( ! function_exists( 'plugins_api' ) ) {
				include_once( WP_ADMIN_DIR . '/includes/plugin-install.php' );
			}
			/** Prepare our query */
			//donate_link
			//versions
			$plugin_data = plugins_api( 'plugin_information', array(
				'slug' => RSTR_NAME,
				'fields' => array_merge(array(
					'active_installs' => false,           // rounded int
					'added' => false,                     // date
					'author' => false,                    // a href html
					'author_block_count' => false,        // int
					'author_block_rating' => false,       // int
					'author_profile' => false,            // url
					'banners' => false,                   // array( [low], [high] )
					'compatibility' => false,            // empty array?
					'contributors' => false,              // array( array( [profile], [avatar], [display_name] )
					'description' => false,              // string
					'donate_link' => false,               // url
					'download_link' => false,             // url
					'downloaded' => false,               // int
					// 'group' => false,                 // n/a 
					'homepage' => false,                  // url
					'icons' => false,                    // array( [1x] url, [2x] url )
					'last_updated' => false,              // datetime
					'name' => false,                      // string
					'num_ratings' => false,               // int
					'rating' => false,                    // int
					'ratings' => false,                   // array( [5..0] )
					'requires' => false,                  // version string
					'requires_php' => false,              // version string
					// 'reviews' => false,               // n/a, part of 'sections'
					'screenshots' => false,               // array( array( [src],  ) )
					'sections' => false,                  // array( [description], [installation], [changelog], [reviews], ...)
					'short_description' => false,        // string
					'slug' => false,                      // string
					'support_threads' => false,           // int
					'support_threads_resolved' => false,  // int
					'tags' => false,                      // array( )
					'tested' => false,                    // version string
					'version' => false,                   // version string
					'versions' => false,                  // array( [version] url )
				), $fields)
			));
		 
			return $plugin_data;
		}
    }
	
	/*
	 * Set cookie
	 * @since     1.0.0
	 * @verson    1.0.0
	*/
	public function setcookie ($val){
		if( !headers_sent() ) {
			setcookie( 'rstr_script', $val, (time()+YEAR_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN );
			
			if(get_rstr_option('cache-support', 'yes') == 'yes') {
				$this->cache_flush();
			}
		}
	}
	
	/*
	 * Flush Cache
	 * @verson    1.0.0
	*/
	public function cache_flush () {
		global $post, $user;
		
		// Standard cache
		header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		if(function_exists('nocache_headers')) {
			nocache_headers();
		}
		
		// Flush WP cache
		if (function_exists('w3tc_flush_all')) {
			wp_cache_flush();
		}
		
		// W3 Total Cache
		if (function_exists('w3tc_flush_all')) {
			w3tc_flush_all();
		}
		
		// WP Fastest Cache
		if (function_exists('wpfc_clear_all_cache')) {
			wpfc_clear_all_cache(true);
		}
		
		// Clean stanrad WP cache
		if($post && function_exists('clean_post_cache')) {
			clean_post_cache( $post );
		}
		
		if($user && function_exists('clean_post_cache')) {
			clean_user_cache( $user );
		}
	}
	
	
	/*
	 * Get current URL
	 * @since     1.0.0
	 * @verson    1.0.0
	*/
	public function get_current_url()
	{
		global $wp;
		return add_query_arg( array(), home_url( $wp->request ) );
	}
	
	/**
	 * Parse URL
	 * @since     1.0.0
	 * @verson    1.0.0
	 */
	public function parse_url(){
		if(null === $this->_url_parsed) {
			$http = 'http'.( $this->is_ssl() ?'s':'');
			$domain = preg_replace('%:/{3,}%i','://',rtrim($http,'/').'://'.$_SERVER['HTTP_HOST']);
			$domain = rtrim($domain,'/');
			$url = preg_replace('%:/{3,}%i','://',$domain.'/'.(isset($_SERVER['REQUEST_URI']) && !empty( $_SERVER['REQUEST_URI'] ) ? ltrim($_SERVER['REQUEST_URI'], '/'): ''));
				
			$this->_url_parsed = array(
				'method'	=>	$http,
				'home_fold'	=>	str_replace($domain,'',home_url()),
				'url'		=>	$url,
				'domain'	=>	$domain,
			);
		}
		
		return $this->_url_parsed;
	}
	
	/*
	 * CHECK IS SSL
	 * @return	true/false
	 */
	public function is_ssl($url = false)
	{
		if($url !== false && is_string($url)) {
			return (preg_match('/(https|ftps)/Ui', $url) !== false);
		} else if( is_admin() && defined('FORCE_SSL_ADMIN') && FORCE_SSL_ADMIN ===true ) {
			return true;
		} else {
			if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
				return true;
			else if(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
				return true;
			else if(!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')
				return true;
			else if(isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
				return true;
			else if(isset($_SERVER['HTTP_X_FORWARDED_PORT']) && $_SERVER['HTTP_X_FORWARDED_PORT'] == 443)
				return true;
			else if(isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https')
				return true;
		}
		return false;
	}
	
	/* 
	* Check is block editor screen
	* @since     1.0.0
	* @verson    1.0.0
	*/
	public function is_editor()
	{
		if (version_compare(get_bloginfo( 'version' ), '5.0', '>=')) {
			if(!function_exists('get_current_screen')){
				include_once ABSPATH  . '/wp-admin/includes/screen.php';
			}
			$get_current_screen = get_current_screen();
			if(is_callable(array($get_current_screen, 'is_block_editor')) && method_exists($get_current_screen, 'is_block_editor')) {
				return $get_current_screen->is_block_editor();
			}
		} else {
			return ( isset($_GET['action']) && isset($_GET['post']) && $_GET['action'] == 'edit' && is_numeric($_GET['post']) );
		}
		
		return false;
	}
	
	/* 
	* Instance
	* @since     1.0.0
	* @verson    1.0.0
	*/
	public static function __instance()
	{
		if ( is_null( self::$__instance ) ) {
			self::$__instance = new self();
		}
		return self::$__instance;
	}
}
endif;

/* 
* Elementor class
* @since     1.0.0
* @verson    1.0.0
*/
if( !class_exists( 'CF_Geoplugin_Elementor' ) ):
class CF_Geoplugin_Elementor extends CFGPE_Global{
	
	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '3.0';
	const MINIMUM_PHP_VERSION = '7.0';
	
	private static $__inst = null;
	
	function __construct(){
		$this->add_action( 'plugins_loaded', 'init' );
	//	$this->add_filter( 'single_template', 'add_custom_single_template', 99 );
	}
	
	public static function instance() {

		if ( is_null( self::$__inst ) ) {
			self::$__inst = new self();
		}
		return self::$__inst;

	}
	
	public function init() {
		// Check for required Elementor version
		if(defined('ELEMENTOR_VERSION')) {
			if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				$this->add_action( 'admin_notices', 'admin_notice_minimum_elementor_version' );
				return;
			}
		}
		
		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			$this->add_action( 'admin_notices', 'admin_notice_minimum_php_version' );
			return;
		}

		$this->add_action( 'elementor/elements/categories_registered', 'add_categories' );
		$this->add_action( 'elementor/widgets/widgets_registered', 'load_widgets');
		/* UNDERCONSTRUCTION */
	//	$this->add_action( 'elementor/controls/controls_registered', 'add_controls' );
	}
	
	function add_custom_single_template( $template ) {
	/*	if( $this->get_post_type('btn-recipes') && file_exists(__DIR__ . '/page/page.php') ){
			$template = __DIR__ . '/page/page.php';
		}	*/
		return $template;
	}
	
	function is_editor(){
		return ((isset($_REQUEST['action']) && isset($_REQUEST['post']) && $_REQUEST['action'] == 'elementor' && absint($_REQUEST['post']) > 0) || isset($_GET['elementor-preview']));
	}
	
	function add_categories( $elements_manager ) {

		$elements_manager->add_category(
			'geoplugin-addons',
			[
				'title' => __( 'CF Geoplugin Addons', CFGPE_NAME ),
				'icon' => 'fa fas fa-globe-europe',
			]
		);
	}
	
	function add_controls(){
		$controls = __DIR__ . '/controls';
		$fileSystemIterator = new FilesystemIterator($controls);
		foreach ($fileSystemIterator as $control_file)
		{
			// Find all controls
			$filename = $control_file->getFilename();
			if(preg_match('~cfgpe-(.*?)-control~i', $filename))
			{
				// Generate widget file path
				$file = "{$controls}/{$filename}";
				// Load widget
				if(file_exists($file))
				{
					include_once $file;
					// Translate class name
					$class_name = str_replace('.php', '', $filename);
					$class_name = explode('-', $class_name);
					$class_name = array_map('trim', $class_name);
					$class_name = array_map('ucfirst', $class_name);
					$class_name[0] = strtoupper($class_name[0]);
					$class_name = join('_', $class_name);

					// Include class
					if(class_exists($class_name))
					{
						// Let Elementor know about our widget
						\Elementor\Plugin::$instance->controls_manager->register_control( 'control-type-', new $class_name() );
					}
				}
			}
		}
	}
	
	function load_widgets(){
		$widgets = __DIR__ . '/widgets';
		$fileSystemIterator = new FilesystemIterator($widgets);
		foreach ($fileSystemIterator as $widget_file)
		{
			// Find all widgets
			$filename = $widget_file->getFilename();
			if(preg_match('~cfgpe-(.*?)-widget~i', $filename))
			{
				// Generate widget file path
				$file = "{$widgets}/{$filename}";
				if(file_exists($file))
				{
					// Load widget
					include_once $file;
					// Translate class name
					$class_name = str_replace('.php', '', $filename);
					$class_name = explode('-', $class_name);
					$class_name = array_map('trim', $class_name);
					$class_name = array_map('ucfirst', $class_name);
					$class_name[0] = strtoupper($class_name[0]);
					$class_name = join('_', $class_name);
					
					// Include class
					if(class_exists($class_name))
					{
						// Let Elementor know about our widget
						\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );
					}
				}
			}
		}
	}
	

	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', CFGPE_NAME ),
			'<strong>' . esc_html__( 'BTN Recipe', CFGPE_NAME ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', CFGPE_NAME ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
	
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', CFGPE_NAME ),
			'<strong>' . esc_html__( 'BTN Recipe', CFGPE_NAME ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', CFGPE_NAME ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
}
endif;

CF_Geoplugin_Elementor::instance();