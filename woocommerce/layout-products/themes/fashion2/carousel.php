<?php

wp_enqueue_script( 'slick' );

$product_item = isset($product_item) ? $product_item : 'inner';
$columns = isset($columns) ? $columns : 4;
$rows_count = isset($rows) ? $rows : 1;
$data_auto		= ( !empty($data_auto) ) ? $data_auto : 'no';
$data_loop		= ( !empty($data_loop) ) ? $data_loop : 'no';
$data_autospeed	= ( !empty($data_autospeed) ) ? $data_autospeed : 500;


$screen_desktop          =      isset($screen_desktop) ? $screen_desktop : 4;
$screen_desktopsmall     =      isset($screen_desktopsmall) ? $screen_desktopsmall : 3; 
$screen_tablet           =      isset($screen_tablet) ? $screen_tablet : 3;
$screen_mobile           =      isset($screen_mobile) ? $screen_mobile : 1;

$disable_mobile          =      isset($disable_mobile) ? $disable_mobile : '';

$active_theme = puca_tbay_get_part_theme();
?>
<div class="owl-carousel products" data-items="<?php echo esc_attr($columns); ?>" data-large="<?php echo esc_attr($screen_desktop);?>" data-medium="<?php echo esc_attr($screen_desktopsmall); ?>" data-smallmedium="<?php echo esc_attr($screen_tablet); ?>" data-verysmall="<?php echo esc_attr($screen_mobile); ?>" data-carousel="owl" data-pagination="<?php echo ($pagi_type == 'yes') ? 'true' : 'false'; ?>" data-nav="<?php echo ($nav_type == 'yes') ? 'true' : 'false'; ?>" data-loop="<?php echo ($data_loop == 'yes') ? 'true' : 'false'; ?>" data-auto="<?php echo ($data_auto == 'yes') ? 'true' : 'false'; ?>" data-autospeed="<?php echo esc_attr( $data_autospeed )?>" data-unslick="<?php echo ($disable_mobile == 'yes') ? 'true' : 'false'; ?>">
    <?php $count = 0; while ( $loop->have_posts() ): $loop->the_post(); global $product; ?>
	
			<?php if($count%$rows_count == 0){ ?>
				<div class="item">
			<?php } ?>
	
        
            <div class="products-grid product">
                <?php wc_get_template_part( 'item-product/'.$active_theme.'/'.$product_item ); ?>
            </div>
		
			<?php if($count%$rows_count == $rows_count-1 || $count==$loop->post_count -1){ ?>
				</div>
			<?php }
			$count++; ?>
		
    <?php endwhile; ?>
</div> 
<?php wp_reset_postdata(); ?>