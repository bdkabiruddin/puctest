<?php

wp_enqueue_script( 'slick' );

$style = $el_class = $css = $css_animation = $disable_mobile = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$loop_type = $auto_type = $autospeed_type = '';
extract( $atts );

$rows_count = $rows;

if( isset($responsive_type) && $responsive_type == 'yes') {
    $screen_desktop          =      isset($screen_desktop) ? $screen_desktop : 4;
    $screen_desktopsmall     =      isset($screen_desktopsmall) ? $screen_desktopsmall : 3;
    $screen_tablet           =      isset($screen_tablet) ? $screen_tablet : 3;
    $screen_mobile           =      isset($screen_mobile) ? $screen_mobile : 1;
} else {
    $screen_desktop          =      $columns;
    $screen_desktopsmall     =      $columns;
    $screen_tablet           =      $columns;
    $screen_mobile           =      $columns;  
}

$css = isset( $atts['css'] ) ? $atts['css'] : '';
$el_class = isset( $atts['el_class'] ) ? $atts['el_class'] : '';

$class_to_filter  = 'widget instagram-widget '. $style .' ';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class        = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

?>
<div class="<?php echo esc_attr($css_class); ?>">

    <?php if( (isset($subtitle) && $subtitle) || (isset($title) && $title)  ): ?>
        <h3 class="widget-title">
            <?php if ( isset($title) && $title ): ?>
                <span><?php echo esc_html( $title ); ?></span>
            <?php endif; ?>
            <?php if ( isset($subtitle) && $subtitle ): ?>
                <span class="subtitle"><?php echo esc_html($subtitle); ?></span>
            <?php endif; ?>
        </h3>
    <?php endif; ?>

    <?php 


    if ( !empty($username) ) {

        if( !function_exists( 'tbay_framework_scrape_instagram' ) ) return;
        
        $media_array = tbay_framework_scrape_instagram( $username );

        if ( is_wp_error( $media_array ) ) {

            echo wp_kses_post( $media_array->get_error_message() );

        } else {

            // filter for images only?
            if ( $images_only = apply_filters( 'tbay_framework_instagram_widget_images_only', FALSE ) ) {
                $media_array = array_filter( $media_array, 'tbay_framework_images_only' );
            }

            // slice list down to required number
            $media_array = array_slice( $media_array, 0, $number );

            ?>
 

            <div class="owl-carousel slick-instagram" data-items="<?php echo esc_attr($columns); ?>" data-large="<?php echo esc_attr($screen_desktop);?>" data-medium="<?php echo esc_attr($screen_desktopsmall); ?>" data-smallmedium="<?php echo esc_attr($screen_tablet); ?>" data-verysmall="<?php echo esc_attr($screen_mobile); ?>" data-carousel="owl" data-pagination="<?php echo ($pagi_type == 'yes') ? 'true' : 'false'; ?>" data-nav="<?php echo ($nav_type == 'yes') ? 'true' : 'false'; ?>" data-loop="<?php echo ($loop_type == 'yes') ? 'true' : 'false'; ?>" data-auto="<?php echo ($auto_type == 'yes') ? 'true' : 'false'; ?>" data-autospeed="<?php echo esc_attr( $autospeed_type )?>" data-unslick="<?php echo ($disable_mobile == 'yes') ? 'true' : 'false'; ?>">
                <?php 
                    $count = 0;  
                    $countall = count($media_array);
                    foreach ( $media_array as $item ) { ?>

                    <?php if($count%$rows_count == 0){ ?>
                        <div class="item">
                    <?php } ?>

                        <div class="instagram-item-inner">
                            <a href="<?php echo esc_url( $item['link'] ); ?>" class="tbay-image-loaded" target="<?php echo esc_attr( $target ); ?>">

                                <span class="group-items"> 
                                        <span class="likes"><i class="icon-heart"></i><?php echo esc_html($item['likes']);?></span>

                                        <span class="comments"><i class="icon-bubbles icons"></i><?php echo esc_html($item['comments']);?></span>
                                </span>
                                <?php
                                    $time  = $item['time'];
                                ?>
                                <?php if( isset($time) && $time ) : ?>
                                    <span class="time elapsed-time"><?php  echo tbay_framework_time_ago($time,1); ?></span>
                                <?php endif; ?>

                                <?php puca_tbay_src_image_loaded($item[$size], array('alt'=> $item['description'] )); ?>
                            </a>
                        </div>

                    <?php if($count%$rows_count == $rows_count-1 || $count==$countall -1){ ?>
                        </div>
                    <?php }
                    $count++; ?>

                <?php } ?>
            </div>
        <?php
        }
    }

    ?>


</div>