<?php
/*
Template Name: Contact
*/


get_header(); 

_s_get_template_part( 'template-parts/contact', 'hero' );
?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">
	<?php
    section_default();
	function section_default() {
				
		global $post;
		
		$attr = array( 'class' => 'section-default' );
		
		$args = array(
            'html5'   => '<section %s>',
            'context' => 'section',
            'attr' => $attr,
        );
        
        _s_markup( $args );
        
        _s_structural_wrap( 'open' );
		
		print( '<div class="row large-unstack">' );
		
		while ( have_posts() ) :

			the_post();
            
            print( '<div class="column small-collaspe small-order-2 large-order-1">' );
                $markers = psc_map_get_markers();
                $markers = wp_list_pluck( $markers, 'marker' );
                $markers = join( '', $markers );
                // $legend = sprintf( '<div class="column row">%s</div>', psc_map_get_legend() );
                $legend = psc_map_get_legend();
                printf( '%s<div class="contact-map"><div class="acf-map google-map">%s</div></div>', $legend, $markers );
            echo '</div>';
                
            print( '<div class="column small-order-1 large-order-2">' );
                        
            echo '<div class="entry-content">';
            
            the_content();
            
            echo '</div>';
            
            echo '</div>';
            				
		endwhile;
		
		print( '</div>' );
        
		_s_structural_wrap( 'close' );
	    echo '</section>';
	}
	?>
	</main>


</div>

<?php
get_footer();
