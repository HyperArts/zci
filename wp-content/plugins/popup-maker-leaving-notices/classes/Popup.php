<?php
/*******************************************************************************
 * Copyright (c) 2018, WP Popup Maker
 ******************************************************************************/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_LN_Popup
 */
class PUM_LN_Popup {

	/**
	 *
	 */
	public static function init() {
		add_filter( 'pum_popup_classes', array( __CLASS__, 'classes' ), 10, 2 );
	}

	/**
	 * @param $popup
	 *
	 * @return bool
	 */
	public static function ln_enabled( $popup ) {
		if ( is_numeric( $popup ) ) {
			$popup = pum_get_popup( $popup );
		}

		if ( ! pum_is_popup( $popup ) ) {
			return false;
		}

		$tests = array(
			has_shortcode( $popup->post_content, 'pum_continue_link' ),
			has_shortcode( $popup->post_content, 'continue_link' ),
		);

		return in_array( true, $tests );
	}

	/**
	 * @param array $classes
	 * @param int   $popup_id
	 *
	 * @return array
	 */
	public static function classes( $classes, $popup_id ) {
		if ( self::ln_enabled( $popup_id ) ) {
			$classes['overlay'][] = 'leaving-notice';
		}

		return $classes;
	}
}
