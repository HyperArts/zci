<?php
/**
 * ZCI Theme
 *
 * This file adds custom flexible content.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

$text = get_sub_field('text');
$toggle = get_sub_field('toggle');

?>

<div class="row-container intro <?php if( $toggle ) echo 'lt-grey-bg' ?>">
	<div class="row-divider"></div>
	<div class="text-container max-90">
		<p class="large-18 nomarg-btm"><?php echo $text ?></p>
	</div>
	<div class="row-divider"></div>
</div>