<?php
/*******************************************************************************
 * Copyright (c) 2018, WP Popup Maker
 ******************************************************************************/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles processing of data migration & upgrade routines.
 *
 * @since 1.1.0
 */
class PUM_LN_Upgrades {

	/**
	 * @var PUM_Upgrades
	 */
	public static $instance;

	/**
	 * Popup Maker version.
	 *
	 * @var    string
	 */
	private $version;

	/**
	 * Popup Maker version.
	 *
	 * @var    string
	 */
	private $db_version;

	/**
	 * Popup Maker upgraded from version.
	 *
	 * @var    string
	 */
	private $upgraded_from;

	/**
	 * Popup Maker initial version.
	 *
	 * @var    string
	 */
	private $initial_version;

	public static function init() {
		self::instance();
	}

	/**
	 * Gets everything going with a singleton instance.
	 *
	 * @return PUM_Upgrades
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Sets up the Upgrades class instance.
	 */
	public function __construct() {
		// Update stored plugin version info.
		$this->update_plugin_version();

		add_action( 'pum_register_upgrades', array( $this, 'register_processes' ) );
	}

	/**
	 * Update version info.
	 */
	public function update_plugin_version() {
		$this->version         = get_option( 'pum_ln_ver' );
		$this->db_version      = get_option( 'pum_ln_db_ver', false );
		$this->upgraded_from   = get_option( 'pum_ln_ver_upgraded_from' );
		$this->initial_version = get_option( 'pum_ln_initial_version' );

		/**
		 * If no version set check if a deprecated one exists.
		 */
		if ( empty( $this->version ) ) {
			$deprecated_ver = get_site_option( 'popmake_leaving_notices_version', false );
			// set to the deprecated version or last version that didn't have the version option set
			$this->version = $deprecated_ver ? $deprecated_ver : PUM_LN::$VER; // Since we had versioning in v1 if there isn't one stored its a new install.
		}

		/**
		 * Back fill the initial version with the oldest version we can detect.
		 */
		if ( ! get_option( 'pum_ln_initial_version' ) ) {

			$oldest_known = PUM_LN::$VER;

			if ( $this->version && version_compare( $this->version, $oldest_known, '<' ) ) {
				$oldest_known = $this->version;
			}

			if ( $this->upgraded_from && version_compare( $this->upgraded_from, $oldest_known, '<' ) ) {
				$oldest_known = $this->upgraded_from;
			}

			if ( get_site_option( 'popmake_leaving_notices_version', false ) && version_compare( '1.1.0', $oldest_known, '<' ) ) {
				$oldest_known = '1.1.0';
			}

			$this->initial_version = $oldest_known;

			// Only set this value if it doesn't exist.
			update_option( 'pum_ln_initial_version', $oldest_known );
		}

		if ( version_compare( $this->version, PUM_LN::$VER, '<' ) ) {
			// Allow processing of small core upgrades
			do_action( 'pum_update_ln_version', $this->version );

			// Save Upgraded From option
			update_option( 'pum_ln_ver_upgraded_from', $this->version );
			update_option( 'pum_ln_ver', PUM_LN::$VER );
			$this->upgraded_from = $this->version;
			$this->version       = PUM_LN::$VER;

			// Reset popup asset cache on update.
			PUM_AssetCache::reset_cache();
		}

		if ( ! $this->db_version ) {
			// If no updated install then this is fresh, no need to do anything.
			if ( ! $this->upgraded_from ) {
				$this->db_version = PUM_LN::$DB_VER;
			} else {
				if ( version_compare( '1.0.2', $this->upgraded_from, '>=' ) ) {
					$this->db_version = 1;
				}
			}

			update_option( 'pum_ln_db_ver', $this->db_version );
		}
	}

	/**
	 * @return bool
	 */
	public function has_popups_needing_v1_1_upgrade() {
		if ( pum_has_completed_upgrade( 'ln-v1_1-popups' ) ) {
			return false;
		}

		$needs_upgrade = get_transient( 'pum_ln_needs_1_1_upgrades' );

		if ( $needs_upgrade === false ) {
			global $wpdb;
			$needs_upgrade = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(DISTINCT(post_id)) FROM $wpdb->postmeta WHERE meta_key = %s", 'popup_leaving_notices_enabled' ) );
		}

		if ( $needs_upgrade <= 0 ) {
			pum_set_upgrade_complete( 'ln-v1_1-popups' );
			delete_transient( 'pum_ln_needs_1_1_upgrades' );
			return false;
		}

		set_transient( 'pum_ln_needs_1_1_upgrades', $needs_upgrade );

		return (bool) $needs_upgrade;
	}

	/**
	 * @param PUM_Upgrade_Registry $registry
	 */
	public function register_processes( PUM_Upgrade_Registry $registry ) {
		// v1.1 Upgrades
		$registry->add_upgrade( 'ln-v1_1-popups', array(
			'rules' => array(
				$this->has_popups_needing_v1_1_upgrade(),
			),
			'class' => 'PUM_LN_Upgrade_v1_1_Popups',
			'file'  => PUM_LN::$DIR . 'includes/upgrades/class-upgrade-v1_1-popups.php',
		) );
	}

}
