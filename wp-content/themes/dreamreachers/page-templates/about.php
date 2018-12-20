<?php
/*
Template Name: About
*/

add_filter( 'body_class', function ( $classes ) {
  unset( $classes[ array_search('page-template-default', $classes ) ] );
  return $classes;
}, 99 );

get_header(); ?>

<?php
_s_get_template_part( 'template-parts/about', 'hero' );
?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">
	<?php
        _s_get_template_part( 'template-parts/about', 'mission' );
        _s_get_template_part( 'template-parts/about', 'vision' );
        _s_get_template_part( 'template-parts/about', 'values' );
        _s_get_template_part( 'template-parts/about', 'story' );
        _s_get_template_part( 'template-parts/about', 'company' );
        _s_get_template_part( 'template-parts/about', 'leadership' );
	?>
	</main>


</div>

<?php
get_footer();
