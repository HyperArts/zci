<?php
/*******************************************************************************
 * Copyright (c) 2018, WP Popup Maker
 ******************************************************************************/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_LN_Site
 */
class PUM_LN_Site {

	/**
	 *
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'assets' ) );
		add_filter( 'pum_generated_js', array( __CLASS__, 'generated_js' ) );
		add_filter( 'pum_generated_css', array( __CLASS__, 'generated_css' ) );
		add_action( 'pum_preload_popup', array( __CLASS__, 'enqueue_popup_assets' ) );
	}

	/**
	 *
	 */
	public static function assets() {
		if ( ! PUM_AssetCache::enabled() ) {
			wp_register_script( 'pum-ln', PUM_LN::$URL . 'assets/js/pum-ln-site' . PUM_Site_Assets::$suffix . '.js', array( 'popup-maker-site' ), PUM_LN::$VER, true );
			wp_register_style( 'pum-ln', PUM_LN::$URL . 'assets/css/pum-ln-site' . PUM_Site_Assets::$suffix . '.css', array( 'popup-maker-site' ), PUM_LN::$VER );
		}
	}

	/**
	 * @param array $js
	 *
	 * @return array
	 */
	public static function generated_js( $js = array() ) {
		$js['ln'] = array(
			'content'  => file_get_contents( PUM_LN::$DIR . '/assets/js/pum-ln-site' . PUM_Site_Assets::$suffix . '.js' ),
			'priority' => 5,
		);

		return $js;
	}

	/**
	 * @param array $css
	 *
	 * @return array
	 */
	public static function generated_css( $css = array() ) {
		$css['ln'] = array(
			'content'  => file_get_contents( PUM_LN::$DIR . '/assets/css/pum-ln-site' . PUM_Site_Assets::$suffix . '.css' ),
			'priority' => 5,
		);

		return $css;
	}

	/**
	 * @param int $popup_id
	 */
	public static function enqueue_popup_assets( $popup_id = 0 ) {
		$popup = pum_get_popup( $popup_id );

		if ( ! pum_is_popup( $popup ) ) {
			return;
		}

		if ( PUM_LN_Popup::ln_enabled( $popup ) ) {
			wp_enqueue_script( 'pum-ln' );
			wp_enqueue_style( 'pum-ln' );
		}
	}

}
