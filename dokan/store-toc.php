<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$store_user   = get_userdata( get_query_var( 'author' ) );
$store_info   = dokan_get_store_info( $store_user->ID );
$map_location = isset( $store_info['location'] ) ? esc_attr( $store_info['location'] ) : '';

get_header();
$sidebar_configs = puca_tbay_get_woocommerce_layout_configs();

if ( isset($sidebar_configs['left']) && !isset($sidebar_configs['right']) ) {
    $sidebar_configs['main']['class'] .= ' pull-right';
}

$class_main = apply_filters('puca_tbay_woocommerce_content_class', 'container');

if( isset($sidebar_configs['container_full']) &&  $sidebar_configs['container_full'] ) {
    $class_main .= ' container-full';
}

$images_layout   =  apply_filters( 'woo_images_layout_single_product', 10, 2 );

if( $images_layout =='carousel' && is_singular( 'product' ) ) {
    $class_main = '';
}

$active_theme = puca_tbay_get_theme();

$content_class = '';
if ( isset($sidebar_configs['left']) && is_active_sidebar($sidebar_configs['left']['sidebar']) && !isset($sidebar_configs['right']) ) {
    $content_class  .= $sidebar_configs['main']['class'];
    $content_class  .= ' pull-right';
} else if(!isset($sidebar_configs['left'])) {
    $content_class  .= $sidebar_configs['main']['class'];
}

 if( is_shop() || is_product_category() ) {
    wp_enqueue_style('sumoselect');
    wp_enqueue_script('jquery-sumoselect'); 
 }

?>

<?php do_action( 'puca_woo_template_main_before' ); ?>

<section id="main-container" class="main-container <?php echo apply_filters('puca_dokan_content_class', 'container');?>">
    
    <?php if ( isset($sidebar_configs['left']) && is_active_sidebar($sidebar_configs['left']['sidebar']) && isset($sidebar_configs['right']) ) : ?>
        <div class="<?php echo esc_attr($sidebar_configs['left']['class']) ;?>">
            <aside class="sidebar sidebar-left" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
                <?php dynamic_sidebar( $sidebar_configs['left']['sidebar'] ); ?>
            </aside>
        </div>
    <?php endif; ?>


    <div class="row">

        <div id="main-content" class="archive-shop col-xs-12 <?php echo esc_attr($content_class); ?>">
            <div id="dokan-primary" class="dokan-single-store">
                <div id="dokan-content" class="store-page-wrap woocommerce site-content" role="main">
            
                    <?php dokan_get_template_part( 'store-header' ); ?>

                    <div id="store-toc-wrapper">
                        <div id="store-toc">
                            <?php
                            if( isset( $store_info['store_tnc'] ) ):
                            ?>
                                <h2 class="headline"><?php esc_html_e( 'Terms And Conditions', 'puca' ); ?></h2>
                                <div>
                                    <?php
                                    echo nl2br($store_info['store_tnc']);
                                    ?>
                                </div>
                            <?php
                            endif;
                            ?>
                        </div><!-- #store-toc -->
                    </div><!-- #store-toc-wrap -->
                </div><!-- #content -->
            </div><!-- #primary -->
        </div><!-- #main-content -->
        
        <?php if ( isset($sidebar_configs['left']) && is_active_sidebar($sidebar_configs['left']['sidebar']) && !isset($sidebar_configs['right']) ) : ?>
            <div class="<?php echo esc_attr($sidebar_configs['left']['class']) ;?>">
                <aside class="sidebar sidebar-left" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
                    <?php dynamic_sidebar( $sidebar_configs['left']['sidebar'] ); ?>
                </aside>
            </div>
        <?php endif; ?>
        
        <?php if (  isset($sidebar_configs['right']) && is_active_sidebar($sidebar_configs['right']['sidebar'])) : ?>
            <div class="<?php echo esc_attr($sidebar_configs['right']['class']) ;?>">
                <aside class="sidebar sidebar-right" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
                    <?php dynamic_sidebar( $sidebar_configs['right']['sidebar'] ); ?>
                </aside>
            </div>
        <?php endif; ?>

    </div>
</section>
<?php

get_footer();