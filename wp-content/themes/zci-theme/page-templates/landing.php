<?php
/**
 * Genesis Sample.
 *
 * This file adds the landing page template to the Genesis Sample Theme.
 *
 * Template Name: Landing
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_action( 'genesis_entry_content', 'ha_add_cookie' );
function ha_add_cookie() {
	if(isset($_COOKIE['landing']) && $_COOKIE['landing'] === 'individual_financial') {
		echo 'dog';
	}
	if(isset($_COOKIE['landing']) && $_COOKIE['landing'] === 'institutional') {
		echo 'cat';
	}
}

genesis();
