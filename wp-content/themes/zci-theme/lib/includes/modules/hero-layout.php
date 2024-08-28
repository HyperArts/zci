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

$image = intval( get_sub_field('image') );
$size = 'full'; // (thumbnail, medium, large, full or custom size)

?>

<div class="row-container hero">
    <?php if( $image ) {
    echo wp_get_attachment_image( $image, $size );
    } ?>
    <div class="text-container max-90">
        <p class="x-large nomarg-btm white sm-caps"><?php echo get_the_title(); ?></p>
    </div>
</div>