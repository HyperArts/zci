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
$heading = get_sub_field('heading');
$text = get_sub_field('text');
$button_text = get_sub_field('button_text');
$url = get_sub_field('url');
$button_text_2 = get_sub_field('button_text_2');
$url_2 = get_sub_field('url_2');
$button_text_3 = get_sub_field('button_text_3');
$url_3 = get_sub_field('url_3');
$button_text_4 = get_sub_field('button_text_4');
$url_4 = get_sub_field('url_4');
$toggle = get_sub_field('toggle');

?>

<div class="row-container product-details <?php echo get_sub_field_object( 'product_variation' )['value'] ?> <?php if( $toggle ) echo 'lt-grey-bg' ?>">
    <div class="row-divider"></div>
    <div class="clearfix max-90">
        <?php if( get_sub_field_object( 'product_variation' )['value'] == 'variation-c' ) { ?>
        <h2 class="large-32 nomarg-btm"><?php echo $heading ?></h2>
        <p class="large-18 nomarg-btm"><?php echo $text ?></p>
        <div class="row-divider"></div>
        <div class="clearfix wrapper">
        <?php }?>
            <div class="one-half first">

                <?php
                $size = 'full'; // (thumbnail, medium, large, full or custom size)
                if( $image ) {
                    echo wp_get_attachment_image( $image, $size );
                } ?>

            </div>

            <div class="one-half">
                <div class="text-container">
                    <h2 class="large-32 nomarg-btm"><?php echo $heading ?></h2>
                    <p class="small-14"><?php echo $text ?></p>
	                <?php if( get_sub_field_object( 'product_variation' )['value'] == 'variation-d' ) { ?>
                    <div class="row-divider"></div>
		                <?php }?>
                    <ul>
                    <?php

                    if( have_rows('repeater') ):

                    while( have_rows('repeater') ) : the_row();

                        $image = get_sub_field('image');
                        $size = 'thumbnail'; // (thumbnail, medium, large, full or custom size)
                        $heading = get_sub_field('heading');
                        $text = get_sub_field('text'); ?>

                    <li class="clearfix">
                        <div>
                        <?php echo wp_get_attachment_image( $image, $size ); ?>
                        </div>
                        <div>
                        <p class="title base bold nomarg-btm"><?php echo $heading ?></p>
                        <p class="small-12 nomarg-btm"><?php echo $text ?></p>
                        </div>
                    </li>

                    <?php

                    endwhile;

                    else :

                    endif; ?>
                    </ul>
                    <?php if( $button_text ) { ?><a class="button block-btn green-bg blue" target = "_blank" href="<?php echo $url; ?>">
                    <?php echo $button_text; ?></a><?php } ?>
                    <?php if( $button_text_2 ) { ?><a class="button block-btn green-bg blue" target = "_blank" href="<?php echo $url_2; ?>"><?php echo $button_text_2; ?></a><?php } ?>
                    <?php if( $button_text_3 ) { ?><a class="button block-btn green-bg blue" target = "_blank" id ="<?php echo $url_3; ?>"><?php echo $button_text_3; ?></a><?php } ?>
                    <?php if( $button_text_4 ) { ?><a class="button block-btn green-bg blue" target = "_blank" id="<?php echo $url_4; ?>"><?php echo $button_text_4; ?></a><?php } ?>

                </div>
            </div>
	        <?php if( get_sub_field_object( 'product_variation' )['value'] == 'variation-c' ) { ?>
        </div>
        <?php }?>
    </div>
    <div class="row-divider"></div>
</div>