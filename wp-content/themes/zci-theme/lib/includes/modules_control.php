<?php
/*
 * DISPLAY ACF FLEXIBLE CONTENT MODULES
 */

function display_flexible_content_modules() {
	global $post;

	// Append Basic Content Types
	if (have_rows('flexible_content_types', $post->ID)) {

		while ( have_rows('flexible_content_types') ) {
			the_row();
			$layout = get_row_layout();
			switch ($layout) {
				case 'hero':
					get_template_part('lib/includes/modules/hero', 'layout');
					break;
				case 'intro':
					get_template_part('lib/includes/modules/intro', 'layout');
					break;
				case 'product_details':
					get_template_part('lib/includes/modules/product-details', 'layout');
					break;
				case 'cta':
					get_template_part('lib/includes/modules/cta', 'layout');
					break;
				default:
					// do nothing
					break;
			}
		}
	}
}