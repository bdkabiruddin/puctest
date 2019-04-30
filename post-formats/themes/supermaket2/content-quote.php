<?php
/**
 *
 * The default template for displaying content
 * @since 1.0
 * @version 1.2.0
 *
 */

?>
<!-- /post-standard -->
<?php if ( ! is_single() ) : ?>
<div  class="post-list clearfix">
<?php endif; ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php if ( is_single() ) : ?>
	<div class="entry-single">
<?php endif; ?>
		<?php
			if ( is_single() ) : ?>
	        	<div class="entry-header">

					<div class="entry-meta">
			            <?php
			                if (get_the_title()) {
			                ?>
			                    <h2 class="entry-title">
			                       <?php the_title(); ?>
			                    </h2>
			                <?php
			            	}
			            ?>
			        </div>
					<div class="meta-info">
						<span class="author"><?php echo get_avatar(puca_tbay_get_id_author_post(), 'avatar_post_carousel'); ?> <?php the_author_posts_link(); ?></span>

						<span class="entry-date"><?php echo puca_time_link(); ?></span>

						<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
							<span class="comments-link"><i class="icons icon-bubbles"></i> <?php comments_popup_link( '0', '1', '%' ); ?><?php esc_html_e('comments', 'puca') ?></span>
						<?php endif; ?>

						<span class="entry-category">
				            <i class="icons icon-folder"></i>
				            <?php the_category(','); ?>
				      	</span>
						<span class="post-type"><?php puca_tbay_icon_post_formats(); ?></span>
					</div>
				</div>

				<div class="post-excerpt entry-content">
					<?php
						if ( has_excerpt()) {
							echo '<blockquote>';
							the_excerpt();
							echo '</blockquote>';
						} else {
							echo '<blockquote>';
							?>
								<div class="entry-description"><?php echo puca_tbay_substring(get_the_content(), 25, '...' ); ?> <a href="<?php the_permalink(); ?>" title="<?php esc_html_e( 'Continue reading', 'puca' ); ?>"><?php esc_html_e( 'Continue reading', 'puca' ); ?><i class="icon-arrow-right-circle icons"></i></a></div>
							<?php
							echo '</blockquote>';
						}
					?>
					<?php the_content( esc_html__( 'Read More', 'puca' ) ); ?>
				</div><!-- /entry-content -->
				<?php
					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'puca' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'puca' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					) );
				?>
				<div class="entry-bottom">
				<?php puca_tbay_post_tags(); ?>
				
				<?php 
					puca_tbay_post_share_box();
				?>
				</div>
			
		<?php endif; ?>

    <?php if ( ! is_single() ) : ?>

		<?php if( !puca_tbay_blog_image_sizes_full() ) : ?>
		<?php
			if ( has_excerpt()) {
				echo '<blockquote class="entry-thumb">';
				the_excerpt();
				echo '</blockquote>';
			} else {
				echo '<blockquote class="entry-thumb">';
				?>
					<div class="entry-description"><?php echo puca_tbay_substring(get_the_content(), 25, '...' ); ?> <a href="<?php the_permalink(); ?>" title="<?php esc_html_e( 'Continue reading', 'puca' ); ?>"><?php esc_html_e( 'Continue reading', 'puca' ); ?><i class="icon-arrow-right-circle icons"></i></a></div>
				<?php
				echo '</blockquote>';
			}
		?>
		
	    <div class="entry-content <?php echo ( !has_post_thumbnail() ) ? 'no-thumb' : ''; ?>">
	    	<div class="meta-info">
				<span class="author"><?php echo get_avatar(puca_tbay_get_id_author_post(), 'puca_avatar_post_carousel'); ?> <?php the_author_posts_link(); ?></span>
				<span class="entry-date"><?php echo puca_time_link(); ?></span>
				<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
					<span class="comments-link"><i class="icons icon-bubbles"></i> <?php comments_popup_link( '0', '1', '%' ); ?></span>
				<?php endif; ?>
				
			</div>
	     	 <div class="entry-meta">
	            <?php
	                if (get_the_title()) {
	                ?>
	                    <h4 class="entry-title">
	                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	                    </h4>
	                <?php
	            }
	            ?>
	            
	        </div>
			
			<div class="entry-description"><?php echo puca_tbay_substring(get_the_content(), 25, '' ); ?> </div>
			
	    </div>

	    <?php else : ?>

			<?php
				if ( has_excerpt()) {
					echo '<blockquote>';
					echo puca_tbay_substring(get_the_excerpt(), 17, '');
					echo '</blockquote>';
				} else {
					echo '<blockquote>';
					?>
						<div class="entry-description"><?php echo puca_tbay_substring(get_the_content(), 25, '...' ); ?> <a href="<?php the_permalink(); ?>" title="<?php esc_html_e( 'Continue reading', 'puca' ); ?>"><?php esc_html_e( 'Continue reading', 'puca' ); ?><i class="icon-arrow-right-circle icons"></i></a></div>
					<?php
					echo '</blockquote>';
				}
			?>
			<div class="entry-header">
				<div class="meta-info">
					<span class="author"><?php echo get_avatar(puca_tbay_get_id_author_post(), 'puca_avatar_post_carousel'); ?> <?php the_author_posts_link(); ?></span>

					<span class="entry-date"><?php echo puca_time_link(); ?></span>

					<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
						<span class="comments-link"><i class="icons icon-bubbles"></i> <?php comments_popup_link( '0', '1', esc_html__( '% comments', 'puca' ) ); ?></span>
					<?php endif; ?>

					<span class="entry-category">
			            <i class="icons icon-folder"></i>
			            <?php puca_tbay_get_random_blog_cat(); ?>
			      	</span>
					<span class="post-type"><?php puca_tbay_icon_post_formats(); ?></span>
				</div>
			</div>
		    <div class="entry-content <?php echo ( !has_post_thumbnail() ) ? 'no-thumb' : ''; ?>">
		    	<div class="entry-meta">
		            <?php
		                if (get_the_title()) {
		                ?>
		                    <h3 class="entry-title">
		                       <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		                    </h3>
		                <?php
		            	}
		            ?>
		        </div>
				<div class="entry-description"><?php echo puca_tbay_substring(get_the_content(), 25, '' ); ?>
				</div>
		    </div>

		<?php endif; ?>
    <?php endif; ?>
    <?php if ( is_single() ) : ?>
</div>
<?php endif; ?>
</article>

<?php if ( ! is_single() ) : ?>
</div>
<?php endif; ?>