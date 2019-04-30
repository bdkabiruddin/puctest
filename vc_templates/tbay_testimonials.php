<?php

wp_enqueue_script( 'slick' );

$style = $el_class = $css = $css_animation = $disable_mobile = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$loop_type = $auto_type = $autospeed_type = '';
extract( $atts );

$args = array(
	'post_type' => 'tbay_testimonial',
	'posts_per_page' => $number,
	'post_status' => 'publish',
);
$loop = new WP_Query($args); 

$rows_count = isset($rows) ? $rows : 1;

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

$active_theme = puca_tbay_get_part_theme();


$css = isset( $atts['css'] ) ? $atts['css'] : '';
$el_class = isset( $atts['el_class'] ) ? $atts['el_class'] : '';

$class_to_filter = 'widget-testimonials widget  '. $style .' ';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

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
	<?php if ( $loop->have_posts() ): ?>


        <div class="owl-carousel slick-testimonials" data-items="<?php echo esc_attr($columns); ?>" data-large="<?php echo esc_attr($screen_desktop);?>" data-medium="<?php echo esc_attr($screen_desktopsmall); ?>" data-smallmedium="<?php echo esc_attr($screen_tablet); ?>" data-verysmall="<?php echo esc_attr($screen_mobile); ?>" data-carousel="owl" data-pagination="<?php echo ($pagi_type == 'yes') ? 'true' : 'false'; ?>" data-nav="<?php echo ($nav_type == 'yes') ? 'true' : 'false'; ?>" data-loop="<?php echo ($loop_type == 'yes') ? 'true' : 'false'; ?>" data-auto="<?php echo ($auto_type == 'yes') ? 'true' : 'false'; ?>" data-autospeed="<?php echo esc_attr( $autospeed_type )?>" data-unslick="<?php echo ($disable_mobile == 'yes') ? 'true' : 'false'; ?>">
            <?php $count = 0;  while ( $loop->have_posts() ): $loop->the_post(); ?>

                <?php if($count%$rows_count == 0){ ?>
                    <div class="item">
                <?php } ?> 

                    <?php get_template_part( 'vc_templates/testimonial/'.$active_theme.'/testimonial', $style ); ?>

                <?php if($count%$rows_count == $rows_count-1 || $count==$loop->post_count -1){ ?>
                    </div>
                <?php }
                $count++; ?>

            <?php endwhile; ?>
        </div>

	<?php endif; ?>
</div>
<?php wp_reset_postdata(); ?>