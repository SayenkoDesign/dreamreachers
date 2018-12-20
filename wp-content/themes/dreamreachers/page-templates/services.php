<?php
/*
Template Name: Services
*/


/**
 * Custom Body Class
 *
 * @param array $classes
 * @return array
 */
function kr_body_class( $classes ) {
  unset( $classes[array_search('page-template-default', $classes )] );
  $classes[] = 'page-builder';
  return $classes;
}
add_filter( 'body_class', 'kr_body_class', 99 );

get_header(); ?>

<?php
    _s_get_template_part( 'template-parts/global', 'hero' );
    _s_get_template_part( 'template-parts/services', 'background-image' );
?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">
         
	<?php
    while ( have_posts() ) :

        the_post();

        get_template_part( 'template-parts/content', 'services' );

        endwhile; 	
	?>
    
	</main>


</div>

<?php
get_footer();
