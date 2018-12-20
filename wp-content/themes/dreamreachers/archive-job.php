<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

get_header(); ?>

<?php
_s_get_template_part( 'template-parts/careers', 'hero' );
?>

<div id="primary" class="content-area">

    <?php
    _s_get_template_part( 'template-parts/careers', 'why' );
     
    _s_get_template_part( 'template-parts/careers', 'search' );
    ?>

    <main id="main" class="site-main" role="main">
    
        <?php

        if ( have_posts() ) :
            
           
           if( function_exists( 'facetwp_display' ) ) {
                
                $reset = "<div class=\"reset\"><button class=\"button\" onclick=\"FWP.reset()\">Reset</button></div>";
                
                printf( '<div class="column row"><div class="facetwp-filters"><div class="wrap"><span>%s</span>%s%s%s</div></div></div>', 
                'Filter By:',
                facetwp_display( 'facet', 'job_function' ),
                facetwp_display( 'facet', 'location' ),
                $reset
                );
            }
        
            echo'<div class="row small-up-1 medium-up-2 large-up-3 xlarge-up-4 grid facetwp-template" data-equalizer data-equalize-on="medium" data-equalize-by-row="true">';
                                                          
            while ( have_posts() ) :

                the_post(); 
                    
                printf( '<div class="column column-block">%s</div>', 
                        _s_get_template_part( 'template-parts/careers', 'job-column', [], true ) );

            endwhile;
            
            echo '</div>';
                
        endif; 
        
                    
        
        ?>

    </main>
    
    <?php
    _s_get_template_part( 'template-parts/careers', 'scholarship' );
    ?>

</div>

<?php
get_footer();
