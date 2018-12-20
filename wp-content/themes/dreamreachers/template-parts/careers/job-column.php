<?php
/**
 * Project - Column
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php                                                            
    printf( '<div class="panel" data-equalizer-watch><a href="%s">%s</a>', 
            get_permalink(),
            the_title( '<h3>', '</h3>', false )                      
          );
          
    echo '<ul class="no-bullet info">';
    $location = get_field( 'location' );
    $address_icon = sprintf( '<img src="%scareers/address-icon.svg" />', trailingslashit( THEME_IMG ) );
    printf( '<li class="address">%s<span>%s</span></li>', $address_icon, $location );
    
    $closing_date = get_field( 'closing_date' );
    $date = new DateTime( $closing_date );
    $closing_icon = sprintf( '<img src="%scareers/closing-icon.svg" />', trailingslashit( THEME_IMG ) );
    printf( '<li>%s<span>Closing %s</span></li>', $closing_icon, $date->format('F d, Y') );
    echo '</ul>';
    
    echo '</div>';
    ?>
    
    <footer class="entry-footer">
    <?php
        
    printf( '<p><a href="%s#section-apply-now" class="link">Apply Now</a></p>', get_permalink() )
    ?>
    </footer>
    
</article><!-- #post-## -->
