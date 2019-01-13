<?php
/**
 * Project - Column
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php
    $thumbnail = get_the_post_thumbnail( get_the_ID(), 'thumbnail-book' );
    $author = get_field( 'author' );
                                                            
    printf( '<div class="thumbnail" data-equalizer-watch="thumbnail">%s</div><div class="panel" data-equalizer-watch="panel">%s%s</div>', 
            $thumbnail, 
            sprintf( '<h3>%s</h3>', get_the_title() ),
            _s_format_string( $author, 'p' )
           );
    ?>
</article><!-- #post-## -->
