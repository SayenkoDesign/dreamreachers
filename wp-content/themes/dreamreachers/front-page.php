<?php
/**
 * Custom Body Class
 *
 * @param array $classes
 * @return array
 */

add_filter( 'body_class', function( $classes ) {
    unset( $classes[array_search('page-template-default', $classes )] );
    return $classes;
}, 99 );

get_header(); ?>

<?php
_s_get_template_part( 'template-parts/home', 'hero' );
?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">
     
	<?php
     _s_get_template_part( 'template-parts/home', 'numbers' );
     
     _s_get_template_part( 'template-parts/home', 'what-we-do' );
     
     _s_get_template_part( 'template-parts/home', 'why' );
     
     _s_get_template_part( 'template-parts/global', 'clients' );
     
     _s_get_template_part( 'template-parts/home', 'projects' );
    
     _s_get_template_part( 'template-parts/home', 'locations' );
   	?>
        
	</main>


</div>

<?php
get_footer();
