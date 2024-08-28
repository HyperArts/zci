<?php
/**
 * Genesis Sample.
 *
 * This file adds custom content to the Contact page.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

//* Force Content Sidebar Genesis Layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

add_filter( 'gform_required_legend', '__return_empty_string' );

//* Remove the entry title (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

//* Add class to .site-inner
add_filter('genesis_attr_site-inner', 'ha_add_class_site_inner');
function ha_add_class_site_inner($attributes) {
	$attributes['class'] = $attributes['class']. ' max-90';
	return $attributes;
}

add_action('genesis_after_header', 'ha_add_contact_hero');
function ha_add_contact_hero() {
	$image = get_field('image');
	$size = 'full'; // (thumbnail, medium, large, full or custom size) ?>

	<div class="row-container hero">

	<?php if( $image ) {
		echo wp_get_attachment_image( $image, $size );
	} ?>

    <div class="hero-overlay"></div>

		<div class="text-container max-80">
			<p class="large-26 center nomarg-btm"><?php echo get_field('text'); ?></p>
		</div>
	</div>

<?php }

add_action('genesis_entry_content', 'ha_add_contact_form');

function ha_add_contact_form() { ?>

    <p class="eyebrow small-12 upper semi"><?php echo get_field('eyebrow'); ?></p>
    <p class="large-34"><?php echo get_field('heading'); ?></p>
    <p class=""><?php echo get_field('intro'); ?></p>

	<?php echo do_shortcode('[gravityform id="1" title="false"]');
}

add_action('genesis_sidebar', 'ha_add_sidebar_content');

function ha_add_sidebar_content() { ?>

    <?php
    $image = get_theme_mod( 'custom_logo' );
	$size = 'full';
	if ( $image ) {
		echo wp_get_attachment_image( $image, $size );
	}
	?>

    <p class="address"><?php echo get_field('address'); ?></p>
    <p class="phone">Tel <?php echo get_field('phone'); ?></p>
    <p class="fax">Fax <?php echo get_field('fax'); ?></p>

<?php }

genesis();
