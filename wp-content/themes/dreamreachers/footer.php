<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */
?>

</div><!-- #content -->

<?php
   _s_get_template_part( 'template-parts/global', 'footer-cta' );
?>

<footer class="site-footer" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
    <div class="wrap">
    
        <div class="row large-unstack footer-widgets">
        
            <div class="column footer-widgets-left"> 
            
                <div class="row medium-unstack align-center">
                    <?php
                    printf( '<div class="%s column column-block" id="locations-footer">', '' );
                    if( is_active_sidebar( 'footer-1' ) ){
                        dynamic_sidebar( 'footer-1' );
                    }
                    echo '</div>';
                    
                    printf( '<div class="%s column column-block">', '' );
                    if( is_active_sidebar( 'footer-2' ) ){
                        dynamic_sidebar( 'footer-2' );
                    }
                    echo '</div>';
                    ?>
                </div>
            
            </div>
            
            <div class="column show-for-xlarge footer-widgets-center">
                <?php
                printf( '<div class="footer-icon"><img src="%sfooter/footer-icon.png" /></div>', trailingslashit( THEME_IMG ) );
                ?>
            </div>
            
            <div class="column footer-widgets-right"> 
            
                <div class="row align-top">
                    <?php
                    printf( '<div class="%s column">', '' );
                    if( is_active_sidebar( 'footer-3' ) ){
                        dynamic_sidebar( 'footer-3' );
                    }
                    echo '</div>';
                    ?>
                </div>
            
            </div>
                            
        </div>   
    
        <?php  
        
        if( has_nav_menu( 'footer' ) ) {
        $args = array( 
        'theme_location'  => 'footer', 
            'container'       => false,
            'echo'            => false,
            'items_wrap'      => '%3$s',
            'link_before'     => '<span>',
            'link_after'      => '</span>',
            'depth'           => 0,
        ); 
        
        $menu = sprintf( '%s', str_replace('<a', ' <a', strip_tags( wp_nav_menu( $args ), '<a>' ) ) );
        
    }
        
                  
        $copyright = sprintf( '<p>&copy; %s Power Systems Consultants, Inc. All rights reserved.%s</p>', 
                                  date( 'Y' ), $menu );
                                                    
        printf( '<div class="column row footer-copyright">%s</div>', $copyright );

        ?>
     </div>
 
 </footer><!-- #colophon -->

<?php 
 
wp_footer(); 
?>
</body>
</html>
