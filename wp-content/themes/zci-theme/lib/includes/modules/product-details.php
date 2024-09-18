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
$subheading = get_sub_field('subheading');
$button_header_1 = get_sub_field('button_header_1');
$button_header_2 = get_sub_field('button_header_2');

$text = get_sub_field('text');
$button_text = get_sub_field('button_text');
$button_id = get_sub_field('button_id');
$url = get_sub_field('url');
$button_text_2 = get_sub_field('button_text_2');
$button_id_2 = get_sub_field('button_id_2');
$url_2 = get_sub_field('url_2');
$button_text_3 = get_sub_field('button_text_3');
$button_id_3 = get_sub_field('button_id_3');
$url_3 = get_sub_field('url_3');
$button_text_4 = get_sub_field('button_text_4');
$button_id_4 = get_sub_field('button_id_4');
$url_4 = get_sub_field('url_4');
$toggle = get_sub_field('toggle');


?>

<div class="row-container product-details <?php echo get_sub_field_object( 'product_variation' )['value'] ?> <?php if( $toggle ) echo 'lt-grey-bg' ?>">
    <div class="row-divider"></div>
    <div class="clearfix max-90">
        <?php if( get_sub_field_object( 'product_variation' )['value'] == 'variation-c' ) { ?>
        <h2 class="large-32 nomarg-btm"><?php echo $heading ?></h2>
        <?php if ($subheading) {?>
            <h4 class="nomarg-btm"><?php echo $subheading ?></h4>
        <?php } ?>
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
                    <h2 class=large-32 nomarg-btm"><?php echo $heading ?></h2>
                     <?php if ($subheading) {?>
                        <h4 class="nomarg-btm"><?php echo $subheading ?></h2>
                    <?php } ?>
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
                    <?php if( $button_header_1 ) { 

                        $rand = rand(100000, 1000000);

                        ?> 
                    <div class = "toggle-wrap">
                     <a class="button block-btn green-bg blue button_toggle_1_<?php echo $rand?>"><?php echo $button_header_1 ?></a>
                       <script>
                        jQuery( document ).ready(function() {
                             jQuery('<?php echo ".block-$rand"?>-button-set-1').hide();


                             jQuery('.button_toggle_1_<?php echo $rand?>').click(function(){
                                 console.log('button 1 toggle clicked');
                                 jQuery('.block-<?php echo $rand?>-button-set-2').hide();
                                 jQuery('.block-<?php echo $rand?>-button-set-1').show();
                                 jQuery('.toggle-wrap .button').attr('style', 'border: unset;');
                                 jQuery(this).attr('style', 'border: 3px #333 solid !important;');
                                });

                        });
                     </script>
                    <?php }?>
                    <?php if( $button_header_2 ) { ?> 
                    <a class="button block-btn green-bg blue button_toggle_2_<?php echo $rand?>"><?php echo $button_header_2 ?></a><br><br>
                     <script>
                        jQuery( document ).ready(function() {
                             jQuery('<?php echo ".block-$rand"?>-button-set-2').hide();

                          jQuery('.button_toggle_2_<?php echo $rand?>').click(function(){
                                 console.log('button 2 toggle clicked');
                                 jQuery('.block-<?php echo $rand?>-button-set-1').hide();
                                 jQuery('.block-<?php echo $rand?>-button-set-2').show();
                                 jQuery('.toggle-wrap .button').attr('style', 'border: unset;');
                                 jQuery(this).attr('style', 'border: 3px #333 solid !important;');
                                });

                        });
                     </script>
                     </div>
                    <?php }?>
                    <div class = "action-links-row-wrapper">
                    <?php if( $button_text ) { ?><a <?php if ($button_id) echo " id = '$button_id' ";?>class="<?php echo "block-" . $rand . "-" ?>button-set-1 button block-btn green-bg blue" target = "_blank" href="<?php echo $url; ?>">
                    <?php echo $button_text; ?></a><?php } ?>
                    <?php if( $button_text_2 ) { ?><a <?php if ($button_id_2) echo " id = '$button_id_2' ";?> class="<?php echo "block-" . $rand . "-" ?>button-set-1 button block-btn green-bg blue" target = "_blank" href="<?php echo $url_2; ?>"><?php echo $button_text_2; ?></a><?php } ?>
                    <?php if( $button_text_3 ) { ?><a <?php if ($button_id_3) echo " id = '$button_id_3' ";?> class="<?php echo "block-" . $rand . "-" ?>button-set-2 button block-btn green-bg blue" target = "_blank" href ="<?php echo $url_3; ?>"><?php echo $button_text_3; ?></a><?php } ?>
                    <?php if( $button_text_4 ) { ?><a <?php if ($button_id_4) echo " id = '$button_id_4' ";?> class="<?php echo "block-" . $rand . "-" ?>button-set-2 button block-btn green-bg blue" target = "_blank" href="<?php echo $url_4; ?>"><?php echo $button_text_4; ?></a><?php } ?>
                    </div>

                </div>
            </div>
	        <?php if( get_sub_field_object( 'product_variation' )['value'] == 'variation-c' ) { ?>
        </div>
        <?php }?>
    </div>
    <div class="row-divider"></div>
</div>