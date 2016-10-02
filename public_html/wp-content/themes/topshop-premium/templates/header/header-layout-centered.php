<?php global $woocommerce; ?>

<?php if( get_theme_mod( 'topshop-show-header-top-bar', false ) ) : ?>
    
    <div class="site-top-bar border-bottom">
        
        <div class="site-container">
            
            <?php if( get_theme_mod( 'topshop-header-search', false ) ) : ?>
                <div class="search-block">
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
            
            <div class="site-top-bar-left">
                
                <?php do_action ( 'topshop_inside_top_bar_left_left' ); ?>
                
                <?php get_template_part( '/templates/social-links' ); ?>
                <?php
                if ( topshop_is_woocommerce_activated() ) { ?>
                    <div class="site-top-bar-left-text"><?php echo wp_kses_post( get_theme_mod( 'topshop-header-info-text', false ) ) ?></div>
                <?php
                } ?>
                
                <?php do_action ( 'topshop_inside_top_bar_left_right' ); ?>
                
            </div>
            <div class="site-top-bar-right">
                
                <?php do_action ( 'topshop_inside_top_bar_right_left' ); ?>
                
                <?php wp_nav_menu( array( 'theme_location' => 'top-bar','container' => false, 'fallback_cb' => false, 'depth'  => 1 ) ); ?>
                
                <?php
                if ( topshop_is_woocommerce_activated() ) { ?>
                
                    <?php if ( !is_user_logged_in() ) { ?>
                        <div class="site-header-right-link"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login','topshop-premium'); ?>"><?php _e('Sign In / Register','topshop-premium'); ?></a></div>
                    <?php } ?>
                    <div class="header-cart">
                        <a class="header-cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'topshop-premium'); ?>">
                            <span class="header-cart-amount">
                                <?php echo sprintf( _n( '(%d)', '(%d)', $woocommerce->cart->cart_contents_count, 'topshop-premium' ), $woocommerce->cart->cart_contents_count ) ;?> - <?php echo $woocommerce->cart->get_cart_total(); ?>
                            </span>
                            <span class="header-cart-checkout<?php echo ( $woocommerce->cart->cart_contents_count > 0 ) ? ' cart-has-items' : ''; ?>">
                                <span></span> <i class="fa fa-shopping-cart"></i>
                            </span>
                        </a>
                    </div>
                    
                <?php
                } else { ?>
                    
                    <div class="site-top-bar-left-text"><?php echo wp_kses_post( get_theme_mod( 'topshop-header-info-text', false ) ) ?></div>
                    
                <?php
                } ?>
                
                <?php do_action ( 'topshop_inside_top_bar_right_right' ); ?>
                
            </div>
            <div class="clearboth"></div>
            
        </div>
    </div>

<?php endif; ?>

<div class="site-container">
    
    <div class="site-header-branding">
        
        <?php if( get_header_image() ) : ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><img src="<?php esc_url( header_image() ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ) ?>" /></a>
        <?php else : ?>
            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
            <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
        <?php endif; ?>
        
    </div>
    
</div>

<nav id="site-navigation" class="main-navigation <?php echo ( get_theme_mod( 'topshop-sticky-header', false ) ) ? ' header-stick' : ''; ?>" role="navigation">
    
    <div class="site-container">
        
        <button class="menu-toggle" aria-controls="menu" aria-expanded="false"><?php _e( 'Menu', 'topshop-premium' ); ?></button>
        <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
        
    </div>
    
</nav><!-- #site-navigation -->