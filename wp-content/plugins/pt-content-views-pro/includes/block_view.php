<?php

// Bring Block layouts/patterns to View

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'PT_CV_BlockToView_Pro' ) ) {

	class PT_CV_BlockToView_Pro {

		static function hybrid_hooks() {
			add_filter( PT_CV_PREFIX_ . 'hybrid_layouts', array( __CLASS__, 'filter_hybrid_layouts' ), 11 );
			add_filter( PT_CV_PREFIX_ . 'set_atts_from_view', array( __CLASS__, 'filter_set_atts_from_view' ), 10, 3 );
			add_filter( PT_CV_PREFIX_ . 'set_atts_to_view', array( __CLASS__, 'filter_set_atts_to_view' ), 10, 4 );

			add_filter( PT_CV_PREFIX_ . 'exclude_block_show_field', array( __CLASS__, 'filter_exclude_block_show_field' ) );

			add_filter( PT_CV_PREFIX_ . 'localize_hybrid', array( __CLASS__, 'filter_localize_hybrid' ) );
			add_filter( PT_CV_PREFIX_ . 'old_overlay_enable', array( __CLASS__, 'filter_old_feature_enable' ) );
			add_filter( PT_CV_PREFIX_ . 'old_samesize_enable', array( __CLASS__, 'filter_old_feature_enable' ) );
		}

		static function filter_hybrid_layouts( $args ) {
			$args = PT_CV_Values_Pro::hybrid_layouts();
			return $args;
		}

		static function filter_set_atts_from_view( $final_atts, $args, $block_name ) {
			$_prefix = PT_CV_PREFIX . $block_name . '-';

			$final_atts[ 'whichLayout' ]	 = isset( $args[ $_prefix . 'layout-variant' ] ) ? $args[ $_prefix . 'layout-variant' ] : 'layout1';
			$final_atts[ 'swapPosition' ]	 = isset( $args[ PT_CV_PREFIX . 'swapPosition' ] ) ? $args[ PT_CV_PREFIX . 'swapPosition' ] : '';
			$final_atts[ 'oneWidth' ]		 = isset( $args[ PT_CV_PREFIX . 'oneWidth' ] ) ? $args[ PT_CV_PREFIX . 'oneWidth' ] : '';

			if ( in_array( $block_name, PT_CV_Values::ovl_layouts() ) ) {
				$final_atts[ 'hetargetHeight' ] = (object) [ 'md' => $args[ PT_CV_PREFIX . 'hetargetHeight' ] ];

				foreach ( [ 'overlayType', 'overlaid', 'overOnHover' ] as $field ) {
					$final_atts[ $field ] = isset( $args[ PT_CV_PREFIX . $field ] ) ? $args[ PT_CV_PREFIX . $field ] : '';
				}

				if ( !empty( $args[ PT_CV_PREFIX . 'overlay-gradient' ] ) ) {
					$final_atts[ 'overlayGradient' ] = $args[ PT_CV_PREFIX . 'overlay-gradient' ];
				}
			}

			return $final_atts;
		}

		static function filter_set_atts_to_view( $args, $block_atts, $block_name, $importing ) {
			if ( $importing && method_exists( 'ContentViews_Block', 'get_fields' ) ) {
				$fields		 = ContentViews_Block::get_fields();
				$style_arr	 = ContentViews_Block::style_options();
				$style_keys	 = array_merge( $style_arr[ 'string' ], $style_arr[ 'object' ] );

				// Keys that in Block & View are different
				$special_keys = [ 'Align' => 'text-align', 'HoverColor' => 'color', 'HoverBgColor' => 'bgcolor', 'fStyle' => 'style', 'Tran' => 'transform', 'Deco' => 'decoration', 'fSize' => 'size', 'Line' => 'lineheight', 'BorderStyle' => 'border-style', 'BorderWidth' => 'border-width', 'BorderColor' => 'border-color', 'BorderRadius' => 'border-radius' ];

				// Get default values for 2 fields only
				$default_vals	 = ContentViews_Block::default_values();
				$default_vals	 = [ 'readmore' => $default_vals[ 'readmore' ], 'taxoterm' => $default_vals[ 'taxoterm' ] ];

				// In Block, there is no default hover bg color, but in view there is, so must override here
				$default_vals['readmore']['HoverBgColor'] = '';

				foreach ( $fields as $field ) {
					foreach ( $style_keys as $key ) {
						// get key
						$key_toset	 = isset( $special_keys[ $key ] ) ? $special_keys[ $key ] : strtolower( $key );
						$suffix_key	 = in_array( $key, [ 'HoverColor', 'HoverBgColor' ] ) ? ($field === 'readmore' ? ':hover' : '-hover') : '';
						$suffix_val	 = ($key === 'Line') ? 'px' : '';

						if ( isset( $block_atts[ $field . $key ] ) || isset( $default_vals[ $field ][ $key ] ) ) {
							// get value
							$value = isset( $block_atts[ $field . $key ] ) ? $block_atts[ $field . $key ] : $default_vals[ $field ][ $key ];

							// special values
							if ( in_array( $key, $style_arr[ 'object' ] ) ) {
								$value = is_object( $value ) ? (array) $value : $value;
								if ( !empty( $value[ 'md' ] ) ) {
									$value = $value[ 'md' ];
								}
								if ( !empty( $value[ 'value' ] ) ) {
									$value = $value[ 'value' ];
								}
							}
							if ( $key === 'Weight' && intval( $value ) > 400 ) {
								$value = 'bold';
							}
							if ( $field === 'taxoterm' && $key === 'BgColor' && $value === '' ) {
								// to override default color set to "[class*=over_] *"
								$value = 'transparent';
							}

							if ( $key === 'fSize' ) {
								if ( !empty( $value[ 'sm' ] ) ) {
									$args[ PT_CV_PREFIX . "font-{$key_toset}-tablet-{$field}" ] = $value[ 'sm' ];
								}
								if ( !empty( $value[ 'xs' ] ) ) {
									$args[ PT_CV_PREFIX . "font-{$key_toset}-mobile-{$field}" ] = $value[ 'xs' ];
								}
							}
						} else {
							$value		 = $suffix_val	 = '';
						}

						if ( !in_array( $key, [ 'Margin', 'Padding', 'BorderWidth', 'BorderRadius' ] ) ) {
							$args[ PT_CV_PREFIX . "font-{$key_toset}-{$field}{$suffix_key}" ] = maybe_serialize( $value ) . $suffix_val;
						} else {
							// if not set in pattern, reset to empty ''
							$value = is_array( $value ) ? $value : array_fill_keys( [ 'top', 'right', 'bottom', 'left' ], '' );
							foreach ( $value as $side => $val ) {
								if ( $field === 'content-item' && in_array( $key, [ 'Margin', 'Padding' ] ) ) {
									// Pinterest: in block, margin is padding for 'content-item' => in view, set margin
									$custom_key = ($key === 'Padding' && $block_name !== 'pinterest') ? 'item-padding-value-' : 'item-margin-value-';
									// Pinterest: in view, when margin bottom is 0, it add 'mb0', cause no bottom space => must add space back
									if ( $block_name === 'pinterest' && $side === 'bottom' && $val === '0' ) {
										$val = '5';
									}
									$args[ PT_CV_PREFIX . "{$custom_key}{$side}" ] = $val;
								} else {
									$args[ PT_CV_PREFIX . "font-{$key_toset}-{$field}-{$side}" ] = $val;
								}
							}
						}
					}
				}
			}

			return $args;
		}

		static function filter_exclude_block_show_field( $args ) {
			// always exclude 'show-field-' in block, to use setting values & orders (drag-drop in "Fields Settings")
			$args = true;
			return $args;
		}

		static function filter_localize_hybrid( $args ) {
			$args[ 'layouts' ] = PT_CV_Values_Pro::hybrid_layouts( false );
			$args[ 'no_ppp_limit' ]	 = method_exists( 'PT_CV_Values', 'fixed_ppp_layouts' ) ? PT_CV_Values::fixed_ppp_layouts() : [];
			return $args;
		}

		// Disable old Animation > Overlay, Image Same Size for new hybrid layouts
		static function filter_old_feature_enable( $args ) {
			$block_name = PT_CV_Functions::setting_value( PT_CV_PREFIX . 'blockName' );
			if ( $block_name ) {
				$args = false;
			}

			return $args;
		}

	}
}

PT_CV_BlockToView_Pro::hybrid_hooks();
