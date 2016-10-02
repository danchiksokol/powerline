<?php
/**
 * @package topshop premium
 */
$images = get_posts( array("numberposts"=>-1,"post_type"=>"attachment","post_mime_type"=>"image","orderby" => "menu_order", "order" => "ASC","post_parent"=>$post->ID) );
$has_img = 'post-no-img';
if ( has_post_thumbnail() ) {
    $has_img = '';
}
$thumbnail_cut = 'topshop_blog_img_side';
$post_blog_layout = ' blog-post-side-layout';
if ( get_theme_mod( 'topshop-blog-layout', false ) == 'blog-post-top-layout' ) {
    $post_blog_layout = ' blog-post-top-layout';
    $thumbnail_cut = 'topshop_blog_img_top';
} ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $has_img . $post_blog_layout ); ?>>
    
    <?php
    if ( get_theme_mod( 'topshop-blog-list-image-type', false ) == 'blog-use-images-loop' ) : ?>
        <div class="post-loop-images">
            
            <div class="post-loop-images-carousel-wrapper post-loop-images-carousel-wrapper-remove">
                <div class="post-loop-images-prev"><i class="fa fa-angle-left"></i></div>
                <div class="post-loop-images-next"><i class="fa fa-angle-right"></i></div>
                
                <div class="post-loop-images-carousel post-loop-images-carousel-remove">
                    
                    <?php
                    foreach ( $images as $image ) {
                        $title = $image->post_title;
                        $thumbimage = wp_get_attachment_image_src( $image->ID, $thumbnail_cut ); ?>
                        <div><img src="<?php echo $thumbimage[0]; ?>" alt="<?php echo esc_html( $title ) ?>" /></div>
                    <?php
                    } ?>
                
                </div>
                
            </div>
            
        </div>
    <?php else : ?>
        <div class="post-loop-images">
            <?php echo get_the_post_thumbnail( get_the_ID(), $thumbnail_cut ); ?>
        </div>
    <?php endif; ?>
    
    <div class="post-loop-content">
    
    	<header class="entry-header">
    		<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

    		<?php if ( 'post' == get_post_type() ) : ?>
    		<div class="entry-meta">
    			<?php topshop_posted_on(); ?>
    		</div><!-- .entry-meta -->
    		<?php endif; ?>
    	</header><!-- .entry-header -->

    	<div class="entry-content">
    		<?php
    			/* translators: %s: Name of current post */
    			// the_content( sprintf(
    			// 	__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'topshop-premium' ),
    			// 	the_title( '<span class="screen-reader-text">"', '"</span>', false )
    			// ) );
                the_excerpt();
    		?>

    		<?php
    			wp_link_pages( array(
    				'before' => '<div class="page-links">' . __( 'Pages:', 'topshop-premium' ),
    				'after'  => '</div>',
    			) );
    		?>
    	</div><!-- .entry-content -->

    	<footer class="entry-footer">
    		<?php topshop_entry_footer(); ?>
    	</footer><!-- .entry-footer -->
    
    </div>
    
    <div class="clearboth"></div>
</article><!-- #post-## -->