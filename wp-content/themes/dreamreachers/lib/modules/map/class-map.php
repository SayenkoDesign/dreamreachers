<?php

namespace PSC;

class Map {
    
    protected $post_type = 'location';
    
    public function __construct() {
	    
	}
    
        
    public function get_markers() {
        
        $loop = new \WP_Query( array(
            'post_type' => $this->post_type,
            'posts_per_page' => 100,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ) );
                
        $markers = [];
                
        if ( $loop->have_posts() ) : 
                                          
            while ( $loop->have_posts() ) :
                            
                $loop->the_post(); 
                
                $sm = new Marker;
                                                
                $markers[$loop->post->ID] = $sm->get_fields();

            endwhile;
                        
        endif; 
        
        wp_reset_postdata();
        
        return $markers;
    }
        
    
    public function get_legend() {
        
        $terms = $this->get_terms();
                        
        $list = '';
                
        foreach( $terms as $term ) {
                        
            $criteria = array('region' => $term->slug );
            $markers = wp_list_filter( $this->get_markers(), $criteria );
                        
            $children  = [];
            if( ! empty( $markers ) ) {
                
                $i = 0;
                
                foreach( $markers as $key => $marker ) {
                    $children[] = sprintf( '<span class="marker-anchor" data-marker-id="%s">%s</span>', $marker['id'], $marker['title'] );
                }
            }
            
            $list .= sprintf( '<li id="%s"><a href="#">%s</a>%s</li>', $term->slug, $term->name, ul( $children, [ 'class' => 'no-bullet' ] ) );
        }
                
        return sprintf( '<ul id="map-legend" class="accordion-menu no-bullet map-legend" data-accordion-menu data-multi-open="false" data-slide-speed="0">%s</ul>', $list );
    }
       
    
    protected function get_terms() {
        
        $terms = get_terms( array(
            'taxonomy' => 'region',
            'hide_empty' => true,
            'post_type' => array( $this->post_type ),

        ) );
        
        if( is_wp_error( $terms ) || empty( $terms ) ) {
            return false;
        } 
        
        return $terms;   
    }
    
}