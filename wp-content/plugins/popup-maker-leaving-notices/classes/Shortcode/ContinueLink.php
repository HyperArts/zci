<?php
/*******************************************************************************
 * Copyright (c) 2018, WP Popup Maker
 ******************************************************************************/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_LN_Shortcode_ContinueLink
 *
 * Registers the pum_terms_box shortcode.
 */
class PUM_LN_Shortcode_ContinueLink extends PUM_Shortcode {

	/**
	 * @var int
	 */
	public $version = 2;

	/**
	 * @var bool
	 */
	public $ajax_rendering = true;

	/**
	 *
	 */
	public function register() {
		// register old shortcode tag.
		add_shortcode( 'continue_link', array( $this, 'handler' ) );
		parent::register();
	}

	/**
	 * The shortcode tag.
	 *
	 * @return string
	 */
	public function tag() {
		return 'pum_continue_link';
	}

	/**
	 * @return string
	 */
	public function label() {
		return __( 'Continue Link', 'popup-maker-leaving-notices' );
	}

	/**
	 * @return string
	 */
	public function description() {
		return '';
	}

	/**
	 * @return array
	 */
	public function post_types() {
		return array( 'popup' );
	}

	/**
	 * @return array
	 */
	public function fields() {
		return array(
			'general' => array(
				'main' => array(
					'text'         => array(
						'type'  => 'text',
						'label' => __( 'Continue Text', 'popup-maker-leaving-notices' ),
						'desc'  => __( 'This is the text label for the continue link.', 'popup-maker-leaving-notices' ),
						'std'   => __( 'Continue', 'popup-maker-leaving-notices' ),
					),
					'target_blank' => array(
						'type'  => 'checkbox',
						'label' => __( 'Continue links will open in a new window or tab.', 'popup-maker-leaving-notices' ),
					),
				),
			),
		);
	}

	/**
	 * Shortcode handler
	 *
	 * @param  array  $atts    shortcode attributes
	 * @param  string $content shortcode content
	 *
	 * @return string
	 */
	public function handler( $atts, $content = null ) {
		$atts = $this->shortcode_atts( $atts );

		ob_start(); ?>

		<div class="popmake-continue-link">
			<a class="do-default" href="#" <?php echo esc_attr( $atts['target_blank'] ? 'target="_blank"' : '' ); ?>><?php echo esc_html( $atts['text'] ); ?></a>
		</div>
		<?php

		return ob_get_clean();
	}

	/**
	 * Returns the styles for inner contents of the JS templates.
	 */
	public function template_styles() {
		echo file_get_contents( PUM_LN::$DIR . '/assets/css/pum-ln-site' . PUM_Site_Assets::$suffix . '.css' );
	}

}

