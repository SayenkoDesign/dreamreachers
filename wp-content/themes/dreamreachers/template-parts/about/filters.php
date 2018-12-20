<?php

function region_filters() {
                    
    $taxonomies = array( 
        'region',
    );

    $args = array(
        'orderby'           => 'id', 
        'order'             => 'ASC',
        'hide_empty'        => true,
        'post_type' => array( 'people' ),
    ); 

    $terms = get_terms( $taxonomies, $args );
    

    $filters = sprintf( '<li><button data-filter="*" class="active">%s</button></li>', __('All', '_s') );
    
    foreach ( $terms as $term ) : 
        $filters .= sprintf( '<li class=""><button data-filter=".%s">%s</button></li>', 
                              sanitize_title( 'region-' . $term->name ), $term->name );
    endforeach;
    
    $filters = sprintf( '<div class="filter-button-group"><ul class="no-bullet">%s</ul></div>', $filters );
   
    echo '<div class="filters">';
    
    printf( '<div class="hide-for-large text-center">
            <button class="button green" type="button" data-toggle="region-filters">Filter</button>
             <div class="dropdown-pane center" id="region-filters" data-dropdown data-close-on-click>%s</div></div>', $filters );
            
    
    printf( '<div class="show-for-large">%s</div>', $filters );

    echo '</div>';
}
region_filters();