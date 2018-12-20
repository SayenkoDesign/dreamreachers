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

<div class="row column">

    <div id="primary" class="content-area">
    
        <main id="main" class="site-main" role="main">
        
            <header>
                <?php
                if( is_tax() ) {
                    $page_title = single_term_title( '', false );
                }
                else {
                    $page_title = __( 'Projects' );
                }
                
                printf( '<h1 class="page-title">%s</h1>', $page_title );
                ?>
                
            </header>
            
            <?php 
            if( function_exists( 'facetwp_display' ) ) {
                
                $reset = "<div class=\"reset\"><button class=\"button\" onclick=\"FWP.reset()\">Reset</button></div>";
                
                printf( '<div class="facetwp-filters"><div class="wrap"><span>%s</span>%s%s%s%s</div></div>', 
                'Filter By:',
                facetwp_display( 'facet', 'service' ),
                facetwp_display( 'facet', 'location' ),
                facetwp_display( 'facet', 'industry' ),
                $reset
                );
            }
            ?>

            <?php
             
            if ( have_posts() ) : ?>
                
               <?php
               
               echo '<div class="row small-up-1 medium-up-2 large-up-3 grid facetwp-template" data-equalizer data-equalize-on="large" data-equalize-by-row="true">';
                               
                while ( have_posts() ) :
    
                    the_post();
                    
                    echo '<div class="column column-block">';
                    
                    _s_get_template_part( 'template-parts/projects', 'project-column' );
                    
                    echo '</div>';
    
                endwhile;
                
                echo '</div>';
                
                if( function_exists( 'facetwp_display' ) ) {
                    echo facetwp_display( 'pager' );
                }
                else {
                    echo _s_paginate_links();
                }
                                
            else :
    
                get_template_part( 'template-parts/content', 'none' );
    
            endif; ?>
    
        </main>
    
    </div>

</div>
    

<?php
get_footer();
