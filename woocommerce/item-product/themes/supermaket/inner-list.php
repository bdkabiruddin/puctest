<?php 
global $product;

?>
<div class="product-block list" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
	<div class="row product-content">
		<div class="col-sm-5 list-img">
		    <figure class="image">
		        <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" class="product-image">
		            <?php
		                /**
		                * woocommerce_before_shop_loop_item_title hook
		                *
		                * @hooked woocommerce_show_product_loop_sale_flash - 10
		                * @hooked woocommerce_template_loop_product_thumbnail - 10
		                */
		                remove_action('woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash', 10);
		                do_action( 'woocommerce_before_shop_loop_item_title' );
		            ?>
		        </a>
		    </figure>
		    <?php (class_exists( 'YITH_WCBR' )) ? puca_brands_get_name($product->get_id()) : ''; ?>
		</div>    
	    <div class="col-sm-7 list-content">
		    <div class="caption-list">
		        <h3 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	            <?php
	                /**
	                * woocommerce_after_shop_loop_item_title hook
	                *
	                * @hooked woocommerce_template_loop_rating - 5
	                * @hooked woocommerce_template_loop_price - 10
	                */
	                add_action('woocommerce_after_shop_loop_item_title','woocommerce_show_product_loop_sale_flash', 15);
					do_action( 'woocommerce_after_shop_loop_item_title');

	            ?>
	            <div class="woocommerce-product-details__short-description">
	           		<?php echo  the_excerpt();  ?>
	           	</div>	
        		<div class="groups-button">
                    <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
                    <?php
                        $action_add = 'yith-woocompare-add-product';
                        $url_args = array(
                            'action' => $action_add,
                            'id' => $product->get_id()
                        );
                    ?> 
					<div class="button-wishlist">
						<?php
							if( class_exists( 'YITH_WCWL' ) ) {
								echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
							}
						?>  
					</div>

					<?php if (class_exists('YITH_WCQV_Frontend')) { ?>
					<div>
						<a href="#" class="button yith-wcqv-button" title="<?php echo esc_html__('Quick view', 'puca'); ?>"  data-product_id="<?php echo esc_attr($product->get_id()); ?>">
							<span>
								<i class="icon-eye icons"></i>
							</span>
						</a>
					</div>	
					<?php } ?>

					<?php if( class_exists( 'YITH_Woocompare' ) ) { ?>
						<?php
							$action_add = 'yith-woocompare-add-product';
							$url_args = array(
								'action' => $action_add,
								'id' => $product->get_id()
							);
						?>
						<div class="yith-compare">
							<a href="<?php echo wp_nonce_url( add_query_arg( $url_args ), $action_add ); ?>" title="<?php echo esc_html__('Compare', 'puca'); ?>" class="compare" data-product_id="<?php echo esc_attr($product->get_id()); ?>">
								<i class="icon-shuffle icons"></i>
							</a>
						</div>
					<?php } ?>
			            
                </div>
		    </div>
		</div>    
	</div>	    
</div>
