<?php
/**
 * Plugin Name:     Popup Maker - Leaving Notices
 * Plugin URI:      https://wppopupmaker.com/extensions/leaving-notices/
 * Description:     Quickly create leaving notices to warn your users they are about to leave your site via external links.
 * Version:         1.1.2
 * Author:          WP Popup Maker
 * Author URI:      https://wppopupmaker.com/
 * Text Domain:     popup-maker-leaving-notices
 *
 * @author       WP Popup Maker
 * @copyright    Copyright (c) 2018, WP Popup Maker
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_LN
 */
class PUM_LN {

	/**
	 * @var int $download_id for EDD.
	 */
	public static $ID = 47223;

	/**
	 * @var string
	 */
	public static $NAME = 'Leaving Notices';

	/**
	 * @var string Plugin Version
	 */
	public static $VER = '1.1.2';

	/**
	 * @var string Required Version of Popup Maker
	 */
	public static $REQUIRED_CORE_VER = '1.7.29';

	/**
	 * @var int DB Version
	 */
	public static $DB_VER = 2;

	/**
	 * @var string Plugin Directory
	 */
	public static $DIR;

	/**
	 * @var string Plugin URL
	 */
	public static $URL;

	/**
	 * @var string Plugin FILE
	 */
	public static $FILE;

	/**
	 * @var self $instance
	 */
	private static $instance;

	/**
	 * @return self
	 */
	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
			self::$instance->setup_constants();
			self::$instance->load_textdomain();
			self::$instance->includes();
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Set up plugin constants.
	 */
	public function setup_constants() {
		self::$DIR  = plugin_dir_path( __FILE__ );
		self::$URL  = plugin_dir_url( __FILE__ );
		self::$FILE = __FILE__;

		define( 'POPMAKE_LEAVINGNOTICES_VER', self::$VER );
		define( 'POPMAKE_LEAVINGNOTICES_DIR', self::$DIR );
		define( 'POPMAKE_LEAVINGNOTICES_URL', self::$URL );

	}

	/**
	 * Internationalization
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'popup-maker-leaving-notices', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Include required files
	 */
	private function includes() {
	}

	/**
	 * Initialize the plugin.
	 */
	private function init() {
		PUM_LN_Site::init();
		PUM_LN_Admin::init();
		PUM_LN_Popup::init();
		PUM_LN_Shortcode_ContinueLink::init();
		PUM_LN_Upgrades::init();
	}

}

/**
 * Register this extensions autoload parameters to the pum_autoloaders array.
 *
 * @param array $autoloaders
 *
 * @return array
 */
function pum_ln_autoloader( $autoloaders = array() ) {
	return array_merge( $autoloaders, array(
		array(
			'prefix' => 'PUM_LN_',
			'dir'    => dirname( __FILE__ ) . '/classes/',
		),
	) );
}

add_filter( 'pum_autoloaders', 'pum_ln_autoloader' );

/**
 * Get the ball rolling.
 */
function pum_ln_init() {
	if ( ! class_exists( 'PUM_Extension_Activator' ) ) {
		require_once 'includes/pum-sdk/class-pum-extension-activator.php';
	}

	$activator = new PUM_Extension_Activator( 'PUM_LN' );
	$activator->run();
}

add_action( 'plugins_loaded', 'pum_ln_init', 11 );

if ( ! class_exists( 'PUM_LN_Activator' ) ) {
	require_once 'classes/Activator.php';
}
register_activation_hook( __FILE__, 'PUM_LN_Activator::activate' );

if ( ! class_exists( 'PUM_LN_Deactivator' ) ) {
	require_once 'classes/Deactivator.php';
}
register_deactivation_hook( __FILE__, 'PUM_LN_Deactivator::deactivate' );
