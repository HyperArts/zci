<?php
/**
 * Genesis Sample.
 *
 * This file adds the home page template to the Genesis Sample Theme.
 *
 * Template Name: Home
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

$reset = $_GET['reset'];

if (!$reset) {

$cookie = $_COOKIE['landing'];

}


if ($cookie == "individual") {

    header('Location: "/landing-individual/"');
}

if ($cookie == "financial") {
    header('Location: "/landing-financial-professional/"');
}

if ($cookie == "institutional") {
    header('Location: "/landing-institutional/"');
}

// Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove the entry title (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

// Removes Skip Links.
remove_action( 'genesis_before_header', 'genesis_skip_links', 5 );

add_action( 'wp_enqueue_scripts', 'genesis_sample_dequeue_skip_links' );
/**
 * Dequeues Skip Links Script.
 *
 * @since 1.0.0
 */
function genesis_sample_dequeue_skip_links() {

	wp_dequeue_script( 'skip-links' );

}

// Removes navigation.
remove_theme_support( 'genesis-menus' );

add_action('genesis_header_right', 'login_button');

function login_button() { ?>

    <a target="_blank" href="https://login.bdreporting.com/Auth/Zevenbergen/SignIn" style = "float: right; margin-right: 80px;" class="bridge-button button green-bg btn-primary blue external_link pum-trigger" style="cursor: pointer;">Client Login</a>

<?php }

add_action('genesis_entry_content', 'ha_add_hero');

function ha_add_hero() { ?>
	<div class="row-container hero" style="background:url(<?php echo get_field('image'); ?>) no-repeat">
        <div class="col-container">
            <p class="white bold base"><?php echo get_field('intro'); ?></p>
            <div class="text-container desktop">
                <a href="/landing-individual/" class="" onclick="setCookie('landing','individual',365)"><div class="one-half first blue-bg large-18 semi sm-caps"><?php echo get_field('heading_one'); ?></div></a>
                <div class="one-half small-12"><?php echo get_field('text_one'); ?></div>
            </div>
            <div class="text-container mobile">
                <a href="/landing-individual/" class="" onclick="setCookie('landing','individual',365)"><div class="one-half first blue-bg large-18 semi sm-caps"><?php echo get_field('heading_one'); ?> <span class="small-14 no-sm-caps"><?php echo get_field('text_one'); ?></span></div></a>
            </div>
            <div class="text-container desktop">
                <a id = "professional-agreement"><div class="one-half first grey-bg large-18 semi sm-caps"><?php echo get_field('heading_two'); ?></div></a>
                <div class="one-half small-12"><?php echo get_field('text_two'); ?></div>
            </div>
            <div class="text-container mobile">
                <a id = "professional-agreement"><div class="one-half first grey-bg large-18 semi sm-caps"><?php echo get_field('heading_two'); ?> <span class="small-14 no-sm-caps"><?php echo get_field('text_two'); ?></span></div></a>
            </div>
            <div class="text-container desktop">
                <a id = "institutional-agreement" ><div class="one-half first green-bg large-18 semi sm-caps"><?php echo get_field('heading_three'); ?></div></a>
                <div class="one-half small-12"><?php echo get_field('text_three'); ?></div>
            </div>
            <div class="text-container mobile">
                <a id = "institutional-agreement"><div class="one-half first green-bg large-18 semi sm-caps"><?php echo get_field('heading_three'); ?> <span class="small-14 no-sm-caps"><?php echo get_field('text_three'); ?></span></div></a>
            </div>
        </div>
	</div>
<?php }

// Runs the Genesis loop.
genesis();
