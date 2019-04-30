
<?php 

     	$cat = get_term_by( 'id', $category, 'product_cat' );
     	if( isset($images) && $images) {

	        $cat_id 		= 	$images;    

	        if( isset($cat) && $cat ) {
				$cat_name 		= 	$cat->name;    
				$cat_slug 		= 	$cat->slug;   
				$cat_link 		= 	get_term_link($cat->slug, 'product_cat');
				$cat_count 		= 	$cat->count;  	
	        } else {
	        	$cat_name 		= 	esc_html__('Shop', 'puca');
	        	$cat_link 		= 	get_permalink( wc_get_page_id( 'shop' ) );
	        	$cat_count 		= 	puca_total_product_count();	
	        }

	        $image 		   = wp_get_attachment_url( $cat_id );

	        ?> 

			<div class="item">

				<div class="item-cat">
					<?php if ( !empty($image) ) { ?>
						<a class="cat-img tbay-image-loaded" href="<?php echo esc_url($cat_link); ?>">
							<?php puca_tbay_src_image_loaded($image); ?>
						</a>
					<?php } ?>

					<a class="cat-name" href="<?php echo esc_url($cat_link); ?>">
						<?php echo esc_html($cat_name); ?>
						<span class="count-item">(<?php echo esc_html($cat_count).' '.esc_html__('items','puca'); ?>)</span>
					</a>

				</div>

			</div>   
		<?php } ?>

<?php wp_reset_postdata(); ?>