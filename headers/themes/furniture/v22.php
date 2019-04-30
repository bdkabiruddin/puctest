
<?php puca_tbay_get_page_templates_parts('offcanvas-main-menu', 'right'); ?>

<header id="tbay-header" class="site-header header-v22 hidden-sm hidden-xs <?php echo (puca_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">
    <div class="header-main clearfix">
        <div class="container">
            <div class="row">
				<!-- //LOGO -->
                <div class="header-logo col-md-3">

                    <?php 
                    	puca_tbay_get_page_templates_parts('logo'); 
                    ?> 
                </div>

                <div class="header-searh col-md-6">

					<div class="search-full">
                    	<?php puca_tbay_get_page_templates_parts('productsearchform','full'); ?>
					</div>
					
				</div>
				
				<div class="header-right col-md-3">
					<?php puca_tbay_get_page_templates_parts('menu-account'); ?>

					<?php if ( !(defined('PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && PUCA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && defined('PUCA_WOOCOMMERCE_ACTIVED') && PUCA_WOOCOMMERCE_ACTIVED ): ?>
						<!-- Cart -->
						<div class="top-cart hidden-xs">
							<?php puca_tbay_get_woocommerce_mini_cart(); ?>
						</div>
					<?php endif; ?>

					<!-- Main menu -->
					<div class="tbay-mainmenu topbar-mobile">
						 <div class="top active-mobile">
							<button data-toggle="offcanvas-main" class="btn btn-sm btn-toggle-canvas" type="button">
							   <i class="icon-menu icons"></i>
							</button>
						 </div>
					</div>
				</div>
				
            </div>
        </div>
    </div>
</header>