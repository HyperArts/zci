<?php
/*******************************************************************************
 * Copyright (c) 2018, WP Popup Maker
 ******************************************************************************/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Implements a batch processor for migrating existing popups to new data structure.
 *
 * @since 1.1.0
 *
 * @see   PUM_Abstract_Upgrade_Popups
 */
class PUM_LN_Upgrade_v1_1_Popups extends PUM_Abstract_Upgrade_Popups {

	/**
	 * Batch process ID.
	 *
	 * @var    string
	 */
	public $batch_id = 'ln-v1_1-popups';

	/**
	 * Only load popups with specific meta keys.r
	 *
	 * @return array
	 */
	public function custom_query_args() {
		return array(
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key'     => 'popup_leaving_notices_enabled',
					'compare' => 'EXISTS',
				),
			),
		);
	}

	/**
	 * Strips out prefixes.
	 *
	 * @param PUM_Model_Popup $popup
	 *
	 * @return array
	 */
	public function get_old_meta( $popup ) {
		$defaults = array(
			'enabled'      => null,
			'text'         => __( 'Continue', 'popup-maker-leaving-notices' ),
			'target_blank' => false,
			'defaults_set' => true,
		);

		$data = array();

		foreach ( $defaults as $key => $value ) {
			$old_value    = $popup->get_meta( 'popup_leaving_notices_' . $key );
			$data[ $key ] = ! empty( $old_value ) ? $old_value : $value;
		}

		return $data;
	}

	/**
	 * @param $content
	 *
	 * @return array
	 */
	public function get_shortcodes_from_content( $content ) {
		$pattern    = get_shortcode_regex();
		$shortcodes = array();
		if ( preg_match_all( '/' . $pattern . '/s', $content, $matches ) ) {
			foreach ( $matches[0] as $key => $value ) {
				$shortcodes[ $key ] = array(
					'full_text' => $value,
					'tag'       => $matches[2][ $key ],
					'atts'      => shortcode_parse_atts( $matches[3][ $key ] ),
					'content'   => $matches[5][ $key ],
				);

				if ( ! empty( $shortcodes[ $key ]['atts'] ) ) {
					foreach ( $shortcodes[ $key ]['atts'] as $attr_name => $attr_value ) {
						// Filter numeric keys as they are valueless/truthy attributes.
						if ( is_numeric( $attr_name ) ) {
							$shortcodes[ $key ]['atts'][ $attr_value ] = true;
							unset( $shortcodes[ $key ]['atts'] );
						}
					}
				}
			}
		}

		return $shortcodes;
	}

	/**
	 * Process needed upgrades on each popup.
	 *
	 * @param int $popup_id
	 */
	public function process_popup( $popup_id = 0 ) {

		$popup = pum_get_popup( $popup_id );

		$ln = $this->get_old_meta( $popup );

		if ( ! $ln || empty( $ln['enabled'] ) || ! $ln['enabled'] ) {
			return;
		}

		$shortcode_atts = array();

		$shortcode_atts['text']         = $ln['text'];
		$shortcode_atts['target_blank'] = (bool) $ln['target_blank'];

		$new_shortcode_atts = array();

		if ( ! empty( $shortcode_atts ) ) {
			foreach ( $shortcode_atts as $key => $value ) {
				if ( $value === true ) {
					$new_shortcode_atts[] = $key;
				} else {
					$new_shortcode_atts[] = $key . '="' . $value . '"';
				}
			}
		}

		/** @var $new_shortcode_prefix string  Everything except the final ] */
		$new_shortcode_prefix = "[pum_continue_link " . implode( ' ', $new_shortcode_atts ) . " ";

		if ( has_shortcode( $popup->post_content, 'continue_link' ) ) {
			$popup->post_content = str_replace( "[continue_link", $new_shortcode_prefix, $popup->post_content );
		} else {
			$popup->post_content .= $new_shortcode_prefix . ']';
		}

		$popup->update_meta( 'pum_ln_data_ver', 2 );
		$popup->save();
		$this->clean_up_old_meta( $popup_id );
	}

	/**
	 * @param int $popup_id
	 */
	public function clean_up_old_meta( $popup_id = 0 ) {
		global $wpdb;

		$meta_keys = implode( "','", array(
			'popup_leaving_notices_defaults_set',
			'popup_leaving_notices_text',
			'popup_leaving_notices_target_blank',
			'popup_leaving_notices_enabled',
		) );

		$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE post_id = " . (int) $popup_id . " AND meta_key IN('$meta_keys');" );
	}


	/**
	 *
	 */
	public function finish() {
	}
}
