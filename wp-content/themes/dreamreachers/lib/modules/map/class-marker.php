<?php

namespace PSC;

class Marker {
    
    protected $post_type = 'location';
        
    private $data = [];
    
    protected $fields = [ 'contact_location', 'contact_phone', 'address', 'phone', 'fax', 'email', 'active' ];
    
    
    public function __construct( $marker_id = false ) {
        if ( ! $marker_id = $this->get_marker_id( $marker_id ) ) {
			return false;
		}
	    $this->process_fields( $marker_id );
        $this->get_marker( $marker_id );
	}
    

	private function get_marker_id( $marker ) {
		if ( false === $marker && isset( $GLOBALS['post'], $GLOBALS['post']->ID ) && $this->post_type === get_post_type( $GLOBALS['post']->ID ) ) {
			return $GLOBALS['post']->ID;
		} elseif ( is_numeric( $marker ) ) {
			return $marker;
		} elseif ( $marker instanceof WP_Post ) {
			return get_the_ID();
		} elseif ( ! empty( $marker->ID ) ) {
			return $marker->ID;
		} else {
			return false;
		}
	}
    
    
    public function get_fields() {
        return $this->data;   
    }
    
    
    private function process_fields( $marker_id ) {
        
        $this->data['id'] = $marker_id;
        $this->data['title'] = get_the_title( $marker_id );
        $this->data['region'] = $this->get_region( $marker_id );
        
        foreach( $this->fields as $key ) {
            
            $field = get_field( $key, $marker_id );
            
            if( 'contact_phone' == $key || 'phone' == $key ) {
                $return = _s_format_string( $field, 'a', [ 'href' => _s_format_telephone_url( $field ) ] );
            } else if( 'email' == $key ) {
                $email = antispambot( $field );
                $email_link = sprintf( 'malto:%s', $email );
                $return = _s_format_string( $email, 'a', [ 'href' => $email_link ] );
            } else if( 'fax' == $key ) {
                $return = $field;
            }
            else {
                $return = $field;
            }
            
            $this->data[$key] = $return;
        }
        
    }
    
    private function get_marker( $marker_id ) {
        
        $marker = get_field( 'marker', $marker_id );
        
        if( ! empty( $marker ) ) {
            $this->data['marker'] = sprintf( '<div id="marker-%s" class="marker" data-id="%d" data-region="%s" data-lat="%s" data-lng="%s" data-active="%s">%s</div>', 
                         $marker_id, 
                         $marker_id, 
                         $this->get_data( 'region' ),  
                         $marker['lat'], 
                         $marker['lng'], 
                         $this->get_active( $marker_id ),
                         $this->marker_address()
                         
           );
        }
        
    }
    
    
    public function marker_address() {
        
        $marker = get_field( 'marker', $this->get_data( 'id' ) );
                
        $directions = sprintf( '<span class="directions"><a href="https://www.google.com/maps/dir/?api=1&origin=My+Location&destination=%s,%s">Directions</a> [+]</span>', 
                                $marker['lat'], 
                                $marker['lng']);
        
        return sprintf( '%s%s%s%s%s', 
               
                        sprintf( '<h5>%s</h5>', $this->get_data( 'title' ) ), 
                        $this->get_data( 'address', true ),  
                        $directions,
                        $this->get_data( 'phone', true, 'Phone' ),  
                        $this->get_data( 'fax', true, 'Fax' ),  
                        $this->get_data( 'email', true )
               
               );
    }
        
    
    
    public function contact_details() {
        return sprintf( '<span>%s</span> %s', 
                $this->get_data( 'contact_location' ), 
                $this->get_data( 'contact_phone' )
               );
    }
    
    
    
    public function get_data( $key = false, $format = false, $label = '' ) {
        
        if( empty( $key ) ) {
            return false;
        }
                
        if( $format ) {
            return $this->format_value( $key, $label );
        }
        
        return $this->data[$key];
    }

    
    private function format_value( $key, $label = '' ) {
        
        if( ! empty( $label ) ) {
            $label = $label . ' ';
        }
        
        if( empty( $this->data[$key] ) ) {
            return;
        }
                
        return sprintf( '<span class="%s">%s%s</span>', $key, $label, $this->data[$key] );   
    }
    
    
    private function get_region( $marker_id ) {
        $terms = wp_get_post_terms( $marker_id, 'region' );
        if( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
            $term = array_shift( $terms );
            return $term->slug;
        } 

        return false;  
    }
    
    
    private function get_active( $marker_id ) {
        
        $loop = new \WP_Query( array(
            'post_type' => $this->post_type,
            'posts_per_page' => 1,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ) );
                
        $post_id = false;
                
        if ( $loop->have_posts() ) : 
                                          
            while ( $loop->have_posts() ) :
                            
                $loop->the_post(); 
                                                                
                $post_id = $loop->post->ID;

            endwhile;
                        
        endif; 
        
        wp_reset_postdata();  
        
        return $post_id == $marker_id ? 'true' : 'false'; 
    }
    
}