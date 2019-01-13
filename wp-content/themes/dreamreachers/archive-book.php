<?php
get_header(); 

_s_get_template_part( 'template-parts/books', 'archive-hero' );


?>

<div id="primary" class="content-area">

    <main id="main" class="site-main" role="main">
                
        <?php 

         
        if ( have_posts() ) :
        
           if( function_exists( 'facetwp_display' ) ) {
                printf( '<div class="facetwp-custom-filters"><div class="column row"><div class="filters"><button id="book_category_reset" onclick="FWP.reset(\'book_category\')">All</button>%s</div></div></div>',  facetwp_display( 'facet', 'book_category' ) );
            }
           
           
           echo '<div class="grid-wrapper" data-equalizer="thumbnail" data-equalize-on="medium">';
           
           echo '<div class="row small-up-1 medium-up-2 large-up-3 xlarge-up-4 grid facetwp-template" data-equalizer="panel" data-equalize-on="medium" data-equalize-by-row="true">';
                           
            while ( have_posts() ) :

                the_post();
                
                echo '<div class="column column-block">';
                
                _s_get_template_part( 'template-parts/books', 'book-column' );
                
                echo '</div>';

            endwhile;
            
            echo '</div>';
            
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

<?php
get_footer();
