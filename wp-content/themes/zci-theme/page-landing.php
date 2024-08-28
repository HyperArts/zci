<?php
/**
 * Landing Content
 * 
 * Template Name: Landing Content
 *
 * This file adds custom content to the Landing page.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_filter( 'body_class', 'genesis_sample_landing_body_class' );
/**
 * Adds landing page body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Original body classes.
 * @return array Modified body classes.
 */
function genesis_sample_landing_body_class( $classes ) {

	$classes[] = 'landing';
	return $classes;

}

//* Remove the entry meta in the entry footer (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Remove the entry title (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

//* Remove the entry footer markup (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

// Add Sections
add_action( 'genesis_entry_content', 'ha_hero' );
add_action( 'genesis_entry_content', 'ha_our_approach' );
add_action( 'genesis_entry_content', 'ha_our_strategies' );
add_action( 'genesis_entry_content', 'ha_news' );

function ha_hero() { ?>

	<div class="row-container hero">

		<?php /*$image = get_field('image_hero');
		$size = 'full'; // (thumbnail, medium, large, full or custom size)

		if( $image ) {
			echo wp_get_attachment_image( $image, $size );
		} */?>

        <video autoplay muted loop id="myVideo">
            <source src="https://player.vimeo.com/progressive_redirect/playback/990816798/rendition/1080p/file.mp4?loc=external&log_user=0&signature=099bf62266d1aa7a16119f65f8b9fd28c3ddebaf1d746ffc5ca787df1e72ce0a" type="video/mp4">
        </video>

        <div class="hero-overlay"></div>

		<div class="text-container max-80">
			<p class="large-26 center nomarg-btm"><?php echo get_field('text_hero') ?><br>
		</div>



	</div>

	<center><div style = "margin-top: -20px"><img src = "/wp-content/uploads/2024/08/noun-down-arrow-2157232-D4D958.png"></center></div>

<?php }

function ha_our_approach() { ?>

	<div class="row-divider"></div>

	<div class="row-container our-approach max-90">
		<div class="one-half first">

			<?php $image = get_field('image_approach');
			$size = 'full'; // (thumbnail, medium, large, full or custom size)
			if( $image ) {
				echo wp_get_attachment_image( $image, $size );
			} ?>

		</div>

		<div class="one-half">
			<div class="text-container">
				<h2 class="large-30"><?php echo get_field('heading_approach') ?></h2>
				<p class="small-14"><?php echo get_field('text_approach') ?></p>
				<a href="<?php echo get_field( 'url_approach' ) ?>" class="button block-btn blue-bg upper"><?php echo get_field( 'button_approach' ) ?> <span class="dashicons dashicons-arrow-right-alt2"></span></a>
			</div>
		</div>
	</div>

	<div class="row-divider"></div>

<?php }

function ha_our_strategies() { ?>

    <div class="row-container our-strategies" style="background: url(<?php echo wp_get_attachment_image_url(get_field('image_strategies'), 'full') ?>) no-repeat; ">
	    <div class="row-divider"></div>

        <div class="one-half first">
            <div class="text-container">
                <h2 class="large-30"><?php echo get_field('heading_strategies') ?></h2>
                <p class="small-14"><?php echo get_field('text_strategies') ?></p>
                <a href="<?php echo get_field( 'url_strategies' ) ?>" class="button block-btn green-bg blue upper"><?php echo get_field( 'button_strategies' ) ?> <span class="dashicons dashicons-arrow-right-alt2"></span></a>
            </div>
        </div>

	    <div class="one-half">
		    <?php $image = get_field('image_strategies');
		    $size = 'full'; // (thumbnail, medium, large, full or custom size)
		    if( $image ) {
			    echo wp_get_attachment_image( $image, $size );
		    } ?>
	    </div>

	    <div class="row-divider mobile-hide"></div>
    </div>

<?php }

function ha_news() { ?>

	<div class="row-divider"></div>

	<div class="row-container news max-90">

        <h2 class="large-30">News & Insights</h2>

		<div class="col-container">

		<?php

		// args
		$args = array(
			'posts_per_page'    => 3,
			'post_type'     => 'post'
		);

		// query
		$the_query = new WP_Query( $args );

		$i = 0;

		$class    =   array(
			"one-third first",
			"one-third",
			"one-third"
		);

		if( $the_query->have_posts() ):
			while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

				<?php $pl = get_the_permalink(); ?>

				<a href="<?php echo $pl?>" class="<?php echo $class[ $i % 3 ] ?>">

					<?php
					$image = get_post_thumbnail_id();
					$size = 'full'; // (thumbnail, medium, large, full or custom size)
					if( $image ) {
						echo wp_get_attachment_image( $image, $size );
					}
					?>
						<div class="text-container news-bg">
							<p class="base semi nomarg-btm"><?php echo get_the_title() ?></p>
						</div>
					
				</a>

				<?php $i++; ?>

			<?php endwhile;
		endif;
		?>
		</div>
		<div class="row-divider"></div>
        <p class="center"><a href="/news-and-insights" class="base blue upper bold news-more">See more news and insights</a> <span class="dashicons dashicons-arrow-right-alt blue"></span></p>
	</div>

	<div class="row-divider"></div>

<?php }

genesis();