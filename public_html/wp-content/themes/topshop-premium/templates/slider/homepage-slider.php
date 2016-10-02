<?php
if ( get_theme_mod( 'topshop-slider-type', false ) == 'topshop-no-slider' ) : ?>
    
    <!-- No Slider -->
    
<?php
elseif ( get_theme_mod( 'topshop-slider-type', false ) == 'topshop-meta-slider' ) : ?>
    
    <?php
    $slider_code = '';
    if ( get_theme_mod( 'topshop-meta-slider-shortcode', false ) ) {
        $slider_code = get_theme_mod( 'topshop-meta-slider-shortcode' );
    } ?>
    
    <?php echo do_shortcode( esc_html( $slider_code ) ); ?>
    
<?php else : ?>
    
    <?php
    $slider_cats = '';
    if ( get_theme_mod( 'topshop-slider-cats', false ) ) {
        $slider_cats = get_theme_mod( 'topshop-slider-cats' );
    } ?>
    
    <?php if( $slider_cats ) : ?>
        
        <?php $slider_query = new WP_Query( 'cat=' . esc_html( $slider_cats ) . '&posts_per_page=-1&orderby=date&order=DESC' ); ?>
        
        <?php if ( $slider_query->have_posts() ) : ?>

            <div class="home-slider-wrap home-slider-remove" data-auto="<?php echo ( get_theme_mod( 'topshop-slider-auto-scroll', false ) ) ? 'false' : '5500'; ?>">
                <div class="home-slider-prev"><i class="fa fa-angle-left"></i></div>
                <div class="home-slider-next"><i class="fa fa-angle-right"></i></div>
                
                <div class="home-slider">
                    
                    <?php while ( $slider_query->have_posts() ) : $slider_query->the_post(); ?>
                        
                        <?php if ( get_theme_mod( 'topshop-slider-linkto-post', false ) ) : ?>
                        <a class="home-slider-block" href="<?php the_permalink(); ?>">
                        <?php else : ?>
                        <div class="home-slider-block">
                        <?php endif; ?>
                            
                            <?php if ( has_post_thumbnail() ) : ?>
                            
                                <?php the_post_thumbnail( 'full', array( 'class' => '' ) ); ?>
                                
                            <?php endif; ?>
                            
                            <?php if ( !get_theme_mod( 'topshop-slider-remove-title', false ) ) : ?>
                                
                                <div class="home-slider-block-inner">
                                    <h3>
                                        <?php the_title(); ?>
                                    </h3>
                                    <?php the_content(); ?>
                                </div>
                                
                            <?php endif; ?>
                            
                        <?php if ( get_theme_mod( 'topshop-slider-linkto-post', false ) ) : ?>
                        </a>
                        <?php else : ?>
                        </div>
                        <?php endif; ?>
                    
                    <?php endwhile; ?>
                    
                </div>
                <div class="clearboth"></div>
                <?php do_action ( 'topshop_after_default_slider' ); ?>
            </div>
            
        <?php endif; wp_reset_query(); ?>
        
    <?php else : ?>
        
        <div class="home-slider-wrap home-slider-remove" data-auto="<?php echo ( get_theme_mod( 'topshop-slider-auto-scroll', false ) ) ? 'false' : '5500'; ?>">
            <div class="home-slider-prev"><i class="fa fa-angle-left"></i></div>
            <div class="home-slider-next"><i class="fa fa-angle-right"></i></div>
                
            <div class="home-slider">
                
                <div class="home-slider-block">
                    
                    <img src="<?php echo get_template_directory_uri() ?>/images/demo/slider_default_01.jpg" alt="<?php esc_attr_e('Demo Slide One', 'topshop-premium') ?>" />
                    
                    <?php if ( !get_theme_mod( 'topshop-slider-remove-title', false ) ) : ?>
                        
                        <div class="home-slider-block-inner">
                            <h3>
                                <?php _e( 'A Little Extra Thought', 'topshop-premium' ); ?>
                            </h3>
                            <p><?php _e( 'We take extra thought and put it into our themes', 'topshop-premium' ); ?></p>
                        </div>
                        
                    <?php endif; ?>
                    
                </div>
                
                <div class="home-slider-block">
                    
                    <img src="<?php echo get_template_directory_uri() ?>/images/demo/slider_default_02.jpg" alt="<?php esc_attr_e('Demo Slide Two', 'topshop-premium') ?>" />
                    
                    <?php if ( !get_theme_mod( 'topshop-slider-remove-title', false ) ) : ?>
                        
                        <div class="home-slider-block-inner">
                            <h3>
                                <?php _e( 'Online Shopping', 'topshop-premium' ); ?>
                            </h3>
                            <p><?php _e( 'Install WooCommerce to start building your online store', 'topshop-premium' ); ?></p>
                        </div>
                        
                    <?php endif; ?>
                    
                </div>
                
            </div>
            <div class="clearboth"></div>
            <?php do_action ( 'topshop_after_default_slider' ); ?>
        </div>

    <?php endif; ?>
    
<?php endif; ?>