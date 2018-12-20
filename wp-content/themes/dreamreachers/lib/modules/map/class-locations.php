<?php

namespace PSC;

class Locations extends Map {
        
    
    public function __construct() {
	    parent::__construct();
	}
    
    
    public function get_locations() {
        
        $terms = $this->get_terms();
        
        $map_markers = $this->get_markers();
        
        $out = '';
                
        foreach( $terms as $term ) {
                        
            $criteria = array('region' => $term->slug );
            $markers = wp_list_filter( $map_markers, $criteria );
                        
            $list  = [];
            
            if( ! empty( $markers ) ) {
                foreach( $markers as $marker ) {
                    
                    $sm = new Marker( $marker['id'] );
                    $list[] = $sm->marker_address();                      
                }
                
                $children = sprintf( '%s', ul( $list, [ 'class' => 'no-bullet' ] ) );  
                
                $out .= sprintf( '<li class="accordion-item" data-accordion-item><a href="#" class="accordion-title"><h4>%s</h4></a>
                                 <div class="accordion-content" data-tab-content>%s</div></li>', 
                                 $term->name, 
                                 $children ); 
            }            
            
        }
        
        return sprintf( '<ul class="accordion" data-accordion data-allow-all-closed="true">%s</ul>', $out );
    } 
    
    
    public function get_gf_field_locations() {
        
        $terms = $this->get_terms();
        
        $map_markers = $this->get_markers();
        
        $list  = [];
                
        foreach( $terms as $term ) {
                        
            $criteria = array('region' => $term->slug );
            $markers = wp_list_filter( $map_markers, $criteria );
                                    
            if( ! empty( $markers ) ) {
                foreach( $markers as $marker ) {
                    $sm = new Marker( $marker['id'] );
                    $location = sprintf( '%s - %s', $sm->get_data( 'title' ), $term->name );
                    $list[] = $location;                      
                }
                
            }            
            
        }
        
        return $list;
    } 
    
    
    public function get_menu() {
        
        $terms = $this->get_terms();
        $map_markers = $this->get_markers();
        
        $out = '';
                
        foreach( $terms as $term ) {
                        
            $criteria = array('region' => $term->slug );
            $markers = wp_list_filter( $map_markers, $criteria );
                        
            $list  = [];
            
            if( ! empty( $markers ) ) {
                foreach( $markers as $marker ) {
                    
                    $sm = new Marker( $marker['id'] );
                    $list[] = $sm->contact_details();                      
                }
                
                $children = sprintf( '<li class="menu-item"><h5>%s</h5><div>%s</div></li>', $term->name, ul( $list, [ 'class' => 'locations' ] ) );  
                
                $out .= sprintf( '<li class="menu-item menu-item-has-children"><a class="location">%s</a><ul class="sub-menu">%s</ul></li>', 
                                 $term->name, $children ); 
            }            
            
        }
        
        return $out;
    }    
    
}