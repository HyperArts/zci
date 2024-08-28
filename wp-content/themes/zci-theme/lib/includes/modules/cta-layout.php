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

$heading = get_sub_field('heading');
$button_text = get_sub_field('button_text');
$url = get_sub_field('url');

?>

<div class="row-container cta blue-bg max-90">
    <div class="row-divider half"></div>
	<p class="large-18 nomarg-btm sm-caps bold"><?php echo $heading ?></p>
	<a href="<?php echo $url; ?>" class="button block-btn green-bg blue"><?php echo $button_text; ?><span class="dashicons dashicons-arrow-right-alt2"></span></a>
    <div class="row-divider half"></div>
</div>