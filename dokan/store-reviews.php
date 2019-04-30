<?php
/**
 * The Template for displaying all reviews.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$store_user = get_userdata( get_query_var( 'author' ) );
$store_info = dokan_get_store_info( $store_user->ID );
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
    


    <div class="row">

        <?php if ( isset($sidebar_configs['left']) && is_active_sidebar($sidebar_configs['left']['sidebar']) && isset($sidebar_configs['right']) ) : ?>
            <div class="<?php echo esc_attr($sidebar_configs['left']['class']) ;?>">
                <aside class="sidebar sidebar-left" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
                    <?php dynamic_sidebar( $sidebar_configs['left']['sidebar'] ); ?>
                </aside>
            </div>
        <?php endif; ?>
    
        <div id="main-content" class="archive-shop col-xs-12 <?php echo esc_attr($content_class); ?>">
            <div id="dokan-primary" class="dokan-single-store">
                <div id="dokan-content" class="store-page-wrap woocommerce site-content" role="main">
            
                    <div id="dokan-content" class="store-review-wrap woocommerce" role="main">

                        <?php dokan_get_template_part( 'store-header' ); ?>

                        <?php
                        $dokan_template_reviews = Dokan_Pro_Reviews::init();
                        $id                     = $store_user->ID;
                        $post_type              = 'product';
                        $limit                  = 20;
                        $status                 = '1';
                        $comments               = $dokan_template_reviews->comment_query( $id, $post_type, $limit, $status );
                        ?>

                        <div id="reviews">
                            <div id="comments">

                                <h2 class="headline"><?php esc_html_e( 'Seller Review', 'puca' ); ?></h2>

                                <ol class="commentlist">
                                    <?php
                                    if ( count( $comments ) == 0 ) {
                                        echo '<span colspan="5">' . esc_html__( 'No Results Found', 'puca' ) . '</span>';
                                    } else {
                                        foreach ( $comments as $single_comment ) {
                                            if ( $single_comment->comment_approved ) {
                                                $GLOBALS['comment'] = $single_comment;
                                                $comment_date       = get_comment_date( 'l, F jS, Y \a\t g:i a', $single_comment->comment_ID );
                                                $comment_author_img = get_avatar( $single_comment->comment_author_email, 60 );
                                                $permalink          = get_comment_link( $single_comment );
                                                ?>

                                                <li <?php comment_class(); ?>>
                                                    <div class="review_comment_container">
                                                        <div class="dokan-review-author-img"><?php echo trim($comment_author_img); ?></div>
                                                        <div class="comment-text">
                                                            <a href="<?php echo esc_url($permalink); ?>">
                                                                <?php
                                                                if ( get_option('woocommerce_enable_review_rating') == 'yes' ) :
                                                                    $rating =  intval( get_comment_meta( $single_comment->comment_ID, 'rating', true ) ); ?>
                                                                    <div class="dokan-rating">
                                                                        <div class="star-rating" title="<?php echo sprintf(__( 'Rated %d out of 5', 'puca' ), $rating) ?>">
                                                                            <span style="width:<?php echo ( intval( get_comment_meta( $single_comment->comment_ID, 'rating', true ) ) / 5 ) * 100; ?>%"><strong><?php echo trim($rating); ?></strong> <?php esc_html_e( 'out of 5', 'puca' ); ?></span>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </a>
                                                            <p>
                                                                <strong><?php echo trim($single_comment->comment_author); ?></strong>
                                                                <em class="verified"><?php echo trim($single_comment->user_id == 0 ? '(Guest)' : ''); ?></em>
                                                                -
                                                                <a href="<?php echo esc_url($permalink); ?>">
                                                                    <time datetime="<?php echo date( 'c', strtotime( $comment_date ) ); ?>"><?php echo trim($comment_date); ?></time>
                                                                </a>
                                                            </p>
                                                            <div class="description">
                                                                <p><?php echo trim($single_comment->comment_content); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                            <?php
                                            }
                                        }
                                    }
                                    ?>
                                </ol>
                            </div>
                        </div>

                        <?php
                        echo trim($dokan_template_reviews->review_pagination( $id, $post_type, $limit, $status ));
                        ?>

                    </div><!-- #content .site-content -->
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