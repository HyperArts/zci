<?php
/*
Template Name: Flexible Main
Template Post Type: page
*/

//* Remove the entry title (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

remove_action('genesis_entry_content', 'genesis_do_entry_content');
add_action('genesis_entry_content','display_flexible_content_modules', 9);

genesis();