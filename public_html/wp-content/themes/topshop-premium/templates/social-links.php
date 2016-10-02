<?php
if( get_theme_mod( 'topshop-social-email', false ) ) :
    echo '<a href="' . esc_url( 'mailto:' . antispambot( get_theme_mod( 'topshop-social-email' ), 1 ) ) . '" title="' . __( 'Send Us an Email', 'topshop-premium' ) . '" class="social-email"><i class="fa fa-envelope-o"></i></a>';
endif;

if( get_theme_mod( 'topshop-social-skype', false ) ) :
    echo '<a href="skype:' . esc_html( get_theme_mod( 'topshop-social-skype' ) ) . '?userinfo" title="' . __( 'Contact Us on Skype', 'topshop-premium' ) . '" class="social-skype"><i class="fa fa-skype"></i></a>';
endif;

if( get_theme_mod( 'topshop-social-facebook', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'topshop-social-facebook' ) ) . '" target="_blank" title="' . __( 'Find Us on Facebook', 'topshop-premium' ) . '" class="social-facebook"><i class="fa fa-facebook"></i></a>';
endif;

if( get_theme_mod( 'topshop-social-twitter', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'topshop-social-twitter' ) ) . '" target="_blank" title="' . __( 'Follow Us on Twitter', 'topshop-premium' ) . '" class="social-twitter"><i class="fa fa-twitter"></i></a>';
endif;

if( get_theme_mod( 'topshop-social-google-plus', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'topshop-social-google-plus' ) ) . '" target="_blank" title="' . __( 'Find Us on Google Plus', 'topshop-premium' ) . '" class="social-gplus"><i class="fa fa-google-plus"></i></a>';
endif;

if( get_theme_mod( 'topshop-social-youtube', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'topshop-social-youtube' ) ) . '" target="_blank" title="' . __( 'View our YouTube Channel', 'topshop-premium' ) . '" class="social-youtube"><i class="fa fa-youtube"></i></a>';
endif;

if( get_theme_mod( 'topshop-social-vimeo', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'topshop-social-vimeo' ) ) . '" target="_blank" title="' . __( 'View our Vimeo Channel', 'topshop-premium' ) . '" class="social-youtube"><i class="fa fa-vimeo"></i></a>';
endif;

if( get_theme_mod( 'topshop-social-instagram', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'topshop-social-instagram' ) ) . '" target="_blank" title="' . __( 'Follow Us on Instagram', 'topshop-premium' ) . '" class="social-instagram"><i class="fa fa-instagram"></i></a>';
endif;

if( get_theme_mod( 'topshop-social-pinterest', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'topshop-social-pinterest' ) ) . '" target="_blank" title="' . __( 'Pin Us on Pinterest', 'topshop-premium' ) . '" class="social-pinterest"><i class="fa fa-pinterest"></i></a>';
endif;

if( get_theme_mod( 'topshop-social-linkedin', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'topshop-social-linkedin' ) ) . '" target="_blank" title="' . __( 'Find Us on LinkedIn', 'topshop-premium' ) . '" class="social-linkedin"><i class="fa fa-linkedin"></i></a>';
endif;

if( get_theme_mod( 'topshop-social-vk', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'topshop-social-vk' ) ) . '" target="_blank" title="' . __( 'Find Us on Vkontakte', 'topshop-premium' ) . '" class="social-linkedin"><i class="fa fa-vk"></i></a>';
endif;

if( get_theme_mod( 'topshop-social-tumblr', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'topshop-social-tumblr' ) ) . '" target="_blank" title="' . __( 'Find Us on Tumblr', 'topshop-premium' ) . '" class="social-tumblr"><i class="fa fa-tumblr"></i></a>';
endif;

if( get_theme_mod( 'topshop-social-flickr', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'topshop-social-flickr' ) ) . '" target="_blank" title="' . __( 'Find Us on Flickr', 'topshop-premium' ) . '" class="social-flickr"><i class="fa fa-flickr"></i></a>';
endif;

if( get_theme_mod( 'topshop-social-git', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'topshop-social-git' ) ) . '" target="_blank" title="' . __( 'Find Us on GitHub', 'topshop-premium' ) . '" class="social-tumblr"><i class="fa fa-git-square"></i></a>';
endif;

if( get_theme_mod( 'topshop-social-bbucket', false ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'topshop-social-bbucket' ) ) . '" target="_blank" title="' . __( 'Find Us on BitBucket', 'topshop-premium' ) . '" class="social-facebook"><i class="fa fa-bitbucket-square"></i></a>';
endif;

if( get_theme_mod( 'topshop-header-search', false ) ) :
    echo '<i class="fa fa-search search-btn"></i>';
endif; ?>