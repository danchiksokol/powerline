<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package topshop premium
 */
?>
</div><!-- #content -->

<?php do_action ( 'topshop_before_footer' ); ?>

<footer id="colophon" class="site-footer" role="contentinfo">
	
	<?php do_action ( 'topshop_inside_footer_before_widgets' ); ?>
	
	<div class="site-footer-widgets">
        <div class="site-container">
            <ul>
                <?php dynamic_sidebar( 'topshop-site-footer' ); ?>
            </ul>
            <div class="clearboth"></div>
        </div>
    </div>
    
    <?php do_action ( 'topshop_inside_footer_after_widgets' ); ?>
	
	<div class="site-footer-bottom-bar">
	
		<div class="site-container">
			
			<div class="site-footer-bottom-bar-left">
                
                <?php echo wp_kses_post( get_theme_mod( 'topshop-website-txt-copy', 'TopShop theme, by <a href="http://kairaweb.com">Kaira</a>' ) ) ?>
                
			</div>
	        
	        <div class="site-footer-bottom-bar-right">
                
	            <?php wp_nav_menu( array( 'theme_location' => 'footer-bar','container' => false, 'fallback_cb' => false, 'depth'  => 1 ) ); ?>
                
	        </div>
	        
	    </div>
		
        <div class="clearboth"></div>
	</div>
	
</footer><!-- #colophon -->

<?php do_action ( 'topshop_after_footer' ); ?>

<?php
if ( get_theme_mod( 'topshop-site-layout', false ) == 'topshop-layout-boxed' ) { ?>
</div>
<?php
} ?>

<?php wp_footer(); ?>
</body>
</html>